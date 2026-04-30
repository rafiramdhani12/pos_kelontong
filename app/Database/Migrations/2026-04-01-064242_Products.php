<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'null'           => false,
                'auto_increment' => true,
            ],
            'kode_product' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'nama_product' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'kategori' => [
                'type'       => 'ENUM',
                'constraint' => ['makanan ringan', 'minuman', 'kebutuhan pokok', 'kebersihan', 'lainnya'],
                'null'       => false,
            ],
            'qty' => [
                'type'       => 'INT',
                'null'       => true,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => true,
                'default'    => 1,
            ],
            'harga' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => false,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'created_at' => [
                'type' => 'timestamp',
                'null' => false,
            ],
            'updated_at' => [
                'type' => 'timestamp',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('kode_product');

        $attributes = [
            'ENGINE'  => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE' => 'utf8mb4_0900_ai_ci',
        ];

        $this->forge->createTable('products', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
