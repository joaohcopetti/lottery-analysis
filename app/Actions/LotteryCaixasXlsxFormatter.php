<?php

namespace App\Actions;

use App\Enums\LotteriesEnum;
use App\Interfaces\ResultFormatterInterface;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Services\SpreadsheetService;

class LotteryCaixasXlsxFormatter implements ResultFormatterInterface
{
    public function __construct(
        public LotteriesEnum $lottery
    ) {
        //
    }

    /**
     * @param string $filepath
     * @return Collection<int, array{contest: string, numbers: array<string>, date: string}>
     */
    public function execute(string $filepath): Collection
    {
        /**
         * @var Collection<int, array<string|null>>
         */
        $data = collect(app(SpreadsheetService::class)->spreadsheetToArray($filepath));

        $this->removeNonResults($data);

        return $data->map(fn($result) => [
            'contest' => $this->getResultContest($result),
            'numbers' => $this->getResultNumbers($result),
            'date' => $this->getResultDate($result)
        ]);
    }

    /**
     * @param Collection<int, array<string|null>>  $xlsxData
     */
    private function removeNonResults(Collection $xlsxData): void
    {
        $xlsxData->splice(0, 1);
    }

    /**
     * @param array<string|null> $result
     * @return string
     */
    private function getResultContest(array $result): string
    {
        assert($result[0] !== null);

        return $result[0];
    }

    /**
     * @param array<string|null> $result
     * @return array<string>
     */
    private function getResultNumbers(array $result): array
    {
        $numbers = array_slice($result, 2, $this->lottery->numbersPerDraw());

        if (in_array(null, $numbers)) {
            throw new Exception("Numbers array can't contain null values");
        }

        /**
         * @var array<string>
         */
        return $numbers;
    }

    /**
     * @param array<string|null> $result
     * @throws Exception
     * @return string
     */
    private function getResultDate(array $result): string
    {
        if ($result[1] === null) {
            throw new Exception("XLSX cell can't be null");
        }

        $date = Carbon::createFromFormat('d/m/Y', $result[1]);

        if ($date === null) {
            throw new Exception("Couldn't parse cell date");
        }

        return $date->toDateString();
    }
}
