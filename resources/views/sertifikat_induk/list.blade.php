<div>
    <div id="load" class="table-responsive">
        <table class="table-bordered m-b-0" style="min-width:100%">
            @if (count($list)==0)
                <thead>
                    <tr><th>Tidak ditemukan data</th></tr>
                </thead>
            @else
                <thead>
                    <tr class="text-center">
                        <th>Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Kode satker</th>
                        <th>Klasifikasi arsip</th>
                        <th>No. urut (awal–akhir)</th>
                        <th>Jumlah peserta</th>
                        <th colspan="3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $data)
                    <tr>
                        <td>{{ $data->kegiatan }}</td>
                        <td class="text-center">{{ $data->tanggal ? $data->tanggal->format('d F Y') : '' }}</td>
                        <td class="text-center">{{ $data->kode_satker }}</td>
                        <td class="text-center">{{ $data->klasifikasi_arsip }}</td>
                        <td class="text-center">
                            @if($data->nomor_urut_start !== null && $data->nomor_urut_end !== null)
                                {{ $data->nomor_urut_start }} – {{ $data->nomor_urut_end }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-center">{{ $data->peserta_count }}</td>
                        <td class="text-center"><a href="{{ action('SertifikatIndukController@show', \Crypt::encrypt($data->id)) }}" class="btn btn-sm"><i class="icon-eye text-info"></i></a></td>
                        <td class="text-center"><a href="{{ action('SertifikatIndukController@edit', \Crypt::encrypt($data->id)) }}" class="btn btn-sm"><i class="icon-pencil text-info"></i></a></td>
                        <td class="text-center">
                            <form action="{{ action('SertifikatIndukController@destroy', $data->id) }}" method="post">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <button type="submit" class="btn btn-sm" onclick="return confirm('Hapus data ini?');"><i class="icon-trash text-danger"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            @endif
        </table>
        {{ $list->links() }}
    </div>
</div>
