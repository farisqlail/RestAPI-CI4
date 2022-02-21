<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'phone_no' => [
                'type' => 'VARCHAR',
                'constraint' => 30
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 120
            ],
            'created_at' => [
                'type' => 'timestamp'
            ],
            'role' => [
                'type' => 'ENUM("admin", "user")',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
