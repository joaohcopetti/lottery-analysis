<?php

namespace Tests\Feature;

use App\Enums\LotteriesEnum;
use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Services\NumberDetailsService;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\LotteryResultSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MainControllerTest extends TestCase
{
    private NumberDetailsService $service;
    private Collection $results;
    private Lottery $lottery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            DatabaseSeeder::class,
            LotteryResultSeeder::class
        ]);

        $this->service = new NumberDetailsService();
        $this->lottery = Lottery::query()->firstWhere('slug', LotteriesEnum::MEGA_SENA->value);

        $this->results = LotteryResult::query()
            ->where('lottery_id', LotteriesEnum::MEGA_SENA->id())
            ->get();
    }

    public function test_it_compute_detailed_numbers_in_less_than_1s(): void
    {
        $start = microtime(true);

        $this->service->getDetailedNumbers($this->results, $this->lottery);

        $end = microtime(true);

        $this->assertLessThan(1, $end - $start);
    }

    public function test_it_computed_unlucky_numbers_in_less_than_200ms(): void
    {
        $numbers = $this->service->getDetailedNumbers($this->results, $this->lottery);

        $start = microtime(true);

        $this->service->getUnluckyNumbers($numbers);

        $end = microtime(true);

        $this->assertLessThan(0.2, $end - $start);
    }
}
