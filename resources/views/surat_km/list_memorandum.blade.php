<div class="tab-pane" id="memorandum">
    <div id="load" class="table-responsive">
        <table class="table table-sm table-bordered  m-b-0">
            @if (count($memorandum)==0)
                <thead>
                    <tr><th>Tidak ditemukan data</th></tr>
                </thead>
            @else
                <thead>
                    <tr>
                        <th>{{ $memorandum[0]->attributes()['nomor_urut'] }}</th>
                        <th>Isi</th>
                        <th class="text-center" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($memorandum as $data)
                    <tr>
                        <td>{{$data['nomor_urut']}}</td>
                        <td>
                            <p class="badge badge-info">{{ date('d F Y', strtotime($data['tanggal'])) }}</p>
                            <h6 class="margin-0" style="wrap-text: true">Perihal: {{$data['perihal']}}</h6>
                            @if(array_key_exists($data['nomor_petunjuk'], $data->listPetunjuk))
                                <p class="text-muted">{{ $data->listPetunjuk[$data['nomor_petunjuk']] }} - {{ $data['nomor_petunjuk'] }}</p>
                            @endif
                            <span>Alamat: {{$data['alamat']}}</span>

                        </td>
                        
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
        {{ $memorandum->links() }} 
    </div>
</div>