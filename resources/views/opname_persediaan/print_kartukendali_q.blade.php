<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }
    table{
        font-size: x-small;
        border-collapse: collapse;
    }

    tr, td{
        padding-left: 4px;
    }

    .table-border{
        border: 1px solid black;
    }
    
    .table-border td, th{
        border: 1px solid black;

    }

    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }

    .gray {
        background-color: lightgray
    }
</style>

</head>
    <body>

        <table width="100%">
            <tr>
                <td width="10%">
                    <img src="{!! asset('lucid/assets/images/bps-sumsel.png') !!}" style="width:120px">
                </td>
                <td>
                    <i><h2>
                    BADAN PUSAT STATISTIK<br/>
                    {{ strtoupper($unit_kerja->nama) }}
                    </h2></i>
                </td>
            </tr>
        </table>

    <h3 align="center">KARTU PERSEDIAAN BARANG HABIS PAKAI</h3>
        <br/><br/>
    
    <table width="100%">
        <tr><td width="25%">BULAN</td><td>: {{ $monthName }} {{ $year }}</td></tr>
        <tr><td>KODE BARANG</td><td>: {{ $detail_barang->kode_barang }}</td></tr>
        <tr><td>NAMA BARANG</td><td>: {{ $detail_barang->nama_barang }}</td></tr>
        <tr><td>SATUAN BARANG</td><td>: {{ $detail_barang->satuan }}</td></tr>
    </table>
    <br/><br/>
    <table width="100%" class="table-border">
        <thead>
            <tr align="center">
                <td>TGL</td>
                <td width="50%">URAIAN</td>
                <td>JUMLAH BARANG MASUK (DEBET)</td>
                <td>JUMLAH BARANG KELUAR (KREDIT)</td>
                <td>JUMLAH BARANG SALDO</td>
            </tr>
            
            <tr align="center">
                <td>A</td>
                <td>B</td>
                <td>C</td>
                <td>D</td>
                <td>E</td>
            </tr>
        </thead>

        <tbody>
            @if (isset($persediaan->saldo_awal))
                <tr>
                    <td colspan="2">SALDO AWAL</td>
                    <td></td><td></td>
                    <td align="right">{{ $persediaan->saldo_awal }}</td>
                </tr>

                @foreach ($datas as $key=>$data)
                    <tr align="right">
                        <td align="center">{{ date('d-M', strtotime($data->tanggal)) }}</td>
                        <td align="left">
                            @if($data->label==null)
                                BARANG USANG
                            @else 
                                {{ $data->label }}
                            @endif  
                        </td>
                        @if ($data->jenis==2)
                            <td></td>
                            <td>{{ $data->jumlah }}</td>
                        @endif
                        
                        @if ($data->jenis==1)
                            <td>{{ $data->jumlah }}</td>
                            <td></td>
                        @endif
                        
                        <td>{{ $data->saldo_jumlah }}</td>
                    </tr>
                @endforeach
                
                <tr align="right">
                    <td align="center" colspan="2">JUMLAH</td>
                    <td>{{ $persediaan->saldo_tambah }}</td>
                    <td>{{ $persediaan->saldo_kurang }}</td>
                    <td>{{ $persediaan->saldo_tambah+$persediaan->saldo_awal-$persediaan->saldo_kurang }}</td>
                </tr>
            @endif
        </tbody>
    </table>

        <br/>
    
        <table width="100%">
            <tr>
                <td width="15%"></td>
                <td width="25%" align="center"></td>
                <td width="20%"></td>
                <td width="25%" align="center">
                    <p>Dibuat Oleh</p>
                    <br/>
                    <br/>
                    {{ $unit_kerja->persediaan_nama }}<br/>
                    NIP.   {{ $unit_kerja->persediaan_nip }} <br/>
                </td>
                <td width="15%"></td>
            </tr>

        </table>
    </body>
</html>