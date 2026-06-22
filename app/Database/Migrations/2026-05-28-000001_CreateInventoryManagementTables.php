<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInventoryManagementTables extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('category', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('branch', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'address' => ['type' => 'VARCHAR', 'constraint' => 255],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('warehouse', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 50],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['1', '2'], 'default' => '1'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tax_rate', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'type' => ['type' => 'ENUM', 'constraint' => ['kg', 'litre', 'qty'], 'default' => 'qty'],
            'name' => ['type' => 'VARCHAR', 'constraint' => 180],
            'sku' => ['type' => 'VARCHAR', 'constraint' => 80],
            'description' => ['type' => 'TEXT', 'null' => true],
            'categoryId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'branchId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'warehouseId' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'stock' => ['type' => 'DECIMAL', 'constraint' => '12,3', 'default' => '0.000'],
            'price' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'tax_rate_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'default' => 0],
            'for_sale' => ['type' => 'ENUM', 'constraint' => ['For sale', 'Not for sale'], 'default' => 'For sale'],
            'for_purchase' => ['type' => 'ENUM', 'constraint' => ['For purchase', 'Not for purchase'], 'default' => 'For purchase'],
            'image' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_keyword' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description' => ['type' => 'TEXT', 'null' => true],
            'added_at' => ['type' => 'DATETIME'],
            'modify_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');
        $this->forge->addUniqueKey('sku');
        $this->forge->createTable('product', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_name' => ['type' => 'VARCHAR', 'constraint' => 180],
            'type' => ['type' => 'VARCHAR', 'constraint' => 10],
            'stock' => ['type' => 'DECIMAL', 'constraint' => '12,3'],
            'added_at' => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('product_update_history', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('product_update_history', true);
        $this->forge->dropTable('product', true);
        $this->forge->dropTable('tax_rate', true);
        $this->forge->dropTable('warehouse', true);
        $this->forge->dropTable('branch', true);
        $this->forge->dropTable('category', true);
    }
}
