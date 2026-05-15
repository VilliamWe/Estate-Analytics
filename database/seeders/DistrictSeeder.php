<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Центральный',
            'Советский',
            'Ленинский',
            'Кировский',
            'Октябрьский',
        ];

        foreach ($items as $title) {
            District::create([
                'title' => $title,
            ]);
        }
    }
}
