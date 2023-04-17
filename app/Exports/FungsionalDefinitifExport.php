<?php

namespace App\Exports;

use App\FungsionalDefinitif;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FungsionalDefinitifExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
        // dd($this->request->kab_filter);
    }

    public function Collection()
    {
        return FungsionalDefinitif::where('kode_wilayah', "LIKE", '%' . $this->request->kab_filter . '%')->get();
    }

    public function map($data): array
    {
        return [
            $data->nama_jabatan,
            $data->abk,
            count($data->user($this->request->kab_filter)),
            $data->user($this->request->kab_filter)->pluck('name')->implode("\n"),
        ];
    }
    public function headings(): array
    {
        return ['Jabatan', 'ABK', 'Existing', 'Pegawai'];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D50')->getAlignment()->setWrapText(true);
    }
}
