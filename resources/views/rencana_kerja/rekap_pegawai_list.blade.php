<div id="load">
    <div class="table-responsive">
        <table class="table-bordered  m-b-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama/NIP</th>
                    <th style="min-width:40%">Kegiatan</th>
                    <th style="min-width:35%">Hasil</th>
                </tr>
            </thead>

            <tbody>
                @foreach($datas as $key=>$data)
                    @if($data->kdesl==2)
                        @if(auth()->user()->kdesl==2)
                            <tr>
                                <td>{{ $key+1 }} </td>
                                <td>{{ $data->name }} / {{ $data->nip_baru }}</td>
                                <td>{!! $data->isi !!}</td>
                                <td>{!! $data->hasil !!}</td>
                            </tr>
                        @endif    
                    @else
                        <tr>
                            <td>{{ $key+1 }} </td>
                            <td>{{ $data->name }} / {{ $data->nip_baru }}</td>
                            <td>{!! $data->isi !!}</td>
                            <td>{!! $data->hasil !!}</td>
                        </tr>
                    @endif 
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>