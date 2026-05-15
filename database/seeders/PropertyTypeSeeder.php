<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            'Офис',
            'Торговое помещение',
            'Склад',
            'Помещение свободного назначения',
            'Производственное помещение',
        ];

        foreach ($items as $title) {
            PropertyType::create([
                'title' => $title,
            ]);
        }
    }
}
