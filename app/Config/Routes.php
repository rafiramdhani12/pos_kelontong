<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/kasir', 'Kasir::index', ['filter' => 'auth']);
$routes->post('/kasir/tambah', 'Kasir::tambah', ['filter' => 'auth']);
$routes->post('/kasir/hapus', 'Kasir::hapus', ['filter' => 'auth']);
$routes->post('/kasir/bayar', 'Kasir::bayar', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);
