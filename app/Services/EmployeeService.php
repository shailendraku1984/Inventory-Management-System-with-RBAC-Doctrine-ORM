<?php

namespace App\Services;

use App\Entities\UserProfile;
use App\Entities\Users;
use App\Interfaces\Repository\BranchRepositoryInterface;
use App\Interfaces\Repository\EmployeeRepositoryInterface;
use App\Interfaces\Repository\RoleRepositoryInterface;
use App\Interfaces\Repository\UserProfileRepositoryInterface;
use App\Interfaces\Service\EmployeeServiceInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use DateTime;
use InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

class EmployeeService implements EmployeeServiceInterface
{
    
    public function __construct(
        private readonly EmployeeRepositoryInterface $employees,
        private readonly UserProfileRepositoryInterface $profiles,
        private readonly RoleRepositoryInterface $roles,
        private readonly BranchRepositoryInterface $branches,
    ) {
         
    }

    public function list(): array
    {
        return $this->employees->allActive();
    }

    public function find(int $id): ?object
    {
        return $this->employees->findActive($id);
    }

    public function profileFor(int $userId): ?object
    {
        return $this->profiles->findByUserId($userId);
    }
	
	 
    public function save(array $data, ?int $id = null): object
    {
        return $this->saveWithProfile($data, null, $id);
    }

    public function getEntityManager(): \Doctrine\ORM\EntityManagerInterface
	{
		// If your repository uses standard Doctrine names:
		return $this->_em; 
		
		// OR if your repo uses an injected property like $this->entityManager:
		// return $this->entityManager;
	}

    public function saveWithProfile(array $data, ?UploadedFile $picture = null, ?int $id = null): object
    {
        $user = $id ? $this->employees->findActive($id) : new Users();

        if ($user === null) {
            throw new InvalidArgumentException('Employee not found.');
        }

        $name = trim((string) ($data['name'] ?? ''));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $role = (string) ($data['role'] ?? Users::ROLE_USER);
        $password = (string) ($data['password'] ?? '');
        $confirmPassword = (string) ($data['confirm_password'] ?? '');

        if ($name === '' || $email === '') {
            throw new InvalidArgumentException('Name and email are required.');
        }

        if ($this->employees->findByEmail($email, $id) !== null) {
            throw new InvalidArgumentException('Email already exists.');
        }

        $user->setRole($role);

        if (! array_key_exists($user->getRole(), Users::ROLE_LABELS)) {
            throw new InvalidArgumentException('Invalid role selected.');
        }

        if ($id === null || $password !== '') {
            if (strlen($password) < 8) {
                throw new InvalidArgumentException('Password must be at least 8 characters.');
            }

            if ($password !== $confirmPassword) {
                throw new InvalidArgumentException('Password and confirm password must match.');
            }

            $user->setPasswordHash($password);
        }

        $branchId = (int) ($data['branch_id'] ?? 0);
        if ($user->getRole() === Users::ROLE_EMPLOYEE && $branchId <= 0) {
            throw new InvalidArgumentException('Branch is required for employee role.');
        }

        $user
            ->setName($name)
            ->setEmail($email)
            ->setBranchId($user->getRole() === Users::ROLE_EMPLOYEE ? $branchId : null)
            ->setIsActive((bool) ((int) ($data['is_active'] ?? 1)));

        if ($id !== null) {
            $user->setUpdatedAt(new DateTime());
        }

        $this->employees->save($user);
        $this->saveProfile($user, $data, $picture);
        
		// 1. Fetch the generated or existing User ID
        $userId = $user->getId(); 
        
        // 2. Fetch the numeric Role ID from the submitted form payload array
        $roleId = (int) ($data['role'] ?? 0); 
         
            if ($userId && $roleId) {
             $entityManager = service('doctrine')->getEntityManager();
             $connection = $entityManager->getConnection();

            // Secure DBAL Upsert query execution
            $sql = "INSERT INTO role_user (user_id, role_id) 
                    VALUES (:userId, :roleId) 
                    ON DUPLICATE KEY UPDATE role_id = :roleId";

            $statement = $connection->prepare($sql);
            $statement->bindValue('userId', $userId, \Doctrine\DBAL\ParameterType::INTEGER);
            $statement->bindValue('roleId', $roleId, \Doctrine\DBAL\ParameterType::INTEGER);
            
            $statement->executeStatement();
        }
		 		
        return $user;
    }

    public function delete(int $id): void
    {
        $user = $this->employees->findActive($id);

        if ($user === null) {
            throw new InvalidArgumentException('Employee not found.');
        }

        $this->employees->softDelete($user);
    }

    public function formOptions(): array
    {
        return [
            'roles' => $this->roles->all(),
            'branches' => $this->branches->allActive(),
        ];
    }

    private function saveProfile(Users $user, array $data, ?UploadedFile $picture): void
    {
        $userId = (int) $user->getId();
        $profile = $this->profiles->findByUserId($userId) ?? (new UserProfile())->setUserId($userId);
        $isEmployee = $user->getRole() === Users::ROLE_EMPLOYEE;
        $empCode = trim((string) ($data['emp_code'] ?? ''));

        if ($isEmployee && $empCode === '') {
            $empCode = $this->nextEmployeeCode($userId);
        }

        if ($empCode !== '' && $this->profiles->findByEmpCode($empCode, $userId) !== null) {
            throw new InvalidArgumentException('Employee code already exists.');
        }

        $salary = $data['salary'] ?? null;
        if ($isEmployee && ($salary === null || $salary === '' || ! is_numeric($salary) || (float) $salary < 0)) {
            throw new InvalidArgumentException('Valid salary is required for employee role.');
        }

        $picturePath = $this->storePicture($picture) ?? $profile->getPicture();

        $profile
            ->setPicture($picturePath)
            ->setEmpCode($isEmployee ? $empCode : null)
            ->setSalary($isEmployee ? (string) $salary : null)
            ->setAddress($data['address'] ?? null)
            ->setUpdatedAt(new DateTime());

        $this->profiles->save($profile);
    }

    private function nextEmployeeCode(int $userId): string
    {
        return 'EMP' . str_pad((string) $userId, 5, '0', STR_PAD_LEFT);
    }

    private function storePicture(?UploadedFile $picture): ?string
    {
        if ($picture === null || ! $picture->isValid() || $picture->getSize() === 0) {
            return null;
        }

        $mime = $picture->getMimeType();
        $source = match ($mime) {
            'image/jpeg', 'image/jpg' => imagecreatefromjpeg($picture->getTempName()),
            'image/png' => imagecreatefrompng($picture->getTempName()),
            'image/gif' => imagecreatefromgif($picture->getTempName()),
            'image/webp' => imagecreatefromwebp($picture->getTempName()),
            default => false,
        };

        if ($source === false) {
            throw new InvalidArgumentException('Profile picture must be JPG, PNG, GIF, or WEBP.');
        }

        $directory = FCPATH . 'uploads/user_profiles';
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $fileName = uniqid('profile_', true) . '.webp';
        $target = $directory . DIRECTORY_SEPARATOR . $fileName;
        imagepalettetotruecolor($source);
        imagewebp($source, $target, 85);
        imagedestroy($source);

        return 'uploads/user_profiles/' . $fileName;
    }
}
