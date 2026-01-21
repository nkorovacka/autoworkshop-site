<?php

namespace Database\Seeders;

use App\Models\WorkItem;
use Illuminate\Database\Seeder;

class WorkItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Pilns detailing – BMW 5. sērija',
                'tag' => 'Exterior',
                'description' => 'Spīduma atjaunošana un keramiskais pārklājums.',
                'before_image' => null,
                'after_image' => null,
                'position' => 1,
            ],
            [
                'title' => 'Salona dziļā tīrīšana – VW Golf',
                'tag' => 'Interior',
                'description' => 'Traipu noņemšana un antibakteriālā apstrāde.',
                'position' => 2,
            ],
        ];

        foreach ($items as $item) {
            WorkItem::create($item);
        }
    }
}
