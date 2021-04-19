<div>
    <div id="load" class="table-responsive">
        <table class="table-bordered m-b-0" style="min-width:100%">
            @if (count($list_surat)==0)
                <thead>
                    <tr><th>Tidak ditemukan data</th></tr>
                </thead>
            @else
                <thead>
                    <tr class="text-center">
                        <th>Jenis Surat</th>
                        <th>{{ $list_surat[0]->attributes()['nomor_urut'] }} / Tgl</th>
                        <th>Keterangan</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list_surat as $data)
                    <tr>
                        <td class="text-center"><p class="badge badge-success">{{ $data->listJenis[$data->jenis_surat] }}</p></td>
                        <td class="text-center">
                            <h6 class="margin-0">{{ $data['nomor_urut'] }}</h6>
                            <p class="badge badge-info">{{ date('d F Y', strtotime($data['tanggal'])) }}</p>
                        </td>
                        <td>
                            <p class="m-b-0">Perihal: {{$data['perihal']}}</p>
                            @if(array_key_exists($data['nomor_petunjuk'], $data->listPetunjuk))
                                <p class="text-muted">{{ $data->listPetunjuk[$data['nomor_petunjuk']] }} - {{ $data['nomor_petunjuk'] }}</p>
                            @endif
                        </td>
                        
                        <td class="text-center"><a href="{{action('SuratKmController@show', $data['id'])}}" class="btn btn-sm btn-primary"><i class="icon-eye"></i></a></td>
                        <td class="text-center"><a href="{{action('SuratKmController@edit', $data['id'])}}" class="btn btn-sm btn-info"><i class="icon-pencil"></i></a></td>
                        <td class="text-center">
                        <form action="{{action('SuratKmController@destroy', $data['id'])}}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="icon-trash"></i></button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            @endif
        </table>
        {{ $list_surat->links() }} 
    </div>
</div>