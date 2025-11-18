<?php

namespace App\Traits;

use Illuminate\Support\Facades\Request;

trait TrackViews
{
    public function recordView()
    {
        $ip = Request::ip();
        $userAgent = Request::userAgent();

        $location = $this->getLocationFromIP($ip);

        $view = $this->views()
            ->where('ip_address', $ip)
            ->first();

        if ($view) {
            $view->increment('count');
        } else {
            $this->views()->create([
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'country' => $location['country'] ?? null,
                'city' => $location['city'] ?? null,
                'count' => 1,
            ]);
        }
    }

    private function getLocationFromIP($ip)
    {
        try {
            $response = @file_get_contents("http://ip-api.com/json/{$ip}");
            $data = json_decode($response, true);

            if ($data && $data['status'] === 'success') {
                return [
                    'country' => $data['country'],
                    'city' => $data['city'],
                ];
            }
        } catch (\Exception $e) {
        }

        return [
            'country' => null,
            'city' => null,
        ];
    }
}
