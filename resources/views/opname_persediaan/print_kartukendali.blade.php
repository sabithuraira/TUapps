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

    <h3 align="center">KARTU PERSEDIAAN BARANG PAKAI HABIS (ATMARK)</h3>
        <br/><br/>
    
    <table width="100%">
        <tr><td width="15%">BULAN</td><td>: {{ $monthName }} {{ $year }}</td></tr>
        <tr><td>NAMA BARANG</td><td>: {{ $detail_barang->nama_barang }}</td></tr>
        <tr><td>SATUAN BARANG</td><td>: {{ $detail_barang->satuan }}</td></tr>
    </table>
    <br/><br/>
    <table width="100%" class="table-border">
        <thead>
            <tr align="center">
                <td rowspan="2">TGL</td>
                <td rowspan="2">URAIAN</td>
                <td colspan="3">MASUK (DEBET)</td>
                <td colspan="3">KELUAR (DEBET)</td>
                <td colspan="3">SALDO</td>
            </tr>

            <tr align="center">
                <td>JUMLAH BARANG</td>
                <td>HARGA SATUAN (Rp.)</td>
                <td>JUMLAH (Rp.)</td>
                <td>JUMLAH BARANG</td>
                <td>HARGA SATUAN (Rp.)</td>
                <td>JUMLAH (Rp.)</td>
                <td>JUMLAH BARANG</td>
                <td>JUMLAH (Rp.)</td>
                <td>HARGA SATUAN (Rp.)</td>
            </tr>
            
            <tr align="center">
                <td>A</td>
                <td>B</td>
                <td>C</td>
                <td>D</td>
                <td>E = (CxD)</td>
                <td>F</td>
                <td>G</td>
                <td>H = (FxG)</td>
                <td>I = (SA+C-F)</td>
                <td>J = (SA+E-H)</td>
                <td>K = (J/I)</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td colspan="2">SALDO AWAL</td>
                <td></td><td></td><td></td><td></td><td></td><td></td>
                <td align="right">{{ $persediaan->saldo_awal }}</td>
                <td align="right">{{ number_format($persediaan->harga_awal,0,",",".") }}</td>
                <td align="right">{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
            </tr>

            @foreach ($datas as $key=>$data)
                <tr align="right">
                    <td align="center">{{ date('d-M', strtotime($data->tanggal)) }}</td>
                    <td align="left">{{ $data->label }}</td>

                    @if ($data->jenis==2)
                        <td></td><td></td><td></td>
                        <td>{{ $data->jumlah }}</td>
                        <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
                        <td>{{ number_format($data->harga,0,",",".") }}</td>
                    @endif
                    
                    @if ($data->jenis==1)
                        <td>{{ $data->jumlah }}</td>
                        <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
                        <td>{{ number_format($data->harga,0,",",".") }}</td>
                        <td></td><td></td><td></td>
                    @endif
                    
                    <td>{{ $data->saldo_jumlah }}</td>
                    <td>{{ number_format($data->saldo_harga,0,",",".") }}</td>
                    <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
                </tr>
            @endforeach
            
            <tr align="right">
                <td align="center" colspan="2">JUMLAH</td>
                <td>{{ $persediaan->saldo_tambah }}</td>
                <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
                <td>{{ number_format($persediaan->harga_tambah,0,",",".") }}</td>

                <td>{{ $persediaan->saldo_keluar }}</td>
                <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
                <td>{{ number_format($persediaan->harga_kurang,0,",",".") }}</td>
                
                <td>{{ $persediaan->saldo_tambah+$persediaan->saldo_awal-$persediaan->saldo_kurang }}</td>
                <td>{{ number_format(((float)$persediaan->harga_tambah+(float)$persediaan->harga_awal-(float)$persediaan->harga_kurang),0,",",".") }}</td>
                <td>{{ number_format($detail_barang->harga_satuan,0,",",".") }}</td>
            </tr>
        </tbody>
    </table>
    </body>
</html>