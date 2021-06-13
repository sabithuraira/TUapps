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

        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td colspan="2" align="right">
                    {{ $model_rincian->dibuat_di }}, 
                    {{ date('d', strtotime($model->tanggal)) }} {{ config('app.months')[date('n', strtotime($model->tanggal))] }} {{ date('Y', strtotime($model->tanggal)) }}
                </td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Nomor</td><td>: {{ $model->nomor }}</td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="7%"></td>
                <td width="15%">Sifat</td><td>: 
                    @if($model->tingkat_keamanan=='B')
                        Biasa
                    @elseif($model->tingkat_keamanan=='R')
                        Rahasia
                    @endif
                </td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td width="7%"></td>
                <td width="15%">Lampiran</td><td>: {{ $model_rincian->lampiran }}</td>
                <td width="10%"></td>
            </tr>
            <tr style="vertical-align: text-top;">
                <td width="7%"></td>
                <td width="15%">Perihal</td><td>: {{ $model->perihal }}</td>
                <td width="10%"></td>
            </tr>
        </table>

        <br/><br/><br/>

        
        <table width="100%">
            <tr>
                <td width="7%"></td>
                <td>
                
                    Kepada Yth:<br/>
                    {{ $model_rincian->kepada }}<br/>
                    di<br/>
                    &nbsp;&nbsp; {{ $model_rincian->kepada_di }}<br/>

                    <br/><br/><br/>

                    {!! $model_rincian->isi !!}
                </td>
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
    </body>
</html>