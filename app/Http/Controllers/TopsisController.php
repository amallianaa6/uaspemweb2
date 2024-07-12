<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klinik;

class TopsisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $kliniks = Klinik::all();

        // Langkah 1: Menormalisasi matriks keputusan
        $normalized = $kliniks->map(function ($klinik) use ($kliniks) {
            return [
                'name' => $klinik->name,
                'harga' => $klinik->harga / sqrt($kliniks->sum(fn($k) => pow($k->harga, 2))),
                'jarak' => $klinik->jarak / sqrt($kliniks->sum(fn($k) => pow($k->jarak, 2))),
                'layanan' => $klinik->layanan / sqrt($kliniks->sum(fn($k) => pow($k->layanan, 2))),
                'testimoni' => $klinik->testimoni / sqrt($kliniks->sum(fn($k) => pow($k->testimoni, 2))),
                'teknologi' => $klinik->teknologi / sqrt($kliniks->sum(fn($k) => pow($k->teknologi, 2))),
            ];
        });

        // Langkah 2: Menghitung matriks keputusan ternormalisasi terbobot
        $weights = [
            'harga' => 5,
            'jarak' => 4,
            'layanan' => 4,
            'testimoni' => 3,
            'teknologi' => 5,
        ];

        $weighted = $normalized->map(function ($klinik) use ($weights) {
            return [
                'name' => $klinik['name'],
                'harga' => $klinik['harga'] * $weights['harga'],
                'jarak' => $klinik['jarak'] * $weights['jarak'],
                'layanan' => $klinik['layanan'] * $weights['layanan'],
                'testimoni' => $klinik['testimoni'] * $weights['testimoni'],
                'teknologi' => $klinik['teknologi'] * $weights['teknologi'],
            ];
        });

        // Langkah 3: Menentukan solusi ideal positif dan negatif
        $idealPositive = [
            'harga' => $weighted->min('harga'),
            'jarak' => $weighted->min('jarak'),
            'layanan' => $weighted->max('layanan'),
            'testimoni' => $weighted->max('testimoni'),
            'teknologi' => $weighted->max('teknologi'),
        ];

        $idealNegative = [
            'harga' => $weighted->max('harga'),
            'jarak' => $weighted->max('jarak'),
            'layanan' => $weighted->min('layanan'),
            'testimoni' => $weighted->min('testimoni'),
            'teknologi' => $weighted->min('teknologi'),
        ];

        // Langkah 4: Menghitung jarak antara nilai setiap alternatif dengan solusi ideal positif dan negatif
        $distances = $weighted->map(function ($klinik) use ($idealPositive, $idealNegative) {
            $dPlus = sqrt(
                pow($klinik['harga'] - $idealPositive['harga'], 2) +
                pow($klinik['jarak'] - $idealPositive['jarak'], 2) +
                pow($klinik['layanan'] - $idealPositive['layanan'], 2) +
                pow($klinik['testimoni'] - $idealPositive['testimoni'], 2) +
                pow($klinik['teknologi'] - $idealPositive['teknologi'], 2)
            );

            $dMin = sqrt(
                pow($klinik['harga'] - $idealNegative['harga'], 2) +
                pow($klinik['jarak'] - $idealNegative['jarak'], 2) +
                pow($klinik['layanan'] - $idealNegative['layanan'], 2) +
                pow($klinik['testimoni'] - $idealNegative['testimoni'], 2) +
                pow($klinik['teknologi'] - $idealNegative['teknologi'], 2)
            );

            return [
                'name' => $klinik['name'],
                'dPlus' => $dPlus,
                'dMin' => $dMin,
                'score' => $dMin / ($dPlus + $dMin),
            ];
        });

        // Mengurutkan berdasarkan skor tertinggi
        $ranked = $distances->sortByDesc('score');

        return view('topsis.index', compact('ranked'));
    }
}

