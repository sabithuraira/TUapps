<div id="load" class="table-responsive">
    <table class="table-sm m-b-0 table-bordered" style="min-width:100%">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>Tahun</th>
                <th>Kode</th>
                <th>Label</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['tahun']}}</td>
                    <td>{{ $data['kode_program'] }}.{{ $data['kode_aktivitas'] }}.{{ $data['kode_kro'] }}.{{ $data['kode_ro'] }}.{{ $data['kode_komponen'] }}.{{ $data['kode_subkomponen'] }}.</td>
                    <td>{{ $data['label_aktivitas'] }} - {{ $data['label_kro'] }}</td>
                    <td>
                        <a href="{{action('MataAnggaranController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a>
                        <form action="{{action('MataAnggaranController@destroy', $data['id'])}}" method="post">
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