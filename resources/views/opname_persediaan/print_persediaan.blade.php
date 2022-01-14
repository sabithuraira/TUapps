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
        padding-left: 8px;
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

  <h4 align="center">BA Opname Phisik Persediaan per {{ $last_day_month }} {{ $monthName }} {{ $year }}</h4>

  <table width="100%" class="table-border">
    <thead>
        <tr align="center">
                
            <th>No</th>
            <th width="15%">Nama Barang</th>
            <th colspan="2">Saldo {{ $last_day_prev_month }} {{ $prevMonthName }}</th>
            <th colspan="2">Tambah {{ $monthName }}</th>
            <th colspan="2">Kurang {{ $monthName }}</th>
            <th colspan="2">Saldo {{ $last_day_month }} {{ $monthName }}</th>
            <th>Harga Satuan (Rp)</th>
        </tr>

        <tr align="center">
            @for ($i = 1; $i < 12; $i++)
                <th>({{ $i }})</th>
            @endfor
        </tr>
    </thead>

    <tbody>
        @php
            $no_urut = 1;
        @endphp
        @foreach($datas as $key=>$data)
            @if($data->op_awal!=0 || $data->op_tambah!=0 || $data->op_kurang!=0)
                <tr>
                    <td align="center">{{ $no_urut }}</td>
                    <td>{{ $data->nama_barang }}</td>
                    <td>{{ $data->op_awal }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td>{{ $data->op_tambah }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td>{{ $data->op_kurang }}</td>
                    <td>{{ $data->satuan }}</td>
                    
                    <td>{{ ((int)$data->op_awal+(int)$data->op_tambah-(int)$data->op_kurang) }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td align="right">{{  number_format($data->harga_satuan,0,",",".") }}</td>
                </tr>
                @php
                    ++$no_urut;
                @endphp
            @endif
        @endforeach
    </tbody>
  </table>
</body>
</html>