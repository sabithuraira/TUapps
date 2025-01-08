<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>{{ $datas[0]->attributes()['nama_barang'] }}</th>
                <th>{{ $datas[0]->attributes()['kode_barang'] }}</th>
                <th>{{ $datas[0]->attributes()['satuan'] }}</th>
                <th>{{ $datas[0]->attributes()['harga_satuan'] }}</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['nama_barang']}}</td>
                    <td>{{$data['kode_barang']}}</td>
                    <td>{{$data['satuan']}}</td>
                    <td>Rp. {{ number_format($data['harga_satuan'],0,",",".") }}</td>
                    
                    <td class="text-center"><a href="{{action('MasterBarangController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('MasterBarangController@destroy', $data['id'])}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit"><i class="icon-trash text-danger"></i></button>
                    </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>