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
            <td colspan="2">{{ $model_rincian->nama }}</td>
        </tr>
        <tr>
            <td valign="top">3.</td>
            <td>
                a. Pangkat dan golongan<br/>
                b. Jabatan / Instansi<br/>
                c. Tingkat Biaya Perjalanan Dinas<br/>
            </td>
            <td colspan="2">
                {{ $pegawai->listPangkat[trim($pegawai->nmgol)] }} ({{ $pegawai->nmgol }})<br/>
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
            <td valign="top">6.</td>
            <td>
                a. Tempat keberangkatan<br/>
                b. Tempat tujuan<br/>
            </td>
            <td colspan="2">
                @if (substr($unit_kerja->kode,2)=='00' || substr($unit_kerja->kode,2,1)=='7')
                    Kota
                @else
                    Kabupaten
                @endif

                {{ $unit_kerja->ibu_kota }}<br/>
                {{ $model_rincian->tujuan_tugas }}<br/>
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
                @php 
                    $selisih = abs(strtotime($model_rincian->tanggal_mulai) - strtotime($model_rincian->tanggal_selesai));
                    $selisih_hari = floor($selisih/(60*60*24));
                @endphp
                
                {{ ($selisih_hari+1) }} ({{ $model_rincian->terbilang($selisih_hari+1) }}) hari<br/>
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
            <td width="50%" valign="top">
                <br/><br/>
                Tembusan disampaikan kepada:<br/>
                1. <br/>
                2. <br/>
            </td>
            <td width="10%"></td>
            <td width="30%" align="center">
                Pejabat Pembuat Komitmen<br/>
                BPS 
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

    <div class="page-break"></div>
    <table width="100%" class="table-border">
        <tr>
            <td width="45%"></td>
            <td width="55%">
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%" valign="top">Berangkat dari</td>
                        <td width="65%">: 
                        @if (substr($unit_kerja->kode,2)=='00' || substr($unit_kerja->kode,2,1)=='7')
                            Kota 
                        @endif
                        {{ $unit_kerja->ibu_kota }}</td>
                    </tr>
                    <tr>
                        <td width="35%">Pada tanggal</td>
                        <td width="65%">: {{ date('d', strtotime($model_rincian->tanggal_mulai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_mulai))] }} {{ date('Y', strtotime($model_rincian->tanggal_mulai)) }}</td>
                    </tr>
                    <tr>
                        <td width="35%">Ke</td>
                        <td width="65%">: {{ $model_rincian->tujuan_tugas }}<br/></td>
                    </tr>
                    
                    <tr><td colspan="2" align="center">Kepala BPS 
                        @if($unit_kerja_ttd!=null)
                            {{ $unit_kerja_ttd->nama }}
                        @else
                            {{ $unit_kerja->nama }}
                        @endif       
                    </td></tr>
                    <tr><td colspan="2" align="center"><br/><br/><br/><br/></td></tr>
                    
                    <tr><td colspan="2" align="center"><u>{{ $model_rincian->pejabat_ttd_nama }}</u></td></tr>
                    <tr><td colspan="2" align="center">NIP. {{ $model_rincian->pejabat_ttd_nip }}</td></tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top">
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%">II. Tiba di</td>
                        <td width="65%">: {{ $model_rincian->tujuan_tugas }}</td>
                    </tr>
                    <tr>
                        <td width="35%">&nbsp; &nbsp; Pada tanggal :</td>
                        <td width="65%">...........................</td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%">Berangkat dari</td>
                        <td width="65%">: {{ $model_rincian->tujuan_tugas }}</td>
                    </tr>
                    <tr>
                        <td width="35%">Ke </td>
                        <td width="65%">: BPS {{ $unit_kerja->nama }}</td>
                    </tr>
                    <tr valign="top">
                        <td width="35%">Pada tanggal </td>
                        <td width="65%">
                            : ...........................
                            <br/><br/><br/><br/><br/><br/><br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td valign="top">
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%">III. Tiba di</td><td width="65%">:</td>
                    </tr>
                    <tr>
                        <td width="35%">&nbsp; &nbsp; Pada tanggal :</td>
                        <td width="65%"></td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%">Berangkat dari</td><td width="65%">:</td>
                    </tr>
                    <tr>
                        <td width="35%">Ke </td><td width="65%">:</td>
                    </tr>
                    <tr valign="top">
                        <td width="35%">Pada tanggal </td>
                        <td width="65%">: 
                        <br/><br/><br/><br/><br/><br/><br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td valign="top">
                <table width="100%" class="table-woborder">
                    <tr><td width="35%">IV. Tiba di</td><td width="65%">:</td></tr>
                    <tr>
                        <td width="35%">&nbsp; &nbsp; Pada tanggal :</td>
                        <td width="65%"></td>
                    </tr>
                </table>
            </td>
            <td>
                <table width="100%" class="table-woborder">
                    <tr><td width="35%">Berangkat dari</td><td width="65%">:</td></tr>
                    <tr><td width="35%">Ke </td><td width="65%">:</td></tr>
                    <tr valign="top">
                        <td width="35%">Pada tanggal </td>
                        <td width="65%">: 
                            <br/><br/><br/><br/><br/><br/><br/>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="35%" valign="top">V. Tiba di</td>
                        <td width="65%">: 
                        @if (substr($unit_kerja->kode,2)=='00' || substr($unit_kerja->kode,2,1)=='7')
                            Kota 
                        @endif
                        {{ $unit_kerja->ibu_kota }}</td>
                    </tr>
                    <tr valign="top">
                        <td width="35%">&nbsp; &nbsp; Pada tanggal :<br/></td>
                        <td width="65%">: {{ date('d', strtotime($model_rincian->tanggal_selesai)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_selesai))] }} {{ date('Y', strtotime($model_rincian->tanggal_selesai)) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">Pejabat Pembuat Komitmen<br/>
                        BPS 
                        @if($unit_kerja_spd!=null)
                            {{ $unit_kerja_spd->nama }}
                        @else
                            {{ $unit_kerja->nama }}
                        @endif   
                        <br/><br/><br/><br/><br/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><u>{{ $model_rincian->ppk_nama }}</u></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">NIP. {{ $model_rincian->ppk_nip }}</td>
                    </tr>
                </table>
            </td>
            <td valign="top">
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="20%"></td>
                        <td width="80%">
                            Telah diperiksa dengan keterangan bahwa perjalanan tersebut atas 
                            perintahnya dan semata-mata untuk kepentingan jabatan dalam watu yang sesingkat-singkatnya
                            <br/><br/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td width="80%" align="center">
                            Pejabat Pembuat Komitmen<br/>
                            BPS 
                            @if($unit_kerja_spd!=null)
                                {{ $unit_kerja_spd->nama }}
                            @else
                                {{ $unit_kerja->nama }}
                            @endif   
                            <br/><br/><br/><br/><br/>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td width="80%" align="center"><u>{{ $model_rincian->ppk_nama }}</u></td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td width="80%" align="center">NIP. {{ $model_rincian->ppk_nip }}</td>
                    </tr>    
                </table>
            </td>
        </tr>
        <tr>
            <td>VI. Catatan lain-lain:</td>
            <td></td>
        </tr>
    </table>
    VII. Pehatian:<br/>
    &nbsp;&nbsp;Pejabat  yang  berwenang  memberikan  SPD,  Pegawai  yang  melakukan  perjalanan  dinas,  para pejabat  yang<br/>
    &nbsp;&nbsp;mengesahkan  tanggal berangkat/tiba  serta  Bendaharawan  bertanggung  jawab  berdasarkan  peraturan-peraturan<br/>
    &nbsp;&nbsp;keuangan Negara apabila Negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.
</p>
</body>
</html>