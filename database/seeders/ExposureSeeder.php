<?php

namespace Database\Seeders;

use App\Models\Exposure;
use App\Models\ExposureChannel;
use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExposureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@estate.local')->firstOrFail();

        $channels = ExposureChannel::query()
            ->whereIn('title', [
                'Собственный сайт',
                'Классифайд 1',
                'Классифайд 2',
                'Партнёрский канал',
                'Ручное размещение',
            ])
            ->get()
            ->values();

        $statuses = ['Активна', 'Активна', 'На паузе', 'Завершена'];
        $comments = [
            'Свободное помещение с высоким трафиком.',
            'Подходит под федерального арендатора.',
            'Размещение для тестирования спроса.',
            'Экспозиция для повторного вывода объекта.',
            'Размещение с акцентом на витринную часть.',
        ];

        $properties = Property::query()
            ->orderBy('id')
            ->get();

        foreach ($properties as $index => $property) {
            $channel = $channels[$index % $channels->count()];
            $status = $statuses[$index % count($statuses)];
            $startDate = now()->startOfDay()->subDays(30 - min($index, 25));
            $endDate = $status === 'Завершена'
                ? (clone $startDate)->addDays(14)
                : (clone $startDate)->addDays(21);

            $views = 120 + ($index * 17);
            $leads = max(1, (int) floor($views / 70));
            $publicationPrice = 1500 + ($index * 180);

            Exposure::create([
                'property_id' => $property->id,
                'channel_id' => $channel->id,
                'created_by' => $admin->id,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'publication_price' => $publicationPrice,
                'views_count' => $views,
                'leads_count' => $leads,
                'status' => $status,
                'source_url' => 'https://example.com/exposures/' . $property->id,
                'comment' => $comments[$index % count($comments)],
                'created_at' => $startDate->copy()->setTime(10, 0),
                'updated_at' => $startDate->copy()->setTime(10, 0),
            ]);
        }
    }
}
