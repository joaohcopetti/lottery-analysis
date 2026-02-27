<?php

namespace App\Http\Middleware;

use App\Models\Lottery;
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
        $sidebarItems = [];

        if ($this->isSidebarIncluded($request)) {
            $sidebarItems = Cache::rememberForever(
                'sidebar-items',
                fn() => $this->getSidebarItems($request)
            );
        }

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebar-items' => $sidebarItems
        ];
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
            'url' => route('main', $request->query())
        ]);
    }
}
