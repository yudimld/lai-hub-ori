<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GrafanaService
{
    protected $baseUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->baseUrl = env('GRAFANA_URL');
        $this->apiToken = env('GRAFANA_API_TOKEN');
    }

    public function getDashboard($dashboardUid)
    {
        $this->baseUrl = env('GRAFANA_URL');
        $this->apiToken = env('GRAFANA_API_TOKEN');
    
        // Tambahkan log untuk memastikan URL dibaca dengan benar
        \Log::info("DEBUG: GRAFANA_URL from .env: " . $this->baseUrl);
    
        $url = "{$this->baseUrl}/api/dashboards/uid/{$dashboardUid}";
        \Log::info("Full Request URL: {$url}");
    
        $response = Http::withToken($this->apiToken)->get($url);
    
        \Log::info("Response Status: {$response->status()}");
        \Log::info("Response Body: " . json_encode($response->json()));
    
        if ($response->successful()) {
            return $response->json();
        }
    
        throw new \Exception("Failed to fetch dashboard: HTTP {$response->status()}");
    }
    
    
}
