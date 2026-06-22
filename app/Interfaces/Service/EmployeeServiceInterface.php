<?php

namespace App\Interfaces\Service;

use CodeIgniter\HTTP\Files\UploadedFile;

interface EmployeeServiceInterface extends CrudServiceInterface
{
    public function saveWithProfile(array $data, ?UploadedFile $picture = null, ?int $id = null): object;

    public function profileFor(int $userId): ?object;
 
    public function formOptions(): array;
}
