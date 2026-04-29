<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Users extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new UsersModel();
    }

    public function index()
    {
        $data['users'] = $this->users->findAll();
        return view('pages/users/index', $data);
    }

    public function add()
    {
        return view('pages/users/add');
    }
    public function store()
    {
        $data = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'is_active' => 1
        ];

        // simple validation
        if (!$this->validate([
            'name' => 'required',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ])) {
            return redirect()->back()->withInput();
        }

        $this->users->insert($data);

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['user'] = $this->users->find($id);

        if (!$data['user']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        return view('pages/users/edit', $data);
    }
    public function update($id)
    {
        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        // kalau password diisi → update
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->users->update($id, $data);

        return redirect()->to('/users')->with('success', 'User berhasil diupdate');
    }

    public function deActive($id)
{
    $user = $this->users->find($id);

    if (!$user) {
        return redirect()->to('/users')->with('error', 'User tidak ditemukan');
    }

    $updated = $this->users->update($id, [
        'is_active' => 0
    ]);

    if (!$updated) {
        return redirect()->to('/users')->with('error', 'Gagal menonaktifkan user');
    }

    return redirect()->to('/users')->with('success', 'User berhasil dinonaktifkan');
}
}