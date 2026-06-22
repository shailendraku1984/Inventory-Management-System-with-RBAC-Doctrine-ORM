<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesAndUserProfileTables extends Migration
{
    public function up(): void
    {
        $this->createRolesTable();
        $this->createOrUpdateUsersTable();
        $this->createUserProfileTable();
        $this->alignUserProfileForeignKeyColumn();
        $this->seedRoles();
        $this->addForeignKeyIfMissing('users', 'fk_users_role', 'role', 'roles', 'id', 'RESTRICT', 'CASCADE');
        $this->addForeignKeyIfMissing('users', 'fk_users_branch', 'branch_id', 'branch', 'id', 'SET NULL', 'CASCADE');
        $this->addForeignKeyIfMissing('user_profile', 'fk_user_profile_user', 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
    }

    public function down(): void
    {
        $this->dropForeignKeyIfExists('user_profile', 'fk_user_profile_user');
        $this->forge->dropTable('user_profile', true);

        if ($this->db->tableExists('users')) {
            $this->dropForeignKeyIfExists('users', 'fk_users_branch');
            $this->dropForeignKeyIfExists('users', 'fk_users_role');

            if ($this->db->fieldExists('branch_id', 'users')) {
                $this->forge->dropColumn('users', 'branch_id');
            }
        }

        $this->forge->dropTable('roles', true);
    }

    private function createRolesTable(): void
    {
        if ($this->db->tableExists('roles')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'ENUM', 'constraint' => ['1', '2', '3', '4']],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->createTable('roles', true);
    }

    private function createOrUpdateUsersTable(): void
    {
        if (! $this->db->tableExists('users')) {
            $this->forge->addField([
                'id' => ['type' => 'INT', 'constraint' => 11, 'auto_increment' => true],
                'name' => ['type' => 'VARCHAR', 'constraint' => 150],
                'email' => ['type' => 'VARCHAR', 'constraint' => 180],
                'password' => ['type' => 'VARCHAR', 'constraint' => 255],
                'role' => ['type' => 'ENUM', 'constraint' => ['1', '2', '3', '4'], 'default' => '4'],
                'branch_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
                'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
                'last_login' => ['type' => 'DATETIME', 'null' => true],
                'created_at' => ['type' => 'DATETIME'],
                'updated_at' => ['type' => 'DATETIME', 'null' => true],
                'deleted_at' => ['type' => 'DATETIME', 'null' => true],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('email');
            $this->forge->createTable('users', true);

            return;
        }

        if (! $this->db->fieldExists('branch_id', 'users')) {
            $this->forge->addColumn('users', [
                'branch_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'role'],
            ]);
        }

        $this->db->query("UPDATE users SET role = CASE UPPER(role) WHEN 'SUPER_ADMIN' THEN '1' WHEN 'ADMIN' THEN '2' WHEN 'EMPLOYEE' THEN '3' WHEN 'USER' THEN '4' ELSE role END");
        $this->db->query("UPDATE users SET role = '4' WHERE role NOT IN ('1', '2', '3', '4') OR role IS NULL OR role = ''");
        $this->db->query("ALTER TABLE users MODIFY role ENUM('1','2','3','4') NOT NULL DEFAULT '4'");
    }

    private function createUserProfileTable(): void
    {
        if ($this->db->tableExists('user_profile')) {
            return;
        }

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11],
            'picture' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'emp_code' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'salary' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME'],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('user_id');
        $this->forge->addUniqueKey('emp_code');
        $this->forge->createTable('user_profile', true);
    }

    private function alignUserProfileForeignKeyColumn(): void
    {
        if (! $this->db->tableExists('user_profile')) {
            return;
        }

        $this->db->query('ALTER TABLE user_profile MODIFY user_id INT(11) NOT NULL');
    }

    private function seedRoles(): void
    {
        $this->db->query("
            INSERT INTO roles (id, name) VALUES
                ('1', 'SUPER_ADMIN'),
                ('2', 'ADMIN'),
                ('3', 'EMPLOYEE'),
                ('4', 'USER')
            ON DUPLICATE KEY UPDATE name = VALUES(name)
        ");
    }

    private function addForeignKeyIfMissing(
        string $table,
        string $constraint,
        string $column,
        string $foreignTable,
        string $foreignColumn,
        string $onDelete,
        string $onUpdate
    ): void {
        if ($this->foreignKeyExists($table, $constraint)) {
            return;
        }

        $this->db->query(sprintf(
            'ALTER TABLE `%s` ADD CONSTRAINT `%s` FOREIGN KEY (`%s`) REFERENCES `%s`(`%s`) ON DELETE %s ON UPDATE %s',
            $table,
            $constraint,
            $column,
            $foreignTable,
            $foreignColumn,
            $onDelete,
            $onUpdate
        ));
    }

    private function dropForeignKeyIfExists(string $table, string $constraint): void
    {
        if (! $this->db->tableExists($table) || ! $this->foreignKeyExists($table, $constraint)) {
            return;
        }

        $this->db->query(sprintf('ALTER TABLE `%s` DROP FOREIGN KEY `%s`', $table, $constraint));
    }

    private function foreignKeyExists(string $table, string $constraint): bool
    {
        $result = $this->db->query(
            'SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?',
            [$table, $constraint]
        )->getRowArray();

        return $result !== null;
    }
}
