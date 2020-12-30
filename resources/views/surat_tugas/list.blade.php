<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th rowspan="2">{{ $datas[0]->attributes()['nomor_st'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['nip'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['nama'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['tujuan_tugas'] }}</th>
                    <th colspan="2">Tanggal</th>
                    <th class="text-center"  rowspan="2" colspan="2">Action</th>
                </tr>
                
                <tr>
                    <th>Mulai</th>
                    <th>Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['nomor_st']}}</td>
                    <td>{{$data['nip']}}</td>
                    <td>{{$data['nama']}}</td>
                    <td>{{$data['tujuan_tugas']}}</td>
                    <td>{{$data['tanggal_mulai']}}</td>
                    <td>{{$data['tanggal_selesai']}}</td>
                    
                    <td class="text-center"><a href="{{action('SuratTugasController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('SuratTugasController@destroy', $data['id'])}}" method="post">
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