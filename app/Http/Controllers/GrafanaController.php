<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GrafanaController extends Controller
{
    // Menus Dashboard Mes 
    // Powder Plant
    public function powderPlant()
    {
        // URL Grafana dashboard (gunakan URL yang sudah di-share secara eksternal)
        $grafanaUrl = "http://108.137.148.210:3001/public-dashboards/5fb514ae54064e5792f1de53add2873a?orgId=1&refresh=5s";

        
        return view('mes.monitoring.powder-plant', [
            'grafanaUrl' => $grafanaUrl
        ]);
    }

    // Menu Dashboard CMMS
    // Powder Plant
    public function cmmsPowderPlant()
    {
        // URL Grafana dashboard (gunakan URL yang sudah di-share secara eksternal)
        $grafanaUrl = "http://108.137.148.210:3001/public-dashboards/767d39d5255d487492100ab5f09cf616";

        
        return view('cmms.dashboard.powder-plant', [
            'grafanaUrl' => $grafanaUrl
        ]);
    }
}
