<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border-collapse: collapse;
    }

    tr, td{ padding-left: 8px; }

    .table-border{ border: 1px solid black; }
    
    .table-border td, th{ border: 1px solid black; }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .gray { background-color: lightgray }
</style>

</head>
<body>
    <h3 align="center">
        PENILAIAN CAPAIAN SASARAN KERJA<br/>
        PEGAWAI NEGERI SIPIL
    </h3>

    <p>
        Jangka Waktu Penilaian
        {{ date('d', strtotime($skp_induk->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($skp_induk->tanggal_mulai))] }} 
        s.d 
        {{ date('d', strtotime($skp_induk->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($skp_induk->tanggal_selesai))] }} {{ date('Y', strtotime($skp_induk->tanggal_selesai)) }}       
    </p>

    <table width="100%" class="table-border">
        <thead>
            <tr align="center">
                <td rowspan="2">NO</td>
                <td rowspan="2">I. Kegiatan Tugas Jabatan</td>
                <td rowspan="2">AK</td>
                <td colspan="6">TARGET</td>
                <td rowspan="2">AK</td>
                <td rowspan="6">REALISASI</td>
                <td rowspan="2">PENGHITUNGAN</td>
                <td rowspan="2">NILAI CAPAIAN SKP</td>
            </tr>
            
            <tr align="center">
                <td colspan="2">Kuant/Output</td>
                <td>Kual/Mutu</td>
                <td colspan="2">Waktu</td>
                <td>Biaya</td>
                <td colspan="2">Kuant/Output</td>
                <td>Kual/Mutu</td>
                <td colspan="2">Waktu</td>
                <td>Biaya</td>
            </tr>

            <tr align="center">
                @for($i=1;$i<=14;++$i)
                    <td>{{ $i }}</td>
                @endfor 
            </tr>
        </thead>

        <tbody>
            @foreach($skp_pengukuran as $key=>$rincian)
                <td>{{ $key+1 }}</td>
                <td>{{ $rincian->uraian }}</td>
                <td>{{ $rincian->target_angka_kredit }}</td>
                <td>{{ $rincian->target_kuantitas }}</td>
                <td>{{ $rincian->target_satuan }}</td>
                <td>{{ $rincian->target_kualitas }}</td>
                <td>{{ $rincian->target_waktu }}</td>
                <td>{{ $rincian->target_satuan_waktu }}</td>
                <td>{{ $rincian->target_biaya }}</td>
                
                <td>{{ $rincian->realisasi_angka_kredit }}</td>
                <td>{{ $rincian->realisasi_kuantitas }}</td>
                <td>{{ $rincian->realisasi_satuan }}</td>
                <td>{{ $rincian->realisasi_kualitas }}</td>
                <td>{{ $rincian->realisasi_waktu }}</td>
                <td>{{ $rincian->realisasi_satuan_waktu }}</td>
                <td>{{ $rincian->realisasi_biaya }}</td>
                <td>{{ $rincian->penghitungan }}</td>
                <td>{{ $rincian->nilai_capaian_skp }}</td>
            @endfor 
        </tbody>
    </table>

    <br/>
    <table width="30%">
        
        @if ($type==1)
            <tr><td><b>Kesepakatan Target</b></td></tr>
            <tr><td>Tanggal : {{ $first_working_day }}</td></tr>
        @else
            <tr><td><b>Penilaian Kinerja</b></td></tr>
            <tr><td>Tanggal : {{ $last_working_day }}</td></tr>
        @endif
    </table>
    
    <br/>
    
    <table width="100%">
        <tr>
            <td width="15%"></td>
            <td width="25%" align="center">
                <p>Pegawai Yang Dinilai</p>
                <br/>
                <br/>
                ( {{ $user->name }} )<br/>
                NIP.  {{ $user->nip_baru }}
            </td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <p>Pejabat Penilai</p>
                <br/>
                <br/>
                ( {{ $user->pimpinan->name }} )<br/>
                NIP.   {{ $user->pimpinan->nip_baru }} <br/>
            </td>
            <td width="15%"></td>
        </tr>

    </table>

</body>
</html>