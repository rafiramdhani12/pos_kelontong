<?php 

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id';
    protected $allowedFields = ['transaksi_id', 'product_id', 'qty', 'harga' , 'subtotal'];
}

?>