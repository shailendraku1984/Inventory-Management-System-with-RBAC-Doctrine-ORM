<?php

namespace App\Interfaces\Service;

use CodeIgniter\HTTP\Files\UploadedFile;

interface ProfileServiceInterface
{
    /**
     * Store picture as webp, persist on user_profile, return relative path.
     */
    public function updatePicture(int $userId, UploadedFile $picture): string;
}
