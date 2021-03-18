<div id="load" class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%;">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th class="text-center">{{ $datas[0]->attributes()['nama_barang'] }}</th>
                <th class="text-center">{{ $datas[0]->attributes()['serial_number'] }}</th>
                <th class="text-center">Pemegang</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['nama_barang']}}</td>
                    <td>{{$data['serial_number']}}</td>
                    <td>{{ $data['nama'] }} - {{ $data['nip_baru'] }}</td>
                    <td class="text-center"><a href="{{action('PemegangBmnController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('PemegangBmnController@destroy', $data['id'])}}" method="post">
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