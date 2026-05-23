<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuditTrail extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id'=>[
                'type'=>'INT',
                'constraint'=> 11,
                'auto_increment'=>true
            ],

            'detail_transaksi_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null' => false
            ],

            'user_id'=>[
                'type'=>'INT',
                'constraint'=>11,
                'null' => false
            ],

            'nominal'=>[
                'type'=>'DECIMAL',
                'constraint'=>'12,2',
                'null' => false,
                'default' => 0
            ],

            'created_at'=>[
                'type'=>'DATETIME',
                'null'=>true
            ]
        ]);

        $this->forge->addKey(
            'id',
            true
        );

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->forge->createTable(
            'audit_trail'
        );
    }

    public function down()
    {
        $this->forge
            ->dropTable(
                'audit_trail',
                true
            );
    }
}
?>
