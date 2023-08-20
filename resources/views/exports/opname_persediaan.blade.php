<table>
    <thead>
        <tr>
            <th colspan="10">BA Opname Phisik Persediaan per {{ $last_day_month }} {{ $monthName }} {{ $year }}</th>
        </tr>
        <tr> 
            <th>No</th>
            <th>Nama Barang</th>
            <th colspan="2">Saldo {{ $last_day_prev_month }} {{ $prevMonthName }}</th>
            <th colspan="2">Tambah {{ $monthName }}</th>
            <th colspan="2">Kurang {{ $monthName }}</th>
            <th colspan="2">Saldo {{ $last_day_month }} {{ $monthName }}</th>
            <th>Harga Satuan (Rp)</th>
        </tr>
        <tr>
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
                    <td>{{ $no_urut }}</td>
                    <td>{{ $data->nama_barang }}</td>
                    <td>{{ $data->op_awal }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td>{{ $data->op_tambah }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td>{{ $data->op_kurang }}</td>
                    <td>{{ $data->satuan }}</td>
                    
                    <td>{{ ((int)$data->op_awal+(int)$data->op_tambah-(int)$data->op_kurang) }}</td>
                    <td>{{ $data->satuan }}</td>
                    <td>{{  number_format($data->harga_satuan,0,",",".") }}</td>
                </tr>
                @php
                    ++$no_urut;
                @endphp
            @endif
        @endforeach
    </tbody>
  </table>