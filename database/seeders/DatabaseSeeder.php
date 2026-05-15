<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('exposures')->truncate();
        DB::table('properties')->truncate();
        DB::table('exposure_channels')->truncate();
        DB::table('districts')->truncate();
        DB::table('property_types')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->call([
            UserSeeder::class,
            PropertyTypeSeeder::class,
            DistrictSeeder::class,
            ExposureChannelSeeder::class,
            PropertySeeder::class,
            ExposureSeeder::class,
        ]);
    }
}
