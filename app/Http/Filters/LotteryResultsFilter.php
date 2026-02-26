<?php

namespace App\Http\Filters;

use Illuminate\Http\Request;
use App\Models\LotteryResult;
use Illuminate\Database\Eloquent\Builder;

class LotteryResultsFilter
{
    /**
     * @var Builder<LotteryResult>
     */
    private Builder $query;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Database\Eloquent\Builder<LotteryResult> $query
     * @return Builder<LotteryResult>
     */
    public function apply(Request $request, Builder $query): Builder
    {
        $this->query = $query->clone();

        foreach ($request->all() as $key => $value) {
            if (method_exists($this, $key)) {
                $this->$key($value);
            }
        }

        return $this->query;
    }

    private function date(string $value): void
    {
        $this->query->where('date', '>=', $value);
    }
}
