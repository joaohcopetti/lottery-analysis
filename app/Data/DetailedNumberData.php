<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class DetailedNumberData extends Data
{
    public function __construct(
        public string $number,
        public int $occurrences,
        public float $weight,
        public float $lightness,
        public int|null $last_occurrence_in_contests,
        public bool $is_even
    ) {
        //
    }
}
