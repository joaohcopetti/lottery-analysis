<?php

namespace App\Models;

use App\Enums\LotteriesEnum;
use Database\Factories\LotteryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lottery extends Model
{
    /** @use HasFactory<LotteryFactory> */
    use HasFactory;

    public $timestamps = false;

    /**
     * @return HasMany<LotteryResult, $this>
     */
    public function results(): HasMany
    {
        return $this->hasMany(LotteryResult::class)->orderBy('date', 'desc');
    }
}
