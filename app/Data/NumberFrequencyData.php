<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class NumberFrequencyData extends Data
{
    public function __construct(
        public int $number,
        public int $interval,
        public string $date,
    ) {
        //
    }
}
