<?php

namespace App\Imports;

use App\Ckp;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CkpImport implements ToCollection
{
    protected $userId;
    protected $month;
    protected $year;
    protected $authId;
    protected $type = 1;

    public function __construct($userId, $month, $year, $authId)
    {
        $this->userId = $userId;
        $this->month = (int) $month;
        $this->year = (int) $year;
        $this->authId = $authId;
    }

    public function collection(Collection $rows)
    {
        $parsed = $this->parseRows($rows);

        $existingUtama = Ckp::where([
            ['user_id', '=', $this->userId],
            ['month', '=', $this->month],
            ['year', '=', $this->year],
            ['type', '=', $this->type],
            ['jenis', '=', 1],
        ])->orderBy('id')->get();

        $existingTambahan = Ckp::where([
            ['user_id', '=', $this->userId],
            ['month', '=', $this->month],
            ['year', '=', $this->year],
            ['type', '=', $this->type],
            ['jenis', '=', 2],
        ])->orderBy('id')->get();

        $this->saveRows($parsed['utama'], $existingUtama, 1);
        $this->saveRows($parsed['tambahan'], $existingTambahan, 2);
    }

    protected function parseRows(Collection $rows)
    {
        $result = ['utama' => [], 'tambahan' => []];
        $section = 'utama';
        $startIndex = 10;

        for ($i = $startIndex; $i < $rows->count(); $i++) {
            $row = $rows[$i];
            $label = $this->cellValue($row, 0);
            $uraian = $this->cellValue($row, 1);

            if ($this->isStopRow($label, $uraian)) {
                break;
            }

            if ($this->isSectionRow($label, $uraian)) {
                if ($this->normalize($uraian) === 'TAMBAHAN' || $this->normalize($label) === 'TAMBAHAN') {
                    $section = 'tambahan';
                }
                continue;
            }

            if (!$this->isDataRow($row)) {
                continue;
            }

            $result[$section][] = [
                'uraian' => $uraian,
                'satuan' => $this->cellValue($row, 2),
                'target_kuantitas' => $this->parseNumber($this->cellValue($row, 3)),
                'realisasi_kuantitas' => $this->parseNumber($this->cellValue($row, 4)),
                'kualitas' => $this->parseKualitas($this->cellValue($row, 6)),
            ];
        }

        return $result;
    }

    protected function saveRows(array $rows, $existingRecords, $jenis)
    {
        foreach ($rows as $index => $rowData) {
            if ($existingRecords->has($index)) {
                $model = $existingRecords[$index];
                $model->uraian = $rowData['uraian'];
                $model->satuan = $rowData['satuan'];
                $model->target_kuantitas = $rowData['target_kuantitas'];
                $model->realisasi_kuantitas = $rowData['realisasi_kuantitas'];
                $model->kualitas = $rowData['kualitas'];
                $model->updated_by = $this->authId;
                $model->save();
                continue;
            }

            $model = new Ckp();
            $model->user_id = $this->userId;
            $model->month = $this->month;
            $model->year = $this->year;
            $model->type = $this->type;
            $model->jenis = $jenis;
            $model->uraian = $rowData['uraian'];
            $model->satuan = $rowData['satuan'];
            $model->target_kuantitas = $rowData['target_kuantitas'];
            $model->realisasi_kuantitas = $rowData['realisasi_kuantitas'];
            $model->kualitas = $rowData['kualitas'];
            $model->created_by = $this->authId;
            $model->updated_by = $this->authId;
            $model->save();
        }
    }

    protected function isDataRow($row)
    {
        $uraian = $this->cellValue($row, 1);
        if ($uraian === '') {
            return false;
        }

        $no = $this->cellValue($row, 0);
        if ($no !== '' && !is_numeric($no)) {
            return false;
        }

        return true;
    }

    protected function isSectionRow($label, $uraian)
    {
        $markers = ['UTAMA', 'TAMBAHAN'];
        $normalizedLabel = $this->normalize($label);
        $normalizedUraian = $this->normalize($uraian);

        return in_array($normalizedLabel, $markers, true)
            || in_array($normalizedUraian, $markers, true);
    }

    protected function isStopRow($label, $uraian)
    {
        $stopMarkers = [
            'JUMLAH',
            'RATA-RATA',
            'CAPAIAN KINERJA PEGAWAI (CKP)',
            'CAPAIAN KINERJA PEGAWAI',
            'PENILAIAN KINERJA',
            'TIDAK ADA DATA',
        ];

        $normalizedLabel = $this->normalize($label);
        $normalizedUraian = $this->normalize($uraian);

        foreach ($stopMarkers as $marker) {
            if ($normalizedLabel === $marker || $normalizedUraian === $marker) {
                return true;
            }
        }

        return false;
    }

    protected function cellValue($row, $index)
    {
        if (!isset($row[$index]) || $row[$index] === null) {
            return '';
        }

        return trim((string) $row[$index]);
    }

    protected function normalize($value)
    {
        return strtoupper(trim((string) $value));
    }

    protected function parseNumber($value)
    {
        if ($value === '') {
            return 0;
        }

        $value = str_replace(',', '.', $value);
        $value = preg_replace('/[^0-9.\-]/', '', $value);

        return $value === '' ? 0 : (float) $value;
    }

    protected function parseKualitas($value)
    {
        if ($value === '') {
            return 0;
        }

        $value = str_replace(',', '.', $value);
        $value = preg_replace('/[^0-9.\-]/', '', $value);

        return $value === '' ? 0 : (float) $value;
    }
}
