<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryManagementTables extends Migration
{
    public function up(): void
    {
         
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 180],
            'description' => ['type' => 'TEXT', 'null' => true],
            'accountId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'headId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
			'departmentId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'value_date' => ['type' => 'DATETIME', 'null' => true],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('expense', true);
		 
 
    }

    public function down(): void
    {
        
        $this->forge->dropTable('expense', true);
         
    }
}
