<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProductsModel extends Model {

    // init nama tabel nya dulu
    protected $table = 'products';

    protected $primaryKey = 'id';

    // kalo make timestamp wajib pake ini
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'kode_product',
        'nama_product',
        'kategori',
        'qty',
        'is_active',
        'harga',
        'image',
    ];

    protected $validationRules = [
        'kode_product'  => 'required|min_length[3]',
        'nama_product'  => 'required|min_length[3]',
        'kategori'      => 'required|in_list[makanan ringan, minuman, kebutuhan pokok, kebersihan, lainnya]',
        'qty'           => 'required|numeric|greater_than_equal_to[0]',
        'is_active'     => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[1]',
        'harga'         => 'required|numeric',
    ];

    public function getAllProducts() {
        return $this->findAll();
    }

    public function getProductById($id) {
        return $this->find($id);
    }

    public function createProduct($data) {
        return $this->insert($data);
    }

    public function updateProduct($id, $data) {
        return $this->update($id, $data);
    }

    public function deleteProduct($id) {
        return $this->delete($id);
    }


}

?>