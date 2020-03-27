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
                @php
                    $list_isi = explode('bps1600bps', $data->isi);
                    $total_isi = count($list_isi);
                    $list_hasil = explode('bps1600bps', $data->hasil);
                @endphp
                <tr>
                    <td rowspan="{{ $total_isi }}">{{ $key+1 }} </td>
                    <td rowspan="{{ $total_isi }}">{{ $data->name }}</td>
                    <td rowspan="{{ $total_isi }}">{{ $data->nip_baru }}</td>
                    <td>{{ $list_isi[0] }}</td>
                    <td>{{ $list_hasil[0] }}</td>
                </tr>
                @for($i = 1; $i< $total_isi; $i++)
                    <tr>
                        <td>{{ $list_isi[$i] }}</td>
                        <td>
                            @if(count($list_hasil)<$i)
                                {{ $list_hasil[$i] }}
                            @endif
                        </td>
                    </tr>
                @endfor
            @endforeach
        </tbody>
    @endif
</table>