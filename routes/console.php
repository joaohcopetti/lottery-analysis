<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\FetchLotteryResultsCommand;

Schedule::command(FetchLotteryResultsCommand::class, ['mega-sena'])->hourly();
