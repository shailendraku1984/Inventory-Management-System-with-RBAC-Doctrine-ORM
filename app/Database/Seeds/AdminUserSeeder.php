<?php

namespace App\Database\Seeds;

use App\Entities\Users;
use CodeIgniter\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $repository = service('userRepository');

        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'role' => 'ADMIN',
            ],
            [
                'name' => 'Angel Admin',
                'email' => 'angel@admin.com',
                'role' => 'ADMIN',
            ],
            [
                'name' => 'Super Admin',
                'email' => 'super@admin.com',
                'role' => 'SUPER_ADMIN',
            ],
        ];

        foreach ($users as $userData) {
            $user = $repository->findByEmail($userData['email']) ?? new Users();

            $user
                ->setName($userData['name'])
                ->setEmail($userData['email'])
                ->setPasswordHash('password')
                ->setRole($userData['role'])
                ->setIsActive(true)
                ->setDeletedAt(null);

            $repository->save($user);
        }
    }
}
