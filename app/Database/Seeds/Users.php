<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            'nama' => "arya",
            "email" => "arya@gmail.com",
            "password" => password_hash("arya123", PASSWORD_DEFAULT),
            "role" => "owner",
            "is_active" => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->table('users')->insert($data);
    }
}
