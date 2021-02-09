<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * { font-family: Times New Roman, Times, serif; font-size: x-small }
    table{ border-collapse: collapse; }
    tr, td{ padding-left: 8px; padding-bottom:3px; padding-top:3px }
    .pepet{ white-space:nowrap; width:1%; }
    .table-border{ border: 1px solid black; }
    .table-border td, th{ border: 1px solid black; }
    .table-woborder{ border: none; }
    .table-woborder td, th{ border: none; }
    td.table-woborder { border: none; }
    td.table-wobordertb { border-top: none; border-bottom: none; }
    tfoot tr td{ font-weight: bold; font-size: x-small; }
    .gray { background-color: lightgray }
    .page-break { page-break-after: always; }
</style>

</head>
<body>
    <table width="100%">
        <tr>
            <td width="65%">BADAN PUSAT STATISTIK</td>
            <td>Nomor : {{ $model_rincian->nomor_spd }}</td>
        </tr>
        <tr>
            <td width="65%">
                {{ strtoupper($unit_kerja_spd->nama) }}
            </td>
            <td>Lembar : </td>
        </tr>
    </table>

    <br/><br/><br/>

    <p align="center"><b>SURAT PERJALANAN DINAS (SPD)</b></p>
    <br/>

    <table width="100%" class="table-border">
        <tr>
            <td width="5%">1.</td>
            <td width="38%">Pejabat Pembuat Komitmen</td>
            <td colspan="2">{{ $model_rincian->ppk_nama }}</td>
        </tr>
        <tr>
            <td valign="top">2.</td>
            <td>Nama pegawai yang melaksanakan perjalanan dinas</td>
            <td colspan="2">Terlampir</td>
        </tr>
        <tr>
            <td valign="top">3.</td>
            <td>
                a. Pangkat dan golongan<br/>
                b. Jabatan / Instansi<br/>
                c. Tingkat Biaya Perjalanan Dinas<br/>
            </td>
            <td colspan="2">
                Terlampir<br/>
                Terlampir<br/>
                Terlampir<br/>
        </tr>
        <tr>
            <td>4.</td>
            <td>Maksud perjalanan dinas</td>
            <td colspan="2">{{ $model->tugas }}</td>
        </tr>
        
        <tr>
            <td>5.</td>
            <td>Alat Angkutan yang dipergunakan</td>
            <td colspan="2">Terlampir</td>
        </tr>

        <tr>
            <td valign="top">6.</td>
            <td>
                a. Tempat keberangkatan<br/>
                b. Tempat tujuan<br/>
            </td>
            <td colspan="2">
                Terlampir<br/>
                Terlampir<br/>
            </td>
        </tr>

        <tr>
            <td valign="top">7.</td>
            <td>
                a. Lamanya perjalanan dinas<br/>
                b. Tanggal berangkat<br/>
                c. Tanggal harus kembali/tiba ditempat baru *)<br/>
            </td>
            <td colspan="2">
                Terlampir<br/>
                Terlampir<br/>
                Terlampir<br/>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Pengikut</td>
            <td>Umur</td>
            <td>Hubungan keluarga/keterangan</td>
        </tr>
        
        <tr>
            <td><br/><br/><br/><br/></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr>
            <td valign="top" rowspan="9">9.</td>
            <td class="table-wobordertb">
                Pembebanan Anggaran
            </td>
            <td  class="table-wobordertb" colspan="2">
            </td>
        </tr>
        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; Program</td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_program }}</td>
            <td class="table-woborder">{{ $mak->label_program }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>
    
        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; Aktivitas</td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_aktivitas }}</td>
            <td class="table-woborder">{{ $mak->label_aktivitas }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>

        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; KRO</td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_kro }}</td>
            <td class="table-woborder">{{ $mak->label_kro }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>
        
        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; RO</td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_ro }}</td>
            <td class="table-woborder">{{ $mak->label_ro }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>
        
        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; Komponen</td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_komponen }}</td>
            <td class="table-woborder">{{ $mak->label_komponen }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>
        
        <tr>
            <td class="table-wobordertb" valign="top">&nbsp; &nbsp; Sub Komponen<br/><br/><br/></td>
            @if ($mak!=null)
            <td class="table-woborder" width="15%" valign="top">{{ $mak->kode_subkomponen }}</td>
            <td class="table-woborder" valign="top">{{ $mak->label_subkomponen }}</td>
            @else
            <td class="table-woborder" width="15%"></td>
            <td class="table-woborder"></td>
            @endif
        </tr>
        
        <tr>
            <td class="table-wobordertb">a. Instansi</td>
            <td class="table-woborder" colspan="2">
            @if ($model->sumber_anggaran==2)
                Badan Pusat Statistik Provinsi Sumatera Selatan
            @else
                Badan Pusat Statistik {{ $unit_kerja->nama }}
            @endif
            </td>
        </tr>
        
        <tr>
            <td class="table-wobordertb">b. Mata Anggaran</td>
            <td class="table-woborder" colspan="2">{{ $model->listKodeJenis[$model->jenis_st] }}</td>
        </tr>
        
        <tr>
            <td>10.</td>
            <td>Keterangan lain-lain</td>
            <td colspan="2"></td>
        </tr>
    </table>

    <br/><br/>
    
    <table width="100%">
        <tr>
            <td width="50%">
            </td>
            <td width="10%"></td>
            <td width="30%">
                Dikeluarkan di: 
                @if($unit_kerja_spd!=null)
                    {{ $unit_kerja_spd->ibu_kota }}
                @else
                    {{ $unit_kerja->ibu_kota }}
                @endif   
                <br/>
                Pada tanggal : {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}
                <br/><br/>
            </td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td width="50%" valign="top"></td>
            <td width="10%"></td>
            <td width="30%" align="center">
                Pejabat Pembuat Komitmen<br/>
                Badan Pusat Statistik<br/> 
                @if($unit_kerja_spd!=null)
                    {{ $unit_kerja_spd->nama }}
                @else
                    {{ $unit_kerja->nama }}
                @endif   
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->ppk_nama }}</u><br/>
                NIP. {{ $model_rincian->ppk_nip }} <br/>
            </td>
            <td width="10%"></td>
        </tr>

    </table>
</body>
</html>