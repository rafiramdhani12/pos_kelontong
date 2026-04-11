<?php 

namespace App\Models;

use CodeIgniter\Model;

class Products extends Model {

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
        'kondisi',
        'is_active',
        'deskripsi',
        'harga',
        'image',
    ];

    protected $validationRules = [
        'kode_product'  => 'required|min_length[3]',
        'nama_product'  => 'required|min_length[3]',
        'kategori'      => 'required|in_list[gunpla,tcg,figure,tools,paints]',
        'qty'           => 'required|numeric',
        'kondisi'       => 'required|in_list[new,used]',
        'is_active'     => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[1]',
        'harga'         => 'required|numeric',
        'deskripsi'     => 'permit_empty|max_length[65535]',
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