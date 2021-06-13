<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <style type="text/css">
            * {
                font-family: Segoe UI, Arial, sans-serif;
                font-size: small
            }

            tr,
            td {
                padding-left: 8px;
            }

            .pepet {
                white-space: nowrap;
                width: 1%;
            }

            .table-border {
                border: 1px solid black;
            }

            .table-border td,
            th {
                border: 1px solid black;
            }

            tfoot tr td {
                font-weight: bold;
                font-size: x-small;
            }

            .gray {
                background-color: lightgray
            }

            header {
                position: fixed;
                top: -40px;
                left: 0px;
                right: 0px;
            }

            footer {
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                text-align: center;
                line-height: 35px;
            }
        </style>
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

        <br /><br /><br /><br /><br />

        <p align="center"><b><u>SURAT TUGAS</u></b></p>
        <p align="center">NOMOR : {{ $model_rincian->nomor_st }}</p>

        <br /><br />

        <table width="100%">
            <tr><td colspan="2" align="right">{{ $model_rincian->dibuat_di }}</td></tr>
            <tr><td width="15%">Nomor</td><td>: {{ $model->nomor }}</td></tr>
            <tr><td width="15%">Lampiran</td><td>: {{ $model_rincian->lampiran }}</td></tr>
            <tr><td width="15%">Perihal</td><td>: {{ $model->perihal }}</td></tr>
        </table>

        <br/><br/><br/>

        <p>Kepada Yth:</p>
        <p>{{ $model_rincian->kepada }}</p>
        <p>di</p>
        <p>&nbsp;&nbsp; {{ $model_rincian->kepada_di }}</p>

        <br/><br/><br/>

        {!! $model_rincian->isi !!}
        
        <br/><br/><br/>

        <table width="100%">
            <tr>
                <td width="50%"></td>
                <td width="40%" align="center">
                    {{ $model->ditetapkan_oleh }}
                    <br/><br/><br/><br/><br/>
                    {{ $model->ditetapkan_nam }}
                </td>
                <td width="10%"></td>
            </tr>
        </table>
    </body>
</html>