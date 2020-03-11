<div class="tab-pane show active" id="surat_masuk">
    <div id="load" class="table-responsive">
        <table class="table table-sm table-bordered m-b-0">
            @if (count($surat_masuk)==0)
                <thead>
                    <tr><th>Tidak ditemukan data</th></tr>
                </thead>
            @else
                <thead>
                    <tr>
                        <th>{{ $surat_masuk[0]->attributes()['nomor_urut'] }}</th>
                        <th>{{ $surat_masuk[0]->attributes()['nomor_petunjuk'] }}</th>
                        <th>{{ $surat_masuk[0]->attributes()['alamat'] }}</th>
                        <th>{{ $surat_masuk[0]->attributes()['tanggal'] }}</th>
                        <th>{{ $surat_masuk[0]->attributes()['perihal'] }}</th>
                        <th class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surat_masuk as $data)
                    <tr>
                        <td>{{$data['nomor_urut']}}</td>
                        <td>
                            @if(array_key_exists($data['nomor_petunjuk'], $data->listPetunjuk))
                                {{ $data->listPetunjuk[$data['nomor_petunjuk']] }} - {{ $data['nomor_petunjuk'] }}
                            @endif
                        </td>
                        <td>{{$data['alamat']}}</td>
                        <td>{{$data['tanggal']}}</td>
                        <td>{{$data['perihal']}}</td>
                        
                        <td class="text-center"><a href="{{action('SuratKmController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                        <td class="text-center">
                        <form action="{{action('SuratKmController@destroy', $data['id'])}}" method="post">
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
        {{ $surat_masuk->links() }} 
    </div>
</div>