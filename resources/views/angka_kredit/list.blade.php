<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>{{ $datas[0]->attributes()['uraian'] }}</th>
                <th>{{ $datas[0]->attributes()['kode'] }}</th>
                <th>{{ $datas[0]->attributes()['butir_kegiatan'] }}</th>
                <th>{{ $datas[0]->attributes()['satuan_hasil'] }}</th>
                <th>{{ $datas[0]->attributes()['angka_kredit'] }}</th>
                <th>{{ $datas[0]->attributes()['batas_penilaian'] }}</th>
                <th>{{ $datas[0]->attributes()['pelaksana'] }}</th>
                <th>{{ $datas[0]->attributes()['bukti_fisik'] }}</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['Jenis']['uraian']}}</td>
                    <td>{{$data['kode']}}</td>
                    <td>{{$data['butir_kegiatan']}}</td>
                    <td>{{$data['satuan_hasil']}}</td>
                    <td>{{$data['angka_kredit']}}</td>
                    <td>{{$data['batas_penilaian']}}</td>
                    <td>{{$data['pelaksana']}}</td>
                    <td>{{$data['bukti_fisik']}}</td>
                    
                    <td class="text-center"><a href="{{action('AngkaKreditController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('AngkaKreditController@destroy', $data['id'])}}" method="post">
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