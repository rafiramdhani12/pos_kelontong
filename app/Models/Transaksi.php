<?php 

namespace App\Models;

use CodeIgniter\Model;

class Transaksi extends Model
{

 protected $table = 'transaksi';
 protected $primaryKey = 'id';

 protected $useTimestamps = true;
 protected $createdField = 'created_at';
 protected $updatedField = 'updated_at';

 protected $allowedFields = ['total' , 'user_id'];
}



?>