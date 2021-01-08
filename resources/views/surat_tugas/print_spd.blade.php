<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * { font-family: Segoe UI, Arial, sans-serif; font-size: x-small }
    table{ border-collapse: collapse; }
    tr, td{ padding-left: 8px; padding-bottom:3px; padding-top:3px }
    .pepet{ white-space:nowrap; width:1%; }
    .table-border{ border: 1px solid black; }
    .table-border td, th{ border: 1px solid black; }
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
            <td width="65%">{{ strtoupper($unit_kerja->nama) }}</td>
            <td>Lembar : </td>
        </tr>
    </table>

    <br/><br/><br/><br/>

    <p align="center"><b>SURAT PERJALANAN DINAS (SPD)</b></p>
    <br/>

    <table width="100%" class="table-border">
        <tr>
            <td>1.</td>
            <td>Pejabat Pembuat Komitmen</td>
            <td colspan="2">{{ $model_rincian->ppk_nama }}</td>
        </tr>
        <tr>
            <td>2.</td>
            <td>Nama pegawai yang melaksanakan perjalanan dinas</td>
            <td colspan="2">{{ $model_rincian->nama }}</td>
        </tr>
        <tr>
            <td>3.</td>
            <td>
                a. Pangkat dan golongan<br/>
                b. Jabatan / Instansi<br/>
                c. Tingkat Biaya Perjalanan Dinas<br/>
            </td>
            <td colspan="2">
                {{ $pegawai->listPangkat[$pegawai->nmgol] }} ({{ $pegawai->nmgol }})<br/>
                {{ $pegawai->nmjab }} / BPS {{ $pegawai->nmwil }}<br/>
                {{ $model_rincian->listTingkatBiaya[$model_rincian->tingkat_biaya] }}<br/>
            </td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Maksud perjalanan dinas</td>
            <td colspan="2">{{ $model->tugas }}</td>
        </tr>
        
        <tr>
            <td>5.</td>
            <td>Alat Angkutan yang dipergunakan</td>
            <td colspan="2">{{ $model_rincian->listKendaraan[$model_rincian->kendaraan] }}</td>
        </tr>

        <tr>
            <td>6.</td>
            <td>
                a. Tempat keberangkatan<br/>
                b. Tempat tujuan<br/>
            </td>
            <td colspan="2">
                BPS {{ $unit_kerja->nama }})<br/>
                {{ $model_rincian->tujuan_tugas }})<br/>
            </td>
        </tr>

        <tr>
            <td>7.</td>
            <td>
                a. Lamanya perjalanan dinas<br/>
                b. Tanggal berangkat<br/>
                c. Tanggal harus kembali/tiba ditempat baru *)<br/>
            </td>
            <td colspan="2">
                <br/>
                {{ date('d', strtotime($model_rincian->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }} {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}<br/>
                {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}<br/>
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
            <td>9.</td>
            <td>
                Pembebanan Anggaran<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Program<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Aktivitas<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; KRO<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; RO<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Komponen<br/>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sub Komponen<br/>
                <br/>
                <br/>
                a. Instansi<br/>
                b. Mata Anggaran<br/>
            </td>
            <td colspan="2">
                <br/>
                @if ($mak!=null)
                    {{ $mak->kode_program }}  &nbsp; {{ $mak->label_program }}<br/>
                    {{ $mak->kode_aktivitas }}  &nbsp; {{ $mak->label_aktivitas }}<br/>
                    {{ $mak->kode_kro }}  &nbsp; {{ $mak->label_kro }}<br/>
                    {{ $mak->kode_ro }}  &nbsp; {{ $mak->label_ro }}<br/>
                    {{ $mak->kode_komponen }}  &nbsp; {{ $mak->label_komponen }}<br/>
                    {{ $mak->kode_subkomponen }}  &nbsp; {{ $mak->label_subkomponen }}<br/>
                    
                    <br/>
                    <br/>
                    @if ($model->sumber_anggaran==2)
                    Badan Pusat Statistik Provinsi Sumatera Selatan<br/>
                    @else
                    Badan Pusat Statistik {{ $unit_kerja->nama }}<br/>
                    @endif
                    {{ $model->listKodeJenis[$model-jenis_st] }}<br/>
                @else
                @endif
            </td>
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
                Dikeluarkan di: {{ $unit_kerja->ibu_kota }}<br/>
                Pada tanggal : {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}
                <br/><br/>
            </td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td width="50%">
                <br/><br/>
                Tembusan disampaikan kepada:<br/>
                1. <br/>
                2. <br/>
            </td>
            <td width="10%"></td>
            <td width="30%" align="center">
                Pejabat Pembuat Komitmen<br/>
                BPS {{ $unit_kerja->nama }}
                <br/>
                <br/>
                <br/>
                <br/>
                <u>{{ $model_rincian->ppk_nama }}</u><br/>
                NIP. {{ $model_rincian->ppk_nip }} <br/>
            </td>
            <td width="10%"></td>
        </tr>

    </table>

    <div class="page-break"></div>

</body>
</html>