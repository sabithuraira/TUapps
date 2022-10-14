<div id="load" class="table-responsive">
    <table class="table table-bordered m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th>Provinsi</th>
                    <th>Kab/Kota</th>
                    <th>Kec</th>
                    <th>Desa/Kelurahan</th>
                    <th>SLS/Non SLS</th>
                    <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data['kode_prov'] }}</td>
                    <td>{{ $data['kode_kab'] }}</td>
                    <td>{{ $data['kode_kec'] }}</td>
                    <td>{{ $data['kode_desa'] }}</td>
                    <td>{{ $data['id_sls'].$data['id_sub_sls'] }} - {{ $data['nama_sls'] }}</td>
                    
                    <td class="text-center"><a href="{{action('RegsosekController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                        <form action="{{action('RegsosekController@destroy', $data['id'])}}" method="post">
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
    <br/>
    {{ $datas->links() }} 
</div>