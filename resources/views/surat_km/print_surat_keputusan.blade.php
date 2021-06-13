<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="{{ asset('css/print_pdf.css') }}" rel="stylesheet">
    </head>

    <body>
        <div align="center" ><img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:120px" /></div>
        <p align="center"><b>BADAN PUSAT STATISTIK {{ strtoupper($unit_kerja->nama) }}</b></p>
        <hr/>

        <div align="center">
            KEPUTUSAN<br/>
            KEPALA BPS {{ strtoupper($unit_kerja->nama) }}<br/>
            NOMOR: {{ $model->nomor }}<br/>
            TENTANG <br/>
            {!! $model_rincian->tentang !!}
        </div>

        

        <p align="center">KEPALA BADAN PUSAT STATISTIK {{ strtoupper($unit_kerja->nama) }}</>

        <table width="100%">
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%"><p>Menimbang</p></td>
                <td width="1%"><p>:</p></td>
                <td>{!! $model_rincian->menimbang !!}</td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%"><p>Mengingat</p></td>
                <td width="1%"><p>:</p></td>
                <td>{!! $model_rincian->mengingat !!}</td>
                <td width="10%"></td>
            </tr>
        </table>
        <br/><br/>
        
        <p align="center"><b>MEMUTUSKAN</b></p>

        <table width="100%">
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%"><p>Menetapkan</p></td>
                <td width="1%"><p>:</p></td>
                <td>{!! $model_rincian->menetapkan !!}</td>
                <td width="10%"></td>
            </tr>
            @php 
                $list_angka_keputusan= [
                    "KESATU", "KEDUA", "KETIGA", "KEEMPAT", "KELIMA", "KEENAM", "KETUJUH", "KEDELAPAN", 
                    "KESEMBILAN", "KESEPULUH", "KESEBELAS", "KEDUA BELAS", "KETIGA BELAS", "KEEMPAT BELAS",
                    "KELIMA BELAS", "KEENAM BELAS", "KETUJUH BELAS", "KEDELAPAN BELAS", "KESEMBILAN BELAS", "KEDUA PULUH"
                ];
            @endphp
            @foreach($list_keputusan as $key=>$value)
                <tr style="vertical-align: text-top;">
                    <td width="7%"></td>
                    <td width="15%">{{ $list_angka_keputusan[$key] }}</td>
                    <td width="1%">:</td>
                    <td>{!! $value->isi !!}</td>
                    <td width="10%"></td>
                </tr>
            @endforeach
        </table>
        
        <br/><br/><br/>

        <table width="100%">
            <tr>
                <td width="40%"></td>
                <td width="15%">Ditetapkan di</td>
                <td width="35%">: {{ $model->ditetapkan_di }}</td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="40%"></td>
                <td width="15%">Pada Tanggal</td>
                <td width="35%">: {{ date('d', strtotime($model->ditetapkan_tanggal)) }} {{ config('app.months')[date('n', strtotime($model->ditetapkan_tanggal))] }} {{ date('Y', strtotime($model->ditetapkan_tanggal)) }}</td>
                <td width="10%"></td>
            </tr>
            
            <tr>
                <td width="40%"></td>
                <td width="15%"><p>&nbsp;</p></td>
                <td width="35%"></td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="40%"></td>
                <td colspan="2" width="50%" align="center">
                    KEPALA BADAN PUSAT STATISTIK<br/>
                    {{ $model->ditetapkan_oleh }}
                    <br/><br/><br/><br/><br/>
                    {{ $model->ditetapkan_nama }}
                </td>
                <td width="10%"></td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td>
                    Tembusan:<br/>
                    {!! $model_rincian->tembusan !!}
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </body>
</html>