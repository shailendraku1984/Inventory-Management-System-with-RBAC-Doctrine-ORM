<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExpenseManagementTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 150],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('head', true);
		
		
		$this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 150],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('department', true);
		
		
		$this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 150],
			'currency' => ['type' => 'VARCHAR', 'constraint' => 150],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('account', true);
 
    }

    public function down(): void
    {
		$this->forge->dropTable('account', true);
        $this->forge->dropTable('department', true);
        $this->forge->dropTable('head', true);
    }
}
