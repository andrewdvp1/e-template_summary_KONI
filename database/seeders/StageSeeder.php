<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'Ekstraksi', 'sort_order' => 1],
            ['name' => 'Evaporasi', 'sort_order' => 2],
            ['name' => 'Granulasi', 'sort_order' => 3],
            ['name' => 'Sterilisasi', 'sort_order' => 4],
            ['name' => 'Pengecilan Ukuran Granul', 'sort_order' => 5],
        ];

        foreach ($stages as $data) {
            Stage::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}

