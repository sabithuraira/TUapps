<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class SertifikatPesertaNamaImport implements ToCollection
{
    use Importable;

    /** @var array */
    public $names = [];

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            $cell = isset($row[0]) ? trim((string) $row[0]) : '';
            if ($cell === '') {
                continue;
            }
            if ($i === 0 && stripos($cell, 'nama') !== false) {
                continue;
            }
            $this->names[] = $cell;
        }
    }
}
