<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/kasir', 'Kasir::index', ['filter' => 'auth']);
$routes->get('/penjualan', 'Kasir::laporan_penjualan', ['filter' => 'auth']);
$routes->post('/kasir/tambah', 'Kasir::tambah', ['filter' => 'auth']);
$routes->post('/kasir/hapus', 'Kasir::hapus', ['filter' => 'auth']);
$routes->post('/kasir/bayar', 'Kasir::bayar', ['filter' => 'auth']);
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout', ['filter' => 'auth']);

// ========== ML MODULE ROUTES ==========
// ML Module pages (protected routes)
$routes->get('/ml', 'MlRoutes::index', ['filter' => 'auth']);
$routes->get('/ml/dashboard', 'MlRoutes::dashboard', ['filter' => 'auth']);
$routes->get('/ml/analytics', 'MlRoutes::salesAnalytics', ['filter' => 'auth']);
$routes->get('/ml/forecast', 'MlRoutes::demandForecast', ['filter' => 'auth']);
$routes->get('/ml/top-products', 'MlRoutes::getTopProducts', ['filter' => 'auth']);
$routes->get('/ml/category-performance', 'MlRoutes::categoryPerformance', ['filter' => 'auth']);
$routes->get('/ml/sales-trends', 'MlRoutes::salesTrends', ['filter' => 'auth']);
$routes->get('/ml/fraud-alert', 'MlRoutes::fraudAlert', ['filter' => 'auth']);
$routes->get('/ml/docs', 'MlRoutes::docs', ['filter' => 'auth']);
