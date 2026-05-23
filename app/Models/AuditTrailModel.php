<?php 

namespace App\Models;

use CodeIgniter\Model;

class AuditTrailModel extends Model{
    protected $table = 'audit_trail';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $updatedField  = '';
    protected $allowedFields = ['detail_transaksi_id' , 'user_id', 'nominal'];
}


?>