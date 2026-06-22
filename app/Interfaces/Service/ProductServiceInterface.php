<?php

namespace App\Interfaces\Service;

use CodeIgniter\HTTP\Files\UploadedFile;

interface ProductServiceInterface extends CrudServiceInterface
{
    public function formOptions(): array;

    public function saveWithImage(array $data, ?UploadedFile $image = null, ?int $id = null): object;

    public function history(): array;
}
