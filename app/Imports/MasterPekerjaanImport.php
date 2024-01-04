<?php

namespace App\Imports;

use App\MasterPekerjaan;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class MasterPekerjaanImport implements ToCollection
{
    public $tahun;
    public $auth;

    public function __construct($tahun, $auth)
    {
        $this->tahun = $tahun;
        $this->auth = $auth;
    }

    public function collection(Collection $rows)
    {
        $dataRows = $rows->slice(1);
        foreach ($dataRows as $row) {
            $data = [
                'subkegiatan' => $row[0],
                'uraian_pekerjaan' => $row[1],
                'tahun' => $this->tahun,
            ];

            DB::table('master_pekerjaan')->updateOrInsert(
                [
                    'subkegiatan' => $data['subkegiatan'],
                    'uraian_pekerjaan' => $data['uraian_pekerjaan'],
                    'tahun' => $data['tahun']
                ],
                [
                    'created_by' => $this->auth->id,
                    'updated_by' => $this->auth->id
                ]
            );
        }
    }
}
