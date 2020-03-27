<div id="load">
    <br/><br/>
    <div class="table-responsive">
        <table class="table table-sm table-bordered m-b-0">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Kegiatan</th>
                    <th>Hasil</th>
                </tr>
            </thead>

            <tbody>
                @foreach($datas as $key=>$data)
                <tr>
                    <td>{{ $key+1 }} </td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->nip_baru }}</td>
                    <td>{!! $data->isi !!}</td>
                    <td>{!! $data->hasil !!}</td>
                    
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>