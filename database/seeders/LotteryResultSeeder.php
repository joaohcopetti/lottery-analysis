<?php

namespace Database\Seeders;

use App\Actions\MegaSena\LotteryCaixasXlsxFormatter;
use App\Enums\LotteriesEnum;
use DateInterval;
use DateTime;
use DB;
use Exception;
use Hoa\Exception\Error;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Storage;

class LotteryResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $megaSenaJsonFilepath = storage_path('app/private/mega-sena.json');

        try {
            $result = json_decode(file_get_contents($megaSenaJsonFilepath), true);
        } catch (Exception $e) {
            echo "Error while retrieving JSON file, try to run \"php artisan app:fetch-lottery mega-sena\"\n";

            return;
        }

        DB::table('lottery_results')->insert(
            array_map(fn($result) => [
                ...$result,
                'lottery_id' => LotteriesEnum::MEGA_SENA->id(),
                'numbers' => json_encode($result['numbers'])
            ], $result)
        );
    }
}
