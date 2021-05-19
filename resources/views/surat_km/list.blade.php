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
                            @if($data['jenis_surat']>=1 && $data['jenis_surat']<=3)
                                <h6 class="m-b-0">{{ $data['perihal'] }}</h6>
                                <p class="m-b-0">Nomor: {{ $data['nomor'] }}</p>
                            @elseif($data['jenis_surat']==4)
                                <h6 class="m-b-0">Ditetapkan oleh: {{ $data['ditetapkan_oleh'] }}</h6>
                                <p class="m-b-0">Nomor: {{ $data['nomor'] }}</p>
                            @elseif($data['jenis_surat']==5)
                                <p class="m-b-0">{{ $data['nomor'] }}</p>
                            @elseif($data['jenis_surat']==6 || $data['jenis_surat']==7)
                                <h6 class="m-b-0">Ditetapkan Oleh: {{ $data['ditetapkan_oleh'] }}</h6>
                                <p class="m-b-0">Nomor: {{ $data['nomor'] }}</p>
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