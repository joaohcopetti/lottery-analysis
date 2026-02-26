<?php

namespace Tests\Unit;

use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Services\NumberDetailsService;
use Database\Factories\LotteryResultFactory;
use Illuminate\Support\Collection;
use Tests\TestCase;

class NumberDetailsServiceTest extends TestCase
{
    private NumberDetailsService $service;
    private Lottery $lottery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new NumberDetailsService();
        $this->lottery = Lottery::factory()->create();
    }

    public function test_it_returns_all_numbers_from_1_to_60(): void
    {
        $results = LotteryResultFactory::new()->count(3)->create([
            'lottery_id' => $this->lottery->id,
        ]);

        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        $this->assertCount(60, $detailedNumbers);
        $this->assertEquals(
            range(1, 60),
            $detailedNumbers->pluck('number')->toArray()
        );
    }

    public function test_it_correctly_calculates_occurrences_for_each_number(): void
    {
        // Number 5 appears in all 3 results
        // Number 10 appears in 2 results
        // Number 15 appears in 1 result
        // Other numbers appear 0 times
        $result1 = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'contest' => '100',
            'numbers' => [5, 10, 15, 20, 25, 30],
            'date' => '2024-01-01',
        ]);

        $result2 = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'contest' => '101',
            'numbers' => [5, 10, 35, 40, 45, 50],
            'date' => '2024-01-02',
        ]);

        $result3 = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'contest' => '102',
            'numbers' => [5, 55, 56, 57, 58, 59],
            'date' => '2024-01-03',
        ]);

        $results = collect([$result1, $result2, $result3]);
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        $number5 = $detailedNumbers->firstWhere('number', '5');
        $number10 = $detailedNumbers->firstWhere('number', '10');
        $number15 = $detailedNumbers->firstWhere('number', '15');
        $number1 = $detailedNumbers->firstWhere('number', '1');

        $this->assertEquals(3, $number5->occurrences);
        $this->assertEquals(2, $number10->occurrences);
        $this->assertEquals(1, $number15->occurrences);
        $this->assertEquals(0, $number1->occurrences);
    }

    public function test_it_correctly_calculates_weight_based_on_occurrences(): void
    {
        $result1 = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'numbers' => [1, 2, 3, 4, 5, 6],
        ]);

        $result2 = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'numbers' => [1, 2, 3, 4, 5, 7],
        ]);

        $results = collect([$result1, $result2]);
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        $number1 = $detailedNumbers->firstWhere('number', '1');
        $number6 = $detailedNumbers->firstWhere('number', '6');
        $number8 = $detailedNumbers->firstWhere('number', '8');

        $this->assertEquals(100.0, $number1->weight);
        $this->assertEquals(50.0, $number6->weight);
        $this->assertEquals(0.0, $number8->weight);
    }

    public function test_it_correctly_calculates_lightness_percent(): void
    {
        $result = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'numbers' => [1, 2, 3, 4, 5, 6],
        ]);

        $results = collect([$result]);
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        // Numbers 1-6 appear 1 time (max) - weight 100, capped at 90, lightness = 10
        // Numbers 7-60 appear 0 times (min) - weight 0, min darkness threshold = 10, lightness = 90
        $number1 = $detailedNumbers->firstWhere('number', '1');
        $number7 = $detailedNumbers->firstWhere('number', '7');

        // Weight 100 is capped at 90, so lightness = 100 - 90 = 10
        $this->assertEquals(10.0, $number1->lightness);
        // Weight 0 has minimum darkness threshold of 10, so lightness = 100 - 10 = 90
        $this->assertEquals(90.0, $number7->lightness);
    }

    public function test_it_applies_minimum_threshold_for_lightness(): void
    {
        // Create results where a number has very low weight (between 0 and 10)
        $results = [];

        // Create 10 results with varying numbers to create different occurrence levels
        for ($i = 0; $i < 10; $i++) {
            $numbers = [1, 2, 3, 4, 5, 6 + $i];
            $results[] = LotteryResultFactory::new()->create([
                'lottery_id' => $this->lottery->id,
                'numbers' => $numbers,
            ]);
        }

        $detailedNumbers = $this->service->getDetailedNumbers(collect($results), $this->lottery);

        // All numbers should have lightness within valid range (10 to 90 inverted, so 10-90)
        foreach ($detailedNumbers as $detailedNumber) {
            $this->assertGreaterThanOrEqual(10.0, $detailedNumber->lightness);
            $this->assertLessThanOrEqual(100.0, $detailedNumber->lightness);
        }
    }

    public function test_it_returns_null_for_last_occurrence_when_no_results(): void
    {
        $results = collect();
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        // All numbers should have null for last_occurrence_in_contests
        foreach ($detailedNumbers as $detailedNumber) {
            $this->assertNull($detailedNumber->last_occurrence_in_contests);
        }
    }

    public function test_it_correctly_identifies_even_numbers(): void
    {
        $result = LotteryResultFactory::new()->create([
            'lottery_id' => $this->lottery->id,
            'contest' => '100',
            'numbers' => [1, 2, 3, 4, 5, 6],
            'date' => '2024-01-01',
        ]);

        $results = collect([$result]);
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        $number1 = $detailedNumbers->firstWhere('number', '1');
        $number2 = $detailedNumbers->firstWhere('number', '2');
        $number59 = $detailedNumbers->firstWhere('number', '59');
        $number60 = $detailedNumbers->firstWhere('number', '60');

        $this->assertFalse($number1->is_even);
        $this->assertTrue($number2->is_even);
        $this->assertFalse($number59->is_even);
        $this->assertTrue($number60->is_even);
    }

    public function test_it_handles_empty_results_collection(): void
    {
        $results = collect();
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        $this->assertCount(60, $detailedNumbers);

        foreach ($detailedNumbers as $detailedNumber) {
            $this->assertEquals(0, $detailedNumber->occurrences);
            $this->assertEquals(0.0, $detailedNumber->weight);
            // Weight 0 has minimum darkness threshold of 10, so lightness = 100 - 10 = 90
            $this->assertEquals(90.0, $detailedNumber->lightness);
            $this->assertNull($detailedNumber->last_occurrence_in_contests);
        }
    }

    public function test_it_handles_all_zero_occurrences_correctly(): void
    {
        // When all numbers have 0 occurrences, weight should be 0
        $results = collect();
        $detailedNumbers = $this->service->getDetailedNumbers($results, $this->lottery);

        foreach ($detailedNumbers as $detailedNumber) {
            $this->assertEquals(0, $detailedNumber->occurrences);
            $this->assertEquals(0.0, $detailedNumber->weight);
        }
    }
}
