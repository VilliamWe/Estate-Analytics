<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@estate.local')->firstOrFail();

        $districts = District::query()
            ->whereIn('title', ['Центральный', 'Советский', 'Ленинский', 'Кировский', 'Октябрьский'])
            ->get()
            ->keyBy('title');

        $types = PropertyType::query()
            ->whereIn('title', [
                'Офис',
                'Торговое помещение',
                'Склад',
                'Помещение свободного назначения',
                'Производственное помещение',
            ])
            ->get()
            ->keyBy('title');

        $items = [
            ['address' => 'Труда, 49', 'segment' => '1', 'area_text' => '170-350', 'rate_text' => '1100-1200 р/м', 'area' => 170, 'price_per_sqm' => 1100, 'district' => 'Ленинский', 'type' => 'Торговое помещение'],
            ['address' => 'Малиновского, 12 корп. 5', 'segment' => '1', 'area_text' => '170-210', 'rate_text' => '1000 р/м', 'area' => 170, 'price_per_sqm' => 1000, 'district' => 'Советский', 'type' => 'Помещение свободного назначения'],
            ['address' => 'Масленникова, 39', 'segment' => '1', 'area_text' => '300-400', 'rate_text' => '900 р/м', 'area' => 300, 'price_per_sqm' => 900, 'district' => 'Центральный', 'type' => 'Торговое помещение'],
            ['address' => 'Маяковского, 46/1', 'segment' => '1', 'area_text' => '171,2', 'rate_text' => '850 р/м', 'area' => 171.2, 'price_per_sqm' => 850, 'district' => 'Центральный', 'type' => 'Офис'],
            ['address' => 'Красноярский тракт, 49', 'segment' => '1', 'area_text' => '240', 'rate_text' => '600 р/м', 'area' => 240, 'price_per_sqm' => 600, 'district' => 'Советский', 'type' => 'Склад'],
            ['address' => 'Энтузиастов, 2', 'segment' => '1', 'area_text' => '233', 'rate_text' => '850 р/м', 'area' => 233, 'price_per_sqm' => 850, 'district' => 'Советский', 'type' => 'Производственное помещение'],
            ['address' => 'Пушкина, 32', 'segment' => '1', 'area_text' => 'до 1364', 'rate_text' => '1500-3000 р/м', 'area' => 1364, 'price_per_sqm' => 1500, 'district' => 'Центральный', 'type' => 'Торговое помещение'],
            ['address' => 'Красный путь, 78', 'segment' => '1', 'area_text' => '120 на 1 этаже и 110 кв.м подвал', 'rate_text' => '700 р/м', 'area' => 230, 'price_per_sqm' => 700, 'district' => 'Центральный', 'type' => 'Офис'],
            ['address' => 'пр. Мира, 19 КДЦ "Кристалл"', 'segment' => 'подвал', 'area_text' => 'до 300', 'rate_text' => '1100 р/м', 'area' => 300, 'price_per_sqm' => 1100, 'district' => 'Советский', 'type' => 'Торговое помещение'],
            ['address' => 'Маяковского, 81', 'segment' => '-1', 'area_text' => 'от 200 до 450', 'rate_text' => '950 р/м', 'area' => 200, 'price_per_sqm' => 950, 'district' => 'Октябрьский', 'type' => 'Помещение свободного назначения'],
            ['address' => 'Шукшина, 7', 'segment' => 'цоколь', 'area_text' => '191', 'rate_text' => '800 р/м', 'area' => 191, 'price_per_sqm' => 800, 'district' => 'Октябрьский', 'type' => 'Торговое помещение'],
            ['address' => 'Дианова, 26', 'segment' => 'цоколь', 'area_text' => 'от 200 до 350', 'rate_text' => '550-600 р/м', 'area' => 200, 'price_per_sqm' => 550, 'district' => 'Кировский', 'type' => 'Склад'],
            ['address' => 'Дианова, 5', 'segment' => 'цоколь', 'area_text' => '150', 'rate_text' => '1000 р/м', 'area' => 150, 'price_per_sqm' => 1000, 'district' => 'Кировский', 'type' => 'Торговое помещение'],
            ['address' => 'Фрунзе, 1 корп. 4 "Миллениум"', 'segment' => '-1', 'area_text' => 'от 200 до 3500', 'rate_text' => 'от 600 до 1000 р/м', 'area' => 200, 'price_per_sqm' => 600, 'district' => 'Центральный', 'type' => 'Офис'],
            ['address' => '1-я Железнодорожная, 1/3', 'segment' => 'земля', 'area_text' => 'до 2000', 'rate_text' => '950 р/м', 'area' => 2000, 'price_per_sqm' => 950, 'district' => 'Ленинский', 'type' => 'Склад'],
            ['address' => 'посёлок Кордный', 'segment' => 'земля', 'area_text' => 'до 1500', 'rate_text' => 'обсуждаема', 'area' => 1500, 'price_per_sqm' => 0, 'district' => 'Октябрьский', 'type' => 'Помещение свободного назначения'],
            ['address' => 'н.п. Таврическое, ул. Комарова, 37', 'segment' => '1', 'area_text' => 'до 480', 'rate_text' => '650 р/м', 'area' => 480, 'price_per_sqm' => 650, 'district' => 'Ленинский', 'type' => 'Торговое помещение'],
            ['address' => 'н.п. Саргасткое, Коммунальная, 13', 'segment' => 'земля', 'area_text' => 'до 350', 'rate_text' => '750 р/м', 'area' => 350, 'price_per_sqm' => 750, 'district' => 'Кировский', 'type' => 'Помещение свободного назначения'],
            ['address' => 'н.п. Тара, площадь Юбилейная, 1', 'segment' => '1', 'area_text' => '170', 'rate_text' => '800 р/м', 'area' => 170, 'price_per_sqm' => 800, 'district' => 'Центральный', 'type' => 'Торговое помещение'],
            ['address' => 'ул. Перелёта, 6', 'segment' => '1', 'area_text' => '275', 'rate_text' => '1400 р/м', 'area' => 275, 'price_per_sqm' => 1400, 'district' => 'Кировский', 'type' => 'Торговое помещение'],
            ['address' => 'ул. Фрунзе, 80', 'segment' => 'подвал', 'area_text' => 'до 470', 'rate_text' => '550-750', 'area' => 470, 'price_per_sqm' => 550, 'district' => 'Центральный', 'type' => 'Помещение свободного назначения'],
            ['address' => 'ул. 3-я Дачная, 1А', 'segment' => 'цоколь', 'area_text' => '182', 'rate_text' => '', 'area' => 182, 'price_per_sqm' => 0, 'district' => 'Советский', 'type' => 'Склад'],
            ['address' => 'Бульвар Архитекторов, 13 б', 'segment' => '1', 'area_text' => '170', 'rate_text' => '1000 р/м', 'area' => 170, 'price_per_sqm' => 1000, 'district' => 'Кировский', 'type' => 'Торговое помещение'],
            ['address' => 'Тюкалинск, Комсомольская, 17-13', 'segment' => 'земля', 'area_text' => '', 'rate_text' => '', 'area' => 0, 'price_per_sqm' => 0, 'district' => 'Ленинский', 'type' => 'Помещение свободного назначения'],
            ['address' => 'Тюкалинск, 1-я Магистральная 49-51', 'segment' => 'земля', 'area_text' => '', 'rate_text' => '', 'area' => 0, 'price_per_sqm' => 0, 'district' => 'Ленинский', 'type' => 'Склад'],
            ['address' => 'Муромцево, у Светофора (Кирова, 71)', 'segment' => '1', 'area_text' => 'до 396', 'rate_text' => '650 р/м', 'area' => 396, 'price_per_sqm' => 650, 'district' => 'Октябрьский', 'type' => 'Торговое помещение'],
            ['address' => 'Большеречье', 'segment' => '1', 'area_text' => '600', 'rate_text' => '650 р/м', 'area' => 600, 'price_per_sqm' => 650, 'district' => 'Советский', 'type' => 'Производственное помещение'],
            ['address' => 'Волгоградская 2/1', 'segment' => '01.фев', 'area_text' => 'до 1800', 'rate_text' => '1000 р/м', 'area' => 1800, 'price_per_sqm' => 1000, 'district' => 'Кировский', 'type' => 'Склад'],
            ['address' => 'Дианова, 3/1 (ТК Лето)', 'segment' => '1', 'area_text' => 'до 368,3', 'rate_text' => '', 'area' => 368.3, 'price_per_sqm' => 0, 'district' => 'Кировский', 'type' => 'Торговое помещение'],
            ['address' => 'Красный Путь, 141 к 1', 'segment' => '1', 'area_text' => '200', 'rate_text' => '800 р/м', 'area' => 200, 'price_per_sqm' => 800, 'district' => 'Советский', 'type' => 'Офис'],
        ];

        foreach ($items as $item) {
            $price = $item['area'] > 0 && $item['price_per_sqm'] > 0
                ? round($item['area'] * $item['price_per_sqm'], 2)
                : 0;

            Property::create([
                'title' => $item['address'],
                'property_type_id' => $types[$item['type']]->id,
                'district_id' => $districts[$item['district']]->id,
                'segment' => $item['segment'],
                'address' => $item['address'],
                'area' => $item['area'],
                'price' => $price,
                'price_per_sqm' => $item['price_per_sqm'],
                'status' => 'Активный',
                'responsible_user_id' => $admin->id,
                'description' => trim(
                    'Площадь: ' . ($item['area_text'] ?: 'не указана') . '. ' .
                    'Ставка: ' . ($item['rate_text'] ?: 'не указана') . '.'
                ),
                'created_at' => '2026-04-06 15:39:00',
                'updated_at' => '2026-04-06 15:39:00',
            ]);
        }
    }
}
