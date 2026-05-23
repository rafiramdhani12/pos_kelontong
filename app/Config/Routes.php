<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);

$routes->group("kasir", static function ($routes) {
    $routes->get('/', 'Kasir::index', ['filter' => 'auth']);
    $routes->get('penjualan', 'Kasir::laporan_penjualan', ['filter' => 'auth']);
    $routes->post('tambah', 'Kasir::tambah', ['filter' => 'auth']);
    $routes->post('hapus', 'Kasir::hapus', ['filter' => 'auth']);
    $routes->post('bayar', 'Kasir::bayar', ['filter' => 'auth']);
    $routes->post('rollback/(:segment)', 'Kasir::rollback/$1', ['filter' => 'auth']);
});

$routes->get('/api/penjualan', 'Kasir::penjualan');
$routes->get('/audit-trail', 'AuditTrail::index', ['filter' => 'auth']);
$routes->group('dashboard' ,static function ($routes){
    $routes->get('/', 'Dashboard::index');
    $routes->get('get-ai-data', 'Kasir::getDataFromFlask');
});

$routes->group('products', static function ($routes) {
    $routes->get('/', 'Products::index', ['filter' => 'auth']);
    $routes->get('add', 'Products::add', ['filter' => 'auth']);
    $routes->post('store', 'Products::store', ['filter' => 'auth']);
    $routes->get('edit/(:segment)', 'Products::edit/$1', ['filter' => 'auth']);
    $routes->post('update/(:segment)', 'Products::update/$1', ['filter' => 'auth']);
    $routes->post('toggleStatus/(:segment)', 'Products::toggleStatus/$1', ['filter' => 'auth']);
    $routes->post('delete/(:segment)', 'Products::delete/$1', ['filter' => 'auth']);
});

$routes->group('users', static function ($routes) {
    $routes->get('/' , 'Users::index');
    $routes->get('add' , 'Users::add');
    $routes->post('store' , 'Users::store');
    $routes->get('edit/(:segment)' , 'Users::edit/$1');
    $routes->post('update/(:segment)' , 'Users::update/$1');
    $routes->post('toggleStatus/(:segment)' , 'Users::toggleStatus/$1');
});