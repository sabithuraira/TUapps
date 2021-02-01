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
        <tr><td colspan="4" align="center"><b><u>PERINCIAN PERHITUNGAN BIAYA PERJALANAN DINAS</u></b></td></tr>
        <tr>
            <td width="15%"></td>
            <td width="35%">Lampiran SPD Nomor</td>
            <td>: {{ $model_rincian->nomor_spd }}</td>
            <td width="15%"></td>
        </tr>
        <tr>
            <td width="15%"></td>
            <td width="35%">Tanggal</td>
            <td>: {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}<br/></td>
            <td width="15%"></td>
        </tr>
    </table>

    <br/>

    <table width="100%" class="table-border">
        <tr align="center">
            <td width="5%">No.</td>
            <td>Perincian Biaya</td>
            <td>Jumlah</td>
            <td width="20%">Keterangan</td>
        </tr>
        <tr align="center">
            <td width="5%">(1)</td>
            <td>(2)</td>
            <td>(3)</td>
            <td width="20%">(4)</td>
        </tr>
        <tr>
            <td width="5%" valign="top">1</td>
            <td>
                <table width="100%" class="table-woborder">
                    <tr>
                        <td width="40%" valign="top">Nama yang bertugas</td>
                        <td width="65%">: {{ $model_rincian->nama }}</td>
                    </tr>
                    <tr>
                        <td>Golongan</td>
                        <td width="65%">: {{ $pegawai->nmgol }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Tugas</td>
                        <td width="65%">: {{ $model_rincian->tujuan_tugas }}</td>
                    </tr>
                    
                    <tr>
                        <td>Lamanya Tugas</td>
                        <td width="65%">: 
                            @php 
                                $selisih = abs(strtotime($model_rincian->tanggal_mulai) - strtotime($model_rincian->tanggal_selesai));
                                $selisih_hari = floor($selisih/(60*60*24));
                                $total_rowspan = 4 + count($model_kwitansi);
                                $total_biaya = 0;
                            @endphp
                            {{ ($selisih_hari+1) }} ({{ $model_rincian->terbilang($selisih_hari+1) }}) hari    
                        <br/></td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td rowspan="{{ $total_rowspan }}"></td>
        </tr>
        
        @foreach($model_kwitansi as $index=>$value)
            @php 
                $total_biaya += $value->anggaran;
            @endphp
            <tr>
                <td class="table-wobordertb">{{ ($index+2) }}</td>
                <td class="table-wobordertb">{{ $value->rincian }}</td>
                <td class="table-wobordertb" align="right">Rp. {{  number_format($value->anggaran,0,",",".")  }}</td>
            </tr>
        @endforeach
        <tr>
            <td class="table-wobordertb"><br/></td>
            <td class="table-wobordertb"></td>
            <td class="table-wobordertb"></td>
        </tr>
        
        <tr>
            @php 
                $total_biaya += $model_kwitansi_rill_total;
            @endphp
            <td class="table-wobordertb"></td>
            <td class="table-wobordertb">Total Pengeluaran Riil</td>
            <td class="table-wobordertb" align="right">Rp. {{  number_format($model_kwitansi_rill_total,0,",",".")  }}</td>
        </tr>
         
        <tr>
            <td></td>
            <td align="center">Jumlah</td>
            <td align="right">Rp. {{  number_format($total_biaya,0,",",".")  }}</td>
        </tr>
        
        <tr>
            <td></td>
            <td colspan="3">
                Terbilang : {{  $model_rincian->terbilang($total_biaya) }} rupiah
            </td>
        </tr>
    </table>

    <br/><br/>
    
    <table width="100%">
        <tr>
            <td width="50%"></td>
            <td width="10%"></td>
            <td width="30%">{{ $unit_kerja_spd->ibu_kota }},<br/></td>
            <td width="10%"></td>
        </tr>
        <tr>
            <td width="50%">
                Telah dibayar sejumlah<br/>
                Rp. {{  number_format($total_biaya,0,",",".")  }}
            </td>
            <td width="10%"></td>
            <td width="30%">
                Telah menerima jumlah uang sebesar<br/>
                Rp. {{  number_format($total_biaya,0,",",".")  }}
            </td>
            <td width="10%"></td>
        </tr>
        
        <tr>
            <td width="50%">Lunas pada tanggal:</td>
            <td width="10%"></td>
            <td width="30%"><br/></td>
            <td width="10%"></td>
        </tr>

        <tr>
            <td width="50%" valign="top">
                Bendahara Pengeluaran<br/>
                Badan Pusat Statistik<br/>
                {{ $unit_kerja_spd->nama }}
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->bendahara_nama }}</u><br/>
                NIP. {{ $model_rincian->bendahara_nip }} <br/>
            </td>
            <td width="10%"></td>
            <td width="30%" align="center" valign="top">
                Yang Menerima
                <br/><br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->nama }}</u><br/>
                NIP. {{ $model_rincian->nip }} <br/>
            </td>
            <td width="10%"></td>
        </tr>
    </table>

    <br/><br/><br/>

    <table width="100%">
        <tr>
            <td colspan="4" align="center">PERHITUNGAN SPD RAMPUNG<br/></td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="40%">Ditetapkan sejumlah</td>
            <td width="35%">Rp. {{  number_format($total_biaya,0,",",".")  }}</td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="40%">Yang telah dibayar sejumlah</td>
            <td width="35%">Rp. 0</td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td width="20%"></td>
            <td width="40%" valign="top">Sisa kurang/lebih</td>
            <td width="35%">Rp. {{  number_format($total_biaya,0,",",".")  }}<br/><br/><br/></td>
            <td width="5%"></td>
        </tr>
        
        <tr>
            <td width="20%"></td>
            <td width="40%"></td>
            <td width="35%" align="center">
                Pejabat Pembuat Komitmen<br/>
                Badan Pusat Statistik<br/> 
                {{ $unit_kerja_spd->nama }}
                <br/><br/><br/><br/><br/>
                <u>{{ $model_rincian->ppk_nama }}</u><br/>
                NIP. {{ $model_rincian->ppk_nip }} <br/>
            </td>
            <td width="5%"></td>
        </tr>
    </table>

    <div class="page-break"></div>

    <table width="100%">
        <tr>
            <td class="pepet">
                <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:100px">
            </td>
        </tr>
    </table>

    <div align="center"><b>KWITANSI</b></div><br/>

    <table width="100%">
        <tr>
            <td width="5%"></td>
            <td width="25%">Sudah Terima dari</td>
            <td width="1%">:</td>
            <td>Pejabat Pembuat Komitmen BPS {{ $unit_kerja->nama }}</td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td>Uang sebanyak</td>
            <td width="1%">:</td>
            <td>Rp. {{  number_format($total_biaya,0,",",".")  }}</td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td valign="top">Untuk pembayaran</td>
            <td width="1%">:</td>
            <td>
                Biaya Perjalanan Dinas dalam Rangka {{ $model->tugas }}<br/>
                {{ $mak->label_program }}<br/>
                @if($model->sumber_anggaran==1)
                    Anggaran Badan Pusat Statistik {{ $unit_kerja->nama }} Tahun Anggaran {{ date('Y', strtotime($model_rincian->created_at)) }}
                @elseif($model->sumber_anggaran==2)
                    Anggaran Badan Pusat Statistik Provinsi Sumatera Selatan Tahun Anggaran {{ date('Y', strtotime($model_rincian->created_at)) }}
                @else
                    Bukan Anggaran Badan Pusat Statistik
                @endif
                <br/>
                selama {{ ($selisih_hari+1) }} Hari (Rincian terlampir)
            </td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td>Berdasarkan SPPD</td>
            <td width="1%">:</td>
            <td>Nomor: {{ $model_rincian->nomor_spd }} Tanggal: {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}</td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td>Untuk perjalanan dinas dari</td>
            <td width="1%">:</td>
            <td>BPS {{ $unit_kerja->nama }} ke {{ $model_rincian->tujuan_tugas }} (PP)</td>
        </tr>
        
        <tr>
            <td width="5%"></td>
            <td>Terbilang</td>
            <td width="1%">:</td>
            <td>{{  $model_rincian->terbilang($total_biaya) }} rupiah</td>
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

    @if(count($model_kwitansi_rill)>0)
        <div class="page-break"></div>

        <div align="center"><b>DAFTAR PENGELUARAN RIIL</b></div><br/>

        <table width="100%">
            <tr>
                <td width="5%"></td>
                <td colspan="2">Yang bertanda tangan di bawah ini:</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="25%">Nama</td>
                <td>: {{ $model_rincian->nama }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="25%">NIP</td>
                <td>: {{ $model_rincian->nip }}</td>
            </tr>
            <tr>
                <td width="5%"></td>
                <td width="25%">Jabatan</td>
                <td>: {{ $model_rincian->jabatan }}</td>
            </tr>
        </table>
        
        <div>Berdasarkan Surat Perjalanan Dinas (SPD) Nomor: {{ $model_rincian->nomor_spd }} tanggal: {{ date('d', strtotime($model_rincian->created_at)) }} {{ config('app.months')[date('n', strtotime($model_rincian->created_at))] }} {{ date('Y', strtotime($model_rincian->created_at)) }}, dengan ini kami menyatakan dengan</div><br/>
        <div>1. Biaya transport pegawai dan/atau biaya penginapan di bawah ini yang tidak dapat diperoleh bukti-bukti pengeluarannya, meliputi:</div>
    
        <table width="100%" class="table-border">
            <tr align="center">
                <td width="5%">No.</td>
                <td>URAIAN</td>
                <td>Jumlah<br/>(Rp)</td>
                <td width="20%">Keterangan</td>
            </tr>
            <tr align="center">
                <td width="5%">(1)</td>
                <td>(2)</td>
                <td>(3)</td>
                <td width="20%">(4)</td>
            </tr>
           
            @php 
                $total_rowspan_riil = 2 + count($model_kwitansi);
                $total_biaya_riil = 0;
            @endphp  
                            
            @foreach($model_kwitansi_rill as $index=>$value)
                @php 
                    $total_biaya_riil += $value->anggaran;
                @endphp
                <tr>
                    <td class="table-wobordertb">{{ ($index+1) }}</td>
                    <td class="table-wobordertb">{{ $value->rincian }}</td>
                    <td class="table-wobordertb" align="right">Rp. {{  number_format($value->anggaran,0,",",".")  }}</td>
                    @if($index==0)
                        <td rowspan="{{ $total_rowspan_riil }}"></td>
                    @endif
                </tr>
            @endforeach

            <tr>
                <td class="table-wobordertb"><br/></td>
                <td class="table-wobordertb"></td>
                <td class="table-wobordertb"></td>
            </tr>
            
            <tr>
                <td class="table-wobordertb"></td>
                <td class="table-wobordertb">Jumlah</td>
                <td class="table-wobordertb" align="right">Rp. {{  number_format($total_biaya_riil,0,",",".")  }}</td>
            </tr>
            
            <tr>
                <td></td>
                <td colspan="3">
                    Terbilang : {{  $model_rincian->terbilang($total_biaya_riil) }} rupiah
                </td>
            </tr>
        </table>
    
        <div>2. Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dimaksud dan apabila di kemudian hari terdapat kelebihan atas pembayaran, kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara<br/><br/></div>
        <div>&nbsp; Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya<br/><br/></div>

        <table width="100%">
            <tr>
                <td width="50%" valign="top">
                    Mengetahui/Menyetujui:<br/>
                    Setuju dibayar:<br/>
                    Pejabat Pembuat Komitmen<br/>
                    <br/><br/><br/><br/><br/>
                    <u>{{ $model_rincian->ppk_nama }}</u><br/>
                    NIP. {{ $model_rincian->ppk_nip }} <br/>
                </td>
                <td width="10%"></td>
                <td width="30%" align="center" valign="top">
                    {{ $unit_kerja->ibu_kota }}<br/>
                    Pelaksana SPD<br/>
                    <br/><br/><br/><br/><br/><br/>
                    <u>{{ $model_rincian->nama }}</u><br/>
                    NIP. {{ $model_rincian->nip }} <br/>
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    @endif
</body>
</html>