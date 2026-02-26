<?php

namespace Database\Factories;

use App\Models\Lottery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lottery>
 */
class LotteryFactory extends Factory
{
    protected $model = Lottery::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'label' => 'Mega Sena',
            'slug' => 'mega-sena',
            'numbers_per_draw' => 6,
            'numbers_per_line' => 6,
            'max_number' => 60,
            'min_number' => 1,
        ];
    }

    /**
     * Create a lottery with custom label and slug.
     *
     * @param string $label
     * @param string $slug
     * @return static
     */
    public function forLottery(string $label, string $slug): static
    {
        return $this->state(fn(array $attributes) => [
            'label' => $label,
            'slug' => $slug,
        ]);
    }
}
