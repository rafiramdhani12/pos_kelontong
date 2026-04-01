<?php

namespace App\Models;

use CodeIgniter\Model;


class Users extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = ['nama', 'email', 'password', 'role', 'is_active'];
    
    public function getAllUsers() {
        return $this->findAll();
    }
}


?>