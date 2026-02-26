<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ResultFormatterInterface
{
    /**
     * @return Collection<int, array{contest: string, numbers: array<string>, date: string}>
     */
    public function execute(string $filepath): Collection;
}
