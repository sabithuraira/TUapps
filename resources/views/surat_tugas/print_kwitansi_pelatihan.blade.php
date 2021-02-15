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
    td.table-woborderlr { border-right: none; border-left: none; }
    tfoot tr td{ font-weight: bold; font-size: x-small; }
    .gray { background-color: lightgray }
    .page-break { page-break-after: always; }
</style>

</head>
<body>
    <table width="100%">
        <tr><td colspan="3" align="center"><b><u>BIAYA PERJALANAN DINAS PAKET MEETING {{ $model->tugas }}</u></b><br/></td></tr>
        <tr>
            <td width="5%"></td>
            <td width="15%">Program</td>
            <td>: {{ $mak->label_program }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="15%">Aktivitas</td>
            <td>: {{ $mak->label_aktivitas }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="15%">KRO</td>
            <td>: {{ $mak->label_kro }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="15%">RO</td>
            <td>: {{ $mak->label_ro }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="15%">Komponen</td>
            <td>: {{ $mak->label_komponen }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="15%">Akun</td>
            <td>: {{ $mak->label_subkomponen }}</td>
        </tr>
        <tr>
            <td></td>
            <td width="20%">Tanggal</td>
            <td>:
                @php 
                    $tanggalnya = "";
                    if (date('n', strtotime($model_rincian->tanggal_mulai))==date('n', strtotime($model_rincian->tanggal_selesai))) {
                        $tanggalnya = date('d', strtotime($model_rincian->tanggal_mulai)).' s.d '.date('d', strtotime($model_rincian->tanggal_selesai)).' '.config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))].' '.date('Y', strtotime($model_rincian->tanggal_selesai));
                    }else{
                        $tanggalnya = date('d', strtotime($model_rincian->tanggal_mulai)).' '.config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))].' '.date('Y', strtotime($model_rincian->tanggal_mulai)).'s.d'.date('d', strtotime($model_rincian->tanggal_selesai)).' '.config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))].' '.date('Y', strtotime($model_rincian->tanggal_selesai));        
                    }
                @endphp
                {{ $tanggalnya }}
            </td>
        </tr>
    </table>

    <br/>

    <table width="100%" class="table-border">
        <tr align="center">
            <td rowspan="2">No</td>
            <td rowspan="2">Nama Pelaksana Perjalanan Dinas</td>
            <td rowspan="2">Tanggal Penugasan</td>
            <td rowspan="2">Asal Penugasan</td>
            <td rowspan="2">Daerah Tujuan Perjalanan Dinas</td>
            <td rowspan="2">Lama Perjalanan (O-H)</td>
            <td rowspan="2">Biaya Uang Harian Perjadin</td>
            <td rowspan="2">Biaya Uang Harian Fullboard</td>
            <td colspan="2">Transport (PP)</td>
            <td rowspan="2">Jumlah Biaya Tujuan (Rp)</td>
            <td rowspan="2" colspan="2">Tanda Tangan Penerima</td>
        </tr>
        <tr align="center">
            <td>Asal (Rp)</td>
            <td>Tujuan (Rp)</td>
        </tr>
        <tr align="center">
            <td>(1)</td>
            <td>(2)</td>
            <td>(3)</td>
            <td>(4)</td>
            <td>(5)</td>
            <td>(6)</td>
            <td>(7)</td>
            <td>(8)</td>
            <td>(9)</td>
            <td>(10)</td>
            <td>(11)</td>
            <td colspan="2">(12)</td>
        </tr>
        <tr align="center">
            @php 
                $total_uang_perjadin = 0;
                $total_uang_harian = 0;
                $total_uang_asal = 0;
                $total_uang_tujuan = 0;
                $total = 0;
               
                $selisih = abs(strtotime($model_rincian->tanggal_mulai) - strtotime($model_rincian->tanggal_selesai));
                $selisih_hari = floor($selisih/(60*60*24));
            @endphp

            @foreach($list_anggota as $k=>$value)
            
                @php 
                    $total_per_row = $value->biaya_perjadin + $value->biaya_fullboard + $value->transport_pergi + $value->transport_pulang;
                
                    $total_uang_perjadin += $value->biaya_perjadin;
                    $total_uang_harian += $value->biaya_fullboard;
                    $total_uang_asal += $value->transport_pergi;
                    $total_uang_tujuan += $value->transport_pulang;
                    $total += $total_per_row;
                @endphp
                <td>{{ $k+1 }}</td>
                <td>{{ $value->nama }}</td>
                <td>{{ $tanggalnya }}</td>
                @php 
                    $uker = \App\UnitKerja::where('kode', '=', $value->unit_kerja)->first();
                @endphp
                <td>
                    @if($uker!=null)
                        {{ $uker->nama }}
                    @endif
                </td>
                <td>{{ $unit_kerja_spd->nama }}</td>
                <td>{{ ($selisih_hari+1) }} ({{ $model_rincian->terbilang($selisih_hari+1) }}) hari</td>
                <td>{{ $value->biaya_perjadin }}</td>
                <td>{{ $value->biaya_fullboard }}</td>
                <td>{{ $value->transport_pergi }}</td>
                <td>{{ $value->transport_pulang }}</td>
                <td>{{ $total_per_row }}</td>
                <td class="table-woborderlr">
                    @if($k%2==0)
                        {{ ($k+1) }}. ....
                    @endif
                </td>
                <td class="table-woborderlr">
                    @if($k%2!=0)
                        {{ ($k+1) }}. ....
                    @endif
                </td>
            @endforeach
        </tr>

        <tr align="center">
            <td colspan="6"><b>{{ $model_rincian->terbilang($total) }}<br/></td>
            <td><b>{{ $total_uang_perjadin }}<br/></td>
            <td><b>{{ $total_uang_harian }}<br/></td>
            <td><b>{{ $total_uang_asal }}<br/></td>
            <td><b>{{ $total_uang_tujuan }}<br/></td>
            <td><b>{{ $total }}<br/></td>
            <td colspan="2"></td>
        </tr>
    </table>

    <br/><br/>
    
    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="30%">
                Lunas Pada tanggal:<br/>
                Bendahara Pengeluaran<br/>
                Badan Pusat Statistik<br/>
                {{ $unit_kerja_spd->nama }}
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->bendahara_nama }}</u><br/>
                NIP. {{ $model_rincian->bendahara_nip }} <br/>
            </td>
            <td width="35%" align="center">
                Setuju dibayar:<br/>
                Pejabat Pembuat Komitmen<br/>
                Badan Pusat Statistik<br/>
                {{ $unit_kerja_spd->nama }}
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->ppk_nama }}</u><br/>
                NIP. {{ $model_rincian->ppk_nip }} <br/>
            </td>
            <td>
                &nbsp; <br/>
                {{ $unit_kerja_spd->ibu_kota }},<br/>
                Yang Menerima
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->nama }}</u><br/>
                NIP. {{ $model_rincian->nip }} <br/>
            </td>
        </tr>
    </table>
</body>
</html>