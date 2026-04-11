<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            "total" => [
                "type" => "INT",
                "null" => false
            ],
            "created_at" => [
                "type" => "TIMESTAMP",
                "null" => false
            ],
            "updated_at" => [
                "type" => "TIMESTAMP",
                "null" => false
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi', true);
    }
}
