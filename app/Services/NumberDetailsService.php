<?php

namespace App\Services;

use App\Data\DetailedNumberData;
use App\Models\Lottery;
use Illuminate\Support\Collection;

class NumberDetailsService
{
    /**
     * @param Collection<int, \App\Models\LotteryResult> $results
     * @return Collection<int, \App\Data\DetailedNumberData>
     */
    public function getDetailedNumbers(Collection $results, Lottery $lottery)
    {
        /**
         * @var int[]
         */
        $numbers = array_fill_keys(range($lottery->min_number, $lottery->max_number), 0);

        $resultNumbers = $results->pluck('numbers')->collapse()->all();
        $occurrences = array_count_values($resultNumbers);

        foreach ($occurrences as $number => $count) {
            $numbers[$number] = $count;
        }

        $minOccurrences = min($numbers);
        $maxOccurrences = max($numbers);
        $lastOccurrences = $this->computeAllLastOccurrences($lottery, $results);

        $result = [];
        foreach ($numbers as $number => $occurrence) {
            $weight = $this->getWeight($minOccurrences, $maxOccurrences, $occurrence);
            $result[] = DetailedNumberData::from([
                'number' => (string) $number,
                'occurrences' => $occurrence,
                'weight' => $weight,
                'lightness' => $this->getLightnessPercent($weight),
                'last_occurrence_in_contests' => $lastOccurrences[$number],
                'is_even' => $number % 2 === 0,
            ]);
        }

        return collect($result);
    }

    /**
     * @param Collection<int, \App\Models\LotteryResult> $results
     * @return array<int, int|null>
     */
    private function computeAllLastOccurrences(Lottery $lottery, Collection $results): array
    {
        $minNumber = $lottery->min_number;
        $maxNumber = $lottery->max_number;

        $lastContest = $results->first();
        if (!$lastContest) {
            return array_fill_keys(range($minNumber, $maxNumber), null);
        }

        $lastContestNumber = intval($lastContest->contest);
        $lastOccurrences = array_fill_keys(range($minNumber, $maxNumber), null);
        $foundCount = 0;

        foreach ($results as $result) {
            foreach ($result->numbers as $number) {
                if ($lastOccurrences[$number] === null) {
                    $lastOccurrences[$number] = $lastContestNumber - intval($result->contest);
                    $foundCount++;
                }
            }

            if ($foundCount >= $maxNumber - $minNumber + 1) {
                break;
            }
        }

        return $lastOccurrences;
    }

    /**
     * @param Collection<int, \App\Data\DetailedNumberData> $numbers
     * @return Collection<int, \App\Data\DetailedNumberData>
     */
    public function getUnluckyNumbers(Collection $numbers)
    {
        return $numbers->where('last_occurrence_in_contests', '>', 20)->values();
    }

    /**
     * @param int $minOccurrences
     * @param int $maxOccurrences
     * @param int $occurrences
     * @return float
     */
    private function getWeight(int $minOccurrences, int $maxOccurrences, int $occurrences): float
    {
        if ($maxOccurrences === 0 && $minOccurrences === 0) {
            return 0;
        }

        $baseWeight = ($occurrences - $minOccurrences) / ($maxOccurrences - $minOccurrences);

        return round($baseWeight * 100, 4);
    }

    private function getLightnessPercent(float $weight): float
    {
        $MAX_THRESHOLD = 90;
        $MIN_THRESHOLD = 10;

        $darkness = $weight;

        if ($weight < $MIN_THRESHOLD) {
            $darkness = $MIN_THRESHOLD;
        }

        if ($weight > $MAX_THRESHOLD) {
            $darkness = $MAX_THRESHOLD;
        }

        return 100 - $darkness;
    }
}
