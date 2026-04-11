<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => "budi",
            "email" => "budi@gmail.com",
            "password" => password_hash("budi123", PASSWORD_DEFAULT),
            "role" => "admin",
            "is_active" => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($data);
    }
}
