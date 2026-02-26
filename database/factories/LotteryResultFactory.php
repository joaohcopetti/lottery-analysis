<?php

namespace Database\Factories;

use App\Models\Lottery;
use App\Models\LotteryResult;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LotteryResult>
 */
class LotteryResultFactory extends Factory
{
    protected $model = LotteryResult::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lottery_id' => Lottery::factory(),
            'contest' => fake()->unique()->numberBetween(1, 3000),
            'numbers' => $this->generateLotteryNumbers(),
            'date' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
        ];
    }

    /**
     * Generate 6 unique lottery numbers between 1 and 60.
     *
     * @return array<int>
     */
    private function generateLotteryNumbers(): array
    {
        $numbers = range(1, 60);
        shuffle($numbers);
        return array_slice($numbers, 0, 6);
    }

    /**
     * Set specific numbers for the lottery result.
     *
     * @param array<int> $numbers
     * @return static
     */
    public function withNumbers(array $numbers): static
    {
        return $this->state(fn (array $attributes) => [
            'numbers' => $numbers,
        ]);
    }

    /**
     * Set specific contest number.
     *
     * @param int $contest
     * @return static
     */
    public function withContest(int $contest): static
    {
        return $this->state(fn (array $attributes) => [
            'contest' => (string) $contest,
        ]);
    }

    /**
     * Set specific date.
     *
     * @param string $date
     * @return static
     */
    public function withDate(string $date): static
    {
        return $this->state(fn (array $attributes) => [
            'date' => $date,
        ]);
    }
}
