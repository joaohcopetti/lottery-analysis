<?php

namespace App\Http\Middleware;

use App\Enums\LotteriesEnum;
use App\Models\Lottery;
use App\Models\LotteryResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * @var array<string>
     */
    protected static array $MAIN_SIDEBAR_ROUTES = [
        'main',
        'stats'
    ];

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $shared = [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'metadata' => $this->getMetadata($request)
        ];

        if ($this->isSidebarIncluded($request)) {
            $shared['sidebar-items'] = Cache::rememberForever(
                'sidebar-items',
                fn() => $this->getSidebarItems($request)
            );
        }

        return $shared;
    }

    private function isSidebarIncluded(Request $request): bool
    {
        return $request->routeIs(static::$MAIN_SIDEBAR_ROUTES);
    }

    /**
     * @return Collection<int, array{label: string, slug: string, url: string}>
     */
    private function getSidebarItems(Request $request): Collection
    {
        return Lottery::all()->map(fn($lottery) => [
            'label' => $lottery->label,
            'slug' => $lottery->slug,
            'url' => route('main', [
                ...$request->query(),
                'lottery' => $lottery->slug
            ])
        ]);
    }

    /**
     * @return array<string,mixed>
     */
    private function getMetadata(Request $request): array
    {
        $slug = $request->query('lottery') ?? 'mega-sena';

        [$oldestDrawDate, $newestDrawDate] = Cache::rememberForever(
            "$slug:draw-dates",
            function () use ($slug) {
                $lottery = Lottery::firstWhere('slug', $slug);

                assert(!!$lottery);

                /**
                 * @var Carbon
                 */
                $oldestDate = LotteryResult::where('lottery_id', $lottery->id)
                    ->orderBy('date')
                    ->first()
                    ->date ?? Carbon::create(1990, 01, 01);

                /**
                 * @var Carbon
                 */
                $newestDate = LotteryResult::where('lottery_id', $lottery->id)
                    ->orderByDesc('date')
                    ->first()
                    ->date ?? Carbon::now();

                return [$oldestDate->format('Y-m-d'), $newestDate->format('Y-m-d')];
            }
        );

        return [
            'oldestDrawDate' => $oldestDrawDate,
            'newestDrawDate' => $newestDrawDate
        ];
    }
}
