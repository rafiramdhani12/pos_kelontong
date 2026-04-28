<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/kasir', 'Kasir::index', ['filter' => 'auth']);
$routes->get('/api/penjualan', 'Kasir::penjualan');
$routes->get('/penjualan', 'Kasir::laporan_penjualan', ['filter' => 'auth']);
$routes->post('/kasir/tambah', 'Kasir::tambah', ['filter' => 'auth']);
$routes->post('/kasir/hapus', 'Kasir::hapus', ['filter' => 'auth']);
$routes->post('/kasir/bayar', 'Kasir::bayar', ['filter' => 'auth']);
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);
$routes->group('dashboard' ,static function ($routes){
    $routes->get('/', 'Dashboard::index');
    $routes->get('get-ai-data', 'Kasir::getDataFromFlask');
});
$routes->get('/barang', 'Barang::index', ['filter' => 'auth']);
$routes->get('/barang/tambahProduct', 'Barang::tambahProduct', ['filter' => 'auth']);