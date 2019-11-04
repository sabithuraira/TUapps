<div id="load">
    <table class="table table-bordered">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th colspan="2">Saldo {{ config('app.months')[$month-1] }}</th>
                    <th colspan="2">Tambah {{ config('app.months')[$month] }}</th>
                    <th colspan="2">Kurang {{ config('app.months')[$month] }}</th>
                    <th colspan="2">Saldo {{ config('app.months')[$month] }}</th>
                    <th>Harga Satuan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $label_op_awal = "op_awal_".$month;
                    $label_op_tambah = "op_tambah_".$month;
                @endphp
                
                @foreach($datas as $key=>$data)
                <tr>
                    <td>{{ $key+1 }}. </td>
                    <td>{{ $data->nama_barang }}</td>
                    
                    <td>
                        {{ 
                            $data->$label_op_awal
                        }}
                    </td>
                    <td>{{ $data->satuan }}</td>
                    
                    <td>{{ $data->$label_op_tambah }}</td>
                    <td>{{ $data->satuan }}</td>
                    
                    <td></td>
                    <td>{{ $data->satuan }}</td>
                    
                    <td></td>
                    <td>{{ $data->satuan }}</td>

                    <td>{{ $data->harga_satuan }}</td>
                </tr>
                @endforeach
            </tbody>
        @endif
    </table>
</div>