<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;
use InvalidArgumentException;

class ProfilePictureStorage
{
    private const UPLOAD_DIR = 'uploads/user_profiles';

    public function storeAsWebp(UploadedFile $picture): string
    {
        if (! $picture->isValid() || $picture->getSize() === 0) {
            throw new InvalidArgumentException('Invalid profile picture upload.');
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

        $directory = FCPATH . self::UPLOAD_DIR;
        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $fileName = uniqid('profile_', true) . '.webp';
        $target = $directory . DIRECTORY_SEPARATOR . $fileName;
        imagepalettetotruecolor($source);
        imagewebp($source, $target, 85);
        imagedestroy($source);

        return self::UPLOAD_DIR . '/' . $fileName;
    }
}
