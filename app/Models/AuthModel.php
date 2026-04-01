<?php 

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $allowedFields = ['nama', 'email', 'password', 'role', 'is_active'];


    public function login($email,$password){
        $user = $this->where('email', $email)->first();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return null;
    }

    public function register($data){
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $this->insert($data);
        return $this->insertID();
    }

}


?>