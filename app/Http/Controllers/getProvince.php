<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class getProvince extends Controller
{

    public static function getProvince()
    {
        $apiKey = 'eea36c37a8907b5d9ef7a714162a1bef'; // Replace with your RajaOngkir API key

        $response = Http::withHeaders([
            'key' => $apiKey,
        ])->get('https://api.rajaongkir.com/starter/province');

        if ($response->successful()) {
            $data = $response->json();
            $provinces = collect($data['rajaongkir']['results'])
                ->pluck('province', 'province_id');

            return $provinces;
        } else {
            return []; // Return an empty array if the request fails
        }
    }
    
}
