<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'transaksi_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'qty' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'harga' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ],
            'subtotal' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'null'           => false,
            ]
        ]);

        $this->forge->addKey('id',true);

        // fk ke transaksi
        $this->forge->addForeignKey('transaksi_id', 'transaksi', 'id', 'CASCADE', 'CASCADE');

        // fk ke products
        $this->forge->addForeignKey('product_id', 'products', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('detail_transaksi');


    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi', true);
    }
}
