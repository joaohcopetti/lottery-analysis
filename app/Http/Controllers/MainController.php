<?php

namespace App\Http\Controllers;

use App\Enums\LotteriesEnum;
use App\Http\Filters\LotteryResultsFilter;
use App\Models\Lottery;
use App\Models\LotteryResult;
use App\Services\NumberDetailsService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

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
        $this->validate($request);

        /**
         * @var string
         */
        $slug = $request->query('lottery', static::$DEFAULT_LOTTERY);

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

        return Inertia::render('main/MainPage', [
            'lottery' => $lottery,
            'results' => $results,
            'numbers' => $numbers,
        ]);
    }

    private function validate(Request $request): void
    {
        $validLotteries = array_map(fn($case) => $case->value, LotteriesEnum::cases());

        Validator::make($request->all(), [
            'lottery' => [Rule::in($validLotteries)]
        ])->validate();
    }

    private function getCacheKey(Request $request, string $slug): string
    {
        $queryString = $request->getQueryString() ?? 'default';

        return "$slug:$queryString";
    }
}
