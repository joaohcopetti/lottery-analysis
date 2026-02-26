<?php

namespace App\Actions;

use Cache;
use Exception;
use GuzzleHttp\Client;
use App\Enums\LotteriesEnum;
use App\Models\LotteryResult;
use App\Data\LotterySettingsData;
use Illuminate\Support\Facades\Storage;
use App\Actions\LotteryCaixasXlsxFormatter;

class LotteryFetchAction
{
    public function execute(LotteriesEnum $lottery): void
    {
        Cache::clear();

        $settings = $this->getSettings($lottery);

        $content = $this->fetchContent($settings->endpoint);
        $filepath = $this->storeResults($settings->filename, $content);

        $data = $settings->formatter->execute($filepath);

        Storage::put($settings->base_filename . '.json', (string) json_encode($data));

        LotteryResult::query()
            ->insertOrIgnore(
                $data->map(fn($result) => [
                    ...$result,
                    'lottery_id' => $lottery->id(),
                    'numbers' => json_encode($result['numbers'])
                ])->toArray()
            );
    }

    private function getSettings(LotteriesEnum $lottery): LotterySettingsData
    {
        return match ($lottery) {
            LotteriesEnum::MEGA_SENA => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Mega-Sena',
                filename: 'mega-sena.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
            LotteriesEnum::LOTOFACIL => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Lotofacil',
                filename: 'lotofacil.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
            LotteriesEnum::QUINA => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Quina',
                filename: 'quina.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
                // LotteriesEnum::LOTOMANIA => new LotterySettingsData(
                //     endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Lotomania',
                //     filename: 'lotomania.xlsx',
                //     formatter: new LotteryCaixasXlsxFormatter($lottery)
                // ),
            LotteriesEnum::TIMEMANIA => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Timemania',
                filename: 'timemania.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
            LotteriesEnum::DUPLA_SENA => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Dupla-Sena',
                filename: 'dupla-sena.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
            LotteriesEnum::DIA_DE_SORTE => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Dia-de-Sorte',
                filename: 'dia-de-sorte.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
            LotteriesEnum::MAIS_MILIONARIA => new LotterySettingsData(
                endpoint: 'https://servicebus2.caixa.gov.br/portaldeloterias/api/resultados/download?modalidade=Milionaria',
                filename: 'mais-milionaria.xlsx',
                formatter: new LotteryCaixasXlsxFormatter($lottery)
            ),
        };
    }

    private function fetchContent(string $endpoint): string
    {
        $response = app(Client::class)->get($endpoint);

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Error while retrieving data');
        }

        return $response->getBody()->getContents();
    }

    private function storeResults(string $filename, string $content): string
    {
        Storage::put($filename, $content);

        return Storage::path($filename);
    }
}
