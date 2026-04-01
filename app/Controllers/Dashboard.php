<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $dashboardModel = new DashboardModel();

        $data = [
            'title'           => 'Dashboard — AmbaToys',
            'page_heading'    => 'Ringkasan toko',
            'stats'           => $dashboardModel->getOverviewStats(),
            'by_category'     => $dashboardModel->getCountByCategory(),
            'low_stock'       => $dashboardModel->getLowStockProducts(5, 8),
            'out_of_stock'    => $dashboardModel->getOutOfStockProducts(6),
        ];

        return view('pages/dashboard', $data);
    }
}
