<div id="load" class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%;">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th class="text-center">{{ $datas[0]->attributes()['versi'] }}</th>
                <th class="text-center">{{ $datas[0]->attributes()['keterangan'] }}</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td class="text-center">{{$data['versi']}}</td>
                    <td>{{$data['keterangan']}}</td>
                    <td class="text-center"><a href="{{action('PokVersiController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('PokVersiController@destroy', $data['id'])}}" method="post">
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