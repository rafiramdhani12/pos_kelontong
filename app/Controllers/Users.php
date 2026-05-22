<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $usersModel;

    public function __construct()
    {
        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        $data['users'] = $this->usersModel->findAll();
        return view('pages/users/index', $data);
    }

    public function add()
    {
        return view('pages/users/add');
    }
    public function store()
    {
        $data = [
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
            'is_active' => 1
        ];

        // simple validation
        if (!$this->validate([
            'nama' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ])) {
            return redirect()->back()->withInput();
        }

        $this->usersModel->insert($data);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['user'] = $this->usersModel->find($id);

        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        return view('pages/users/edit', $data);
    }
    public function update($id)
    {
        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
        ];

        // kalau password diisi → update
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->usersModel->update($id, $data);

        return redirect()->to('/users')->with('success', 'User berhasil diupdate');
    }

    // refactor fitur nya jadi 1 aja toggle status

    public function toggleStatus($id){
        $user = $this->usersModel->find($id);
        if($status){
            $newStatus = ($user['is_active'] == 1) ? 0 : 1;
            $this->userModel->where('id', $id)
                           ->set(['is_active' => $newStatus])
                           ->update();

            return redirect()->to('/users')->with('msg', 'Status user berhasil diubah!');
        }
    }
}