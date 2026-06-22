<?php

namespace App\Database\Seeds;

use App\Entities\Role;
use App\Entities\Users;
use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $entityManager = service('doctrine')->getEntityManager();

        foreach (Users::ROLE_LABELS as $id => $name) {
            $role = $entityManager->find(Role::class, $id) ?? new Role();
            $role->setId($id)->setName($name);
            $entityManager->persist($role);
        }

        $entityManager->flush();
    }
}
