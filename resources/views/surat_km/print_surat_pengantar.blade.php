<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="{{ asset('css/print_pdf.css') }}" rel="stylesheet">
    </head>

    <body>
        <header>
            <table width="100%">
                <tr>
                    <td class="pepet">
                        <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:120px">
                    </td>
                    <td align="left">
                        <i><b>BADAN PUSAT STATISTIK</b></i><br />
                        <i><b>
                        {{ strtoupper($unit_kerja->nama) }}
                    </td>
                </tr>
            </table>
        </header>

        <br/><br/><br/><br/><br/>

        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td colspan="2">
                    {{ $model_rincian->dibuat_di }}, 
                    {{ date('d', strtotime($model->tanggal)) }} {{ config('app.months')[date('n', strtotime($model->tanggal))] }} {{ date('Y', strtotime($model->tanggal)) }}
                    <br/><br/><br/>
                    Kepada Yth,<br>
                    {{ $model_rincian->kepada }}<br>
                    di {{ $model_rincian->kepada_di }}
                </td>
                <td width="10%"></td>
            </tr>
        </table>
        
        <p align="center"><b><u>SURAT PENGANTAR</u></b></p>
        <p align="center">NOMOR : {{ $model->nomor }}</p>
        
        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td>{!! $model_rincian->isi !!}</td>
                <td width="10%"></td>
            </tr>
        </table>

        <br/><br/>

        <table width="100%">
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="43%">
                    Diterima tanggal: 
                    @if(strlen($model_rincian->diterima_tanggal)>0)
                        {{ date('d', strtotime($model_rincian->diterima_tanggal)) }} {{ config('app.months')[date('n', strtotime($model_rincian->diterima_tanggal))] }} {{ date('Y', strtotime($model_rincian->diterima_tanggal)) }}
                    @endif
                    <br/>
                    Jabatan: {{ $model_rincian->diterima_jabatan }}
                    <br/><br/><br/><br/><br/>
                    {{ $model_rincian->diterima_nama }}<br/>
                    NIP. {{ $model_rincian->diterima_nip }}<br/><br/>
                    No HP. {{ $model_rincian->diterima_no_hp }}
                </td>
                <td width="40%" align="center">
                    {{ $model->ditetapkan_oleh }}
                    <br/><br/><br/><br/><br/><br/>
                    {{ $model->ditetapkan_nama }}<br/>
                    NIP. {{ $model->ditetapkan_nip }}
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </body>
</html>