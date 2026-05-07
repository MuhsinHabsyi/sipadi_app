<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CuacaController extends Controller
{
    public function index()
    {
        // Koordinat Bandung / Jawa Barat sebagai contoh
        $latitude = -6.9147;
        $longitude = 107.6098;

        try {
            // Menggunakan Open-Meteo API (tidak butuh API key)
            $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current_weather' => true,
                'daily' => 'temperature_2m_max,temperature_2m_min,precipitation_sum,weathercode',
                'timezone' => 'Asia/Jakarta'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
                return view('cuaca.index', compact('weatherData'));
            } else {
                return view('cuaca.index')->with('error_api', 'Gagal mengambil data cuaca dari server.');
            }
        } catch (\Exception $e) {
            return view('cuaca.index')->with('error_api', 'Koneksi ke server cuaca terputus.');
        }
    }
}
