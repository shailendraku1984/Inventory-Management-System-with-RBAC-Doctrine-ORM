<?php

namespace App\Services;

use App\Entities\Users;
use App\Entities\UserProfile;
use App\Interfaces\Repository\UserRepositoryInterface;
use App\Interfaces\Service\AuthServiceInterface;
use DateTime;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $users
    ) {
    }

    public function attempt(string $email, string $password): array
    {
        $email = strtolower(trim($email));

        if ($email === '' || $password === '') {
            return [
                'success' => false,
                'message' => 'Email and password are required.',
                'user' => null,
            ];
        }

        $user = $this->users->findByEmail($email);

        if ($user === null || ! password_verify($password, $user->getPassword())) {
            return [
                'success' => false,
                'message' => 'Invalid email or password.',
                'user' => null,
            ];
        }

        if (! $user->isActive()) {
            return [
                'success' => false,
                'message' => 'This account is disabled.',
                'user' => null,
            ];
        }

        if (password_needs_rehash($user->getPassword(), PASSWORD_DEFAULT)) {
            $user->setPasswordHash($password);
        }

        $user->setLastLogin(new DateTime());
        $user->setUpdatedAt(new DateTime());
        $this->users->save($user);

        return [
            'success' => true,
            'message' => 'Welcome back, ' . $user->getName() . '.',
            'user' => $user,
        ];
    }

    public function sessionPayload(Users $user): array
    {
            $picturePath="uploads/user_profiles/default.png";		 
			$entityManager = service('doctrine')->getEntityManager();
            $connection = $entityManager->getConnection();
 
            $sql = "select picture from user_profile where user_id = :userId";
            $statement = $connection->prepare($sql);
            $statement->bindValue('userId', $user->getId(), \Doctrine\DBAL\ParameterType::INTEGER);
 			$result = $statement->executeQuery();

 			$profile = $result->fetchAssociative(); 
			
			if ($profile && isset($profile['picture'])) {
	            $picturePath = $profile['picture'];
	        }			
             
		 
        return [
            'isLoggedIn' => true,
            'auth_user_id' => $user->getId(),
            'auth_user_name' => $user->getName(),
            'auth_user_email' => $user->getEmail(),
            'auth_user_role' => $user->getRoleLabel(),
			'picture' => $picturePath,
        ];
    }

    public function currentUser(): ?Users
    {
        $userId = session()->get('auth_user_id');

        if (! is_numeric($userId)) {
            return null;
        }

        return $this->users->findById((int) $userId);
    }
}
