<?php

namespace App\Http\Controllers;

use App\Models\Lottery;
use Inertia\Inertia;
use App\Enums\LotteriesEnum;
use Illuminate\Http\Request;
use App\Models\LotteryResult;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Services\NumberDetailsService;
use App\Http\Filters\LotteryResultsFilter;

class MainController extends Controller
{
    protected static string $DEFAULT_LOTTERY = 'mega-sena';

    public function __construct(
        private NumberDetailsService $numberDetailsService
    ) {
        //
    }

    /**
     * @return \Inertia\Response
     */
    public function __invoke(Request $request)
    {
        /**
         * @var string
         */
        $slug = $request->query('loteria', static::$DEFAULT_LOTTERY);

        $cacheKey = $this->getCacheKey($request, $slug);

        $lottery = Lottery::firstWhere('slug', $slug);

        assert(!!$lottery);

        $resultsBuilder = LotteryResult::query()
            ->where('lottery_id', $lottery->id);

        $results = app(LotteryResultsFilter::class)
            ->apply($request, $resultsBuilder)
            ->orderByDesc('date')
            ->get();

        /**
         * @var Collection<int, \App\Data\DetailedNumberData>
         */
        $numbers = Cache::rememberForever(
            "detailed-numbers:$cacheKey",
            fn() => $this->numberDetailsService->getDetailedNumbers($results, $lottery)
        );

        // $unluckyNumbers = Cache::rememberForever(
        //     "unlucky-numbers:$cacheKey",
        //     fn() => $this->numberDetailsService->getUnluckyNumbers($numbers)
        // );


        $minDate = LotteryResult::first()?->date?->format('Y-m-d');
        $maxDate = LotteryResult::orderBy('date', 'desc')->first()?->date?->format('Y-m-d');

        return Inertia::render('main/MainPage', [
            'lottery' => $lottery,
            'results' => $results,
            'numbers' => $numbers,
            // 'unluckyNumbers' => $unluckyNumbers,
            'metadata' => [
                'minDate' => $minDate,
                'maxDate' => $maxDate,
            ]
        ]);
    }

    private function getCacheKey(Request $request, string $slug): string
    {
        $queryString = $request->getQueryString() ?? 'default';

        return "$slug:$queryString";
    }
}
