<?php

namespace App\Data;

use App\Interfaces\ResultFormatterInterface;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class LotterySettingsData extends Data
{
    #[Computed]
    public string $base_filename;

    public function __construct(
        public string $endpoint,
        public string $filename,
        public ResultFormatterInterface $formatter
    ) {
        $this->base_filename = pathinfo($this->filename)['filename'];
    }
}
