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

        <br/><br/><br/><br/>
        
        <p align="center"><b><u>SURAT KETERANGAN / PERNYATAAN</u></b></p>
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
                </td>
                <td width="40%" align="center">
                    {{ $model->ditetapkan_di }}, {{ date('d', strtotime($model->ditetapkan_tanggal)) }} {{ config('app.months')[date('n', strtotime($model->ditetapkan_tanggal))] }} {{ date('Y', strtotime($model->ditetapkan_tanggal)) }} <br/>
                    {{ $model->ditetapkan_oleh }}
                    <br/><br/><br/><br/><br/><br/>
                    {{ $model->ditetapkan_nama }}<br/>
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </body>
</html>