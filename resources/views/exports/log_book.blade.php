<table>
    @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
    @else
        <thead>
            <tr>
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
    @endif
</table>