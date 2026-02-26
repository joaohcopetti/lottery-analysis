<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;

class SpreadsheetService
{
    /**
     * @return array<mixed[]>
     */
    public function spreadsheetToArray(string $filepath): array
    {
        return SpreadsheetFactory::load(
            $filepath,
            IReader::READ_DATA_ONLY,
            [
                SpreadsheetFactory::READER_XLSX
            ]
        )->getActiveSheet()->toArray();
    }
}
