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
            <td width="25%">Lampiran SPD</td>
            <td></td>
        </tr>
        <tr>
            <td width="25%">Nomor</td>
            <td>: {{ $model_rincian->nomor_spd }}</td>
        </tr>
        <tr>
            <td width="25%">Tanggal</td>
            <td>: {{ date('d M Y', strtotime($model_rincian->tanggal_mulai)) }}</td>
        </tr>
        <tr>
            <td width="25%">DAFTAR PESERTA KEGIATAN</td>
            <td>: {{ date('d M Y', strtotime($model_rincian->tanggal_mulai)) }}</td>
        </tr>
        <tr>
            <td width="25%">TANGGAL PENYELENGGARAAN</td>
            <td>: 
            @if (date('n', strtotime($model_rincian->tanggal_mulai))==date('n', strtotime($model_rincian->tanggal_selesai)))
                @if(date('Y-m-d', strtotime($model_rincian->tanggal_mulai))==date('Y-m-d', strtotime($model_rincian->tanggal_selesai)))
                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                @else
                    {{ date('d', strtotime($model_rincian->tanggal_mulai)) }}
                    s.d 
                    {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}
                @endif
            @else
                {{ date('d', strtotime($model_rincian->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }} {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}
                s.d 
                {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}                
            @endif
            </td>
        </tr>
        <tr>
            <td width="25%">TEMPAT PENYELENGGARAAN</td>
            <td>: {{ $model_rincian->tujuan_tugas }}</td>
        </tr>
        <tr>
            <td width="25%">SATUAN KERJA</td>
            <td>: Badan Pusat Statistik {{ $unit_kerja->nama }}</td>
        </tr>
        <tr>
            <td width="25%">KEMENTRIAN NEGARA / LEMBAGA</td>
            <td>: Badan Pusat Statistik</td>
        </tr>
    </table>

    <br/>

    <table width="100%" class="table-border">
        <tr>
            <td width="2%" rowspan="2">No</td>
            <td rowspan="2" align="center">Nama</td>
            <td rowspan="2" align="center">Jabatan</td>
            <td rowspan="2" align="center">Gol</td>
            <td rowspan="2" align="center">Tempat Kedudukan</td>
            <td rowspan="2" align="center">Tingkat Biaya Perjalanan Dinas</td>
            <td rowspan="2" align="center">Alat Angkutan yang digunakan</td>
            <td colspan="2" align="center">Surat Tugas</td>
            <td colspan="2" align="center">Tanggal</td>
            <td rowspan="2" align="center">Lamanya Perjalanan Dinas</td>
            <td rowspan="2" align="center">Ket.</td>
        </tr>
        <tr>
            <td align="center">Nomor</td>
            <td align="center">Tanggal</td>
            <td align="center">Keberangkatan dari tempat kedudukan asal</td>
            <td align="center">Tiba kembali kedudukan asal</td>
        </tr>
        @php 
            $selisih = abs(strtotime($model_rincian->tanggal_mulai) - strtotime($model_rincian->tanggal_selesai));
            $selisih_hari = floor($selisih/(60*60*24));
        @endphp
        
        @foreach($list_anggota as $key=>$value)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $value->nama }}</td>
                <td>
                    @if(strlen($value->jabatan)>0)
                        {{ $value->jabatan }}
                    @else
                        Mitra
                    @endif
                </td>
                <td>
                    @if(strlen($value->gol)>0)
                        {{ $value->gol }}
                    @else
                        -
                    @endif
                </td>
                @php 
                    $uker = \App\UnitKerja::where('kode', '=', $value->unit_kerja)->first();
                @endphp
                <td>
                    @if($uker!=null)
                        {{ $uker->nama }}
                    @endif
                </td>
                <td align="center">{{ $model_rincian->listTingkatBiaya[$value->tingkat_biaya] }}</td>
                <td align="center">{{ $model_rincian->listKendaraan[$value->kendaraan] }}</td>
                <td>{{ $model_rincian->nomor_st }}</td>
                <td>{{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}</td>
                <td>{{ date('d/m/Y', strtotime($model_rincian->tanggal_mulai)) }}</td>
                <td>{{ date('d/m/Y', strtotime($model_rincian->tanggal_selesai)) }}</td>
                <td>{{ ($selisih_hari+1) }} ({{ $model_rincian->terbilang($selisih_hari+1) }}) hari</td>
                <td></td>
            </tr>
        @endforeach()
    </table>

    <br/><br/>
    
    <table width="100%">
        <tr>
            <td width="50%" valign="top"></td>
            <td width="10%"></td>
            <td width="30%" align="center">
                @if($unit_kerja_spd!=null)
                    {{ $unit_kerja_spd->ibu_kota }}
                @else
                    {{ $unit_kerja->ibu_kota }}
                @endif  
                , {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }} <br/>
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