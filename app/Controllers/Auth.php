<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\HTTP\RedirectResponse;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }

        if (! $this->request->is('post')) {
            return view('auth/login', [
                'title'        => 'Login POS kelontong Arya',
                'page_heading' => 'Login',
            ]);
        }

        $authModel = new AuthModel();

        $loginData = [
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ];

        if (empty($loginData['email']) || empty($loginData['password'])) {
            session()->setFlashdata('error', 'Email dan password wajib diisi.');

            return redirect()->to('/')->withInput();
        }

        $user = $authModel->login($loginData['email'], $loginData['password']);

        if ($user && (int) ($user['is_active'] ?? 0) === 1) {
            session()->regenerate();
            session()->set([
                'user_id' => $user['id'],
                'user_name' => $user['nama'],
                'user_email' => $user['email'],
                'user_role' => $user['role'],
                'user_is_active' => $user['is_active'],
                'is_logged_in' => true,
            ]);
            return redirect()->to('/dashboard');
        }

        session()->setFlashdata('error', 'Email atau password salah, atau akun tidak aktif.');
        return redirect()->to('/')->withInput();
    }

    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

