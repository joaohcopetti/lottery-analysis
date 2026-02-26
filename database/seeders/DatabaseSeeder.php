<?php

namespace Database\Seeders;

use App\Enums\LotteriesEnum;
use App\Models\Lottery;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cache::clear();

        $lotteriesData = [];

        foreach (LotteriesEnum::cases() as $lotteryEnum) {
            $lotteriesData[] = [
                'id' => $lotteryEnum->id(),
                'label' => $lotteryEnum->label(),
                'slug' => $lotteryEnum->value,
                'numbers_per_draw' => $lotteryEnum->numbersPerDraw(),
                'numbers_per_line' => $lotteryEnum->numbersPerLine(),
                'min_number' => $lotteryEnum->minNumber(),
                'max_number' => $lotteryEnum->maxNumber()
            ];
        }

        Lottery::query()->insert($lotteriesData);
    }
}
