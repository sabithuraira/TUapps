<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link href="{{ asset('css/print_pdf.css') }}" rel="stylesheet">
    </head>

    <body>
        <table width="100%" class="table-border">
            <tr>
                <td colspan="3" align="center"><br/><h2>LEMBAR DISPOSISI</h2><br/></td>
            </tr>
            <tr>
                <td width="45%">
                    Nomor Agenda/Registrasi: {{ $model_rincian->nomor_agenda }}
                </td>
                <td colspan="2">
                    Tkt. Keamanan : 
                    @if($model->tingkat_keamanan=='B')
                        Biasa
                    @elseif($model->tingkat_keamanan=='R')
                        Rahasia
                    @endif
                </td>
            </tr>
            <tr>
                <td width="45%">
                    Tanggal Penerimaan: 
                    {{ date('d', strtotime($model_rincian->tanggal_penerimaan)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_penerimaan))] }} {{ date('Y', strtotime($model_rincian->tanggal_penerimaan)) }}
                </td>
                <td colspan="2">
                    Tgl. Penyelesaian :
                    {{ date('d', strtotime($model_rincian->tanggal_penyelesaian)) }} {{ config('app.months')[date('n', strtotime($model_rincian->tanggal_penyelesaian))] }} {{ date('Y', strtotime($model_rincian->tanggal_penyelesaian)) }}
                </td>
            </tr>
            
            <tr>
                <td width="45%" class="table-wobordertb">
                    Tanggal dan Nomor Surat<br/>
                    Dari<br/>
                    Ringkasan Isi<br/>
                    Lampiran<br/>
                </td>
                <td colspan="2" class="table-wobordertb">
                    : {{ date('d', strtotime($model->tanggal)) }} {{ config('app.months')[date('n', strtotime($model->tanggal))] }} {{ date('Y', strtotime($model->tanggal)) }} dan {{ $model->nomor }}<br/>
                    : {{ $model_rincian->dari }}<br/>
                    : {{ $model_rincian->isi }}<br/>
                    : {{ $model_rincian->lampiran }}<br/>
                </td>
            </tr>
            
            <tr>
                <td>Disposisi</td>
                <td>Diteruskan Kepada</td>
                <td>Paraf</td>
            </tr>
            
            <tr style="vertical-align: text-top;">
                <td>{!! $model_rincian->isi_disposisi !!}</td>
                <td>{!! $model_rincian->diteruskan_kepada !!}</td>
                <td><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/></td>
            </tr>
            
            
        </table>
    </body>
</html>