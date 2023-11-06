<div id="load" class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%;">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th class="text-center">{{ $datas[0]->attributes()['mak'] }}</th>
                <th class="text-center">{{ $datas[0]->attributes()['akun'] }}</th>
                <th class="text-center">{{ $datas[0]->attributes()['tahun'] }}</th>
                <th class="text-center">Bukti Administrasi</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>
                        {{ $data['kode_mak'] }}<br/>
                        <span class="text-muted">{{ $data['mak'] }}</span>
                    </td>
                    <td>
                        {{ $data['kode_akun'] }}<br/>
                        <span class="text-muted">{{ $data['akun'] }}</span>
                    </td>
                    <td class="text-center">{{$data['tahun']}}</td>
                    <td class="text-center">
                        <a href="{{action('SiraController@show', $data['id'])}}"><i class="fa fa-search text-info"></i></a>
                    </td>
                    <td class="text-center"><a href="{{action('SiraController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                        <form action="{{action('SiraController@destroy', $data['id'])}}" method="post">
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