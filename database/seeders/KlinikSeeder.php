<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Klinik;

class KlinikSeeder extends Seeder
{
    public function run()
    {
        Klinik::create(['name' => 'Benings', 'harga' => 200, 'jarak' => 6, 'layanan' => 4, 'testimoni' => 4, 'teknologi' => 3]);
        Klinik::create(['name' => 'Natasha', 'harga' => 180, 'jarak' => 6, 'layanan' => 5, 'testimoni' => 1, 'teknologi' => 2]);
        Klinik::create(['name' => 'Navagreen', 'harga' => 150, 'jarak' => 7, 'layanan' => 2, 'testimoni' => 4, 'teknologi' => 5]);
        Klinik::create(['name' => 'Asderma', 'harga' => 140, 'jarak' => 7, 'layanan' => 4, 'testimoni' => 5, 'teknologi' => 2]);
        Klinik::create(['name' => 'Larrisa', 'harga' => 110, 'jarak' => 6, 'layanan' => 1, 'testimoni' => 3, 'teknologi' => 4]);
    }
}

