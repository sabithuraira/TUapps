<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="{{ asset('css/print_pdf.css') }}" rel="stylesheet">
    </head>

    <body>
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

        <br/><br/><br/>
        
        <p align="center"><b><u>NOTA DINAS</u></b></p>
        <p align="center">NOMOR : {{ $model->nomor }}</p>

        <table width="100%">
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Yth</td>
                <td width="1%">:</td>
                <td>{{ $model_rincian->kepada }}</td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Dari</td>
                <td>:</td>
                <td>{{ $model_rincian->dari }}</td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Hal</td>
                <td>:</td>
                <td>{{ $model->perihal }}</td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Tanggal</td>
                <td>:</td>
                <td>{{ date('d', strtotime($model->tanggal)) }} {{ config('app.months')[date('n', strtotime($model->tanggal))] }} {{ date('Y', strtotime($model->tanggal)) }}</td>
                <td width="10%"></td>
            </tr>
        </table>
        <hr/>
        <br/><br/>
        
        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td>{!! $model_rincian->isi !!}</td>
                <td width="10%"></td>
            </tr>
        </table>

        <br/><br/><br/>

        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td width="40%" align="center">
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
                    Tembusan Kepada:<br/>
                    {!! $model_rincian->tembusan !!}
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </body>
</html>