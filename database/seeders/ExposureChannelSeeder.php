<?php

namespace Database\Seeders;

use App\Models\ExposureChannel;
use Illuminate\Database\Seeder;

class ExposureChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Собственный сайт',
            'Классифайд 1',
            'Классифайд 2',
            'Партнёрский канал',
            'Ручное размещение',
        ];

        foreach ($items as $title) {
            ExposureChannel::create([
                'title' => $title,
            ]);
        }
    }
}
