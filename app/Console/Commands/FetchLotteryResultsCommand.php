<?php

namespace App\Console\Commands;

use App\Actions\LotteryFetchAction;
use App\Enums\LotteriesEnum;
use Cache;
use Exception;
use App\Models\Lottery;
use Illuminate\Console\Command;

class FetchLotteryResultsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-lottery {slug? : Slug of lottery to fetch (use "all" to fetch all lotteries)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data related to a lottery and insert into the database';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!Lottery::query()->count()) {
            $this->error('No lotteries registered');
            return;
        }

        $slug = $this->argument('slug');

        if ($slug === 'all') {
            $this->fetchAll();
        } else {
            $this->executeFetch($this->promptSlug());
        }

        Cache::clear();
    }

    private function executeFetch(string $slug): void
    {
        $lottery = LotteriesEnum::from($slug);
        $this->info("Fetching {$lottery->label()} info...");

        app(LotteryFetchAction::class)->execute(LotteriesEnum::from($slug));

        $this->info("Fetch finished.");
    }

    private function fetchAll(): void
    {
        $lotteries = Lottery::all();

        $this->info("Fetching results for all {$lotteries->count()} lotteries...");

        foreach ($lotteries as $lottery) {
            $this->executeFetch($lottery->slug);
            $this->newLine();
        }

        $this->info('All lotteries fetched successfully.');
    }

    private function promptSlug(): string
    {
        $lotteries = Lottery::all();
        $slug = $this->argument('slug');

        if ($slug && $lotteries->pluck('slug')->contains($slug)) {
            return $slug;
        }

        /** @var array<string, string> $choices */
        $choices = $lotteries->mapWithKeys(
            fn($lottery) => [$lottery->slug => $lottery->label]
        )->toArray();

        $result = $this->choice(
            'Choose a lottery to fetch',
            $choices
        );

        assert(is_string($result));

        return $result;
    }
}
