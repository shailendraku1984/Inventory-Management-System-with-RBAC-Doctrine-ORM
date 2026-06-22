<?php

namespace App\Services;

use App\Entities\UserProfile;
use App\Interfaces\Repository\UserProfileRepositoryInterface;
use App\Interfaces\Service\ProfileServiceInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use DateTime;
use InvalidArgumentException;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        private readonly UserProfileRepositoryInterface $profiles,
        private readonly ProfilePictureStorage $pictureStorage,
    ) {
    }

    public function updatePicture(int $userId, UploadedFile $picture): string
    {
        if ($userId <= 0) {
            throw new InvalidArgumentException('Invalid user.');
        }

        $picturePath = $this->pictureStorage->storeAsWebp($picture);

        $profile = $this->profiles->findByUserId($userId) ?? (new UserProfile())->setUserId($userId);

        $profile
            ->setPicture($picturePath)
            ->setUpdatedAt(new DateTime());

        $this->profiles->save($profile);

        return $picturePath;
    }
}
