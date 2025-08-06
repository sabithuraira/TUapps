<table>
    @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
    @else
        <thead>
            <tr>
                <th>No</th>
                <th>ID SLS</th>
                <th>Nama SLS</th>
                <th>Ketua SLS</th>
                <th>Laporan Jumlah KK</th>
                <th>Laporan Jumlah BTT</th>
                <th>Laporan Jumlah BTT Kosong</th>
                <th>Laporan Jumlah BKU</th>
                <th>Laporan Jumlah BBTTN Non</th>
                <th>Laporan Jumlah Perkiraan Muatan Usaha</th>
                <th>Status Selesai (1=selesai)</th> 
                <th>Status Berubah Batas (1=berubah batas)</th> 
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $key=>$data)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>{{ $data->kode_prov }}{{ $data->kode_kab }}{{ $data->kode_kec }}{{ $data->kode_desa }}{{ $data->kode_sls }}{{ $data->kode_subsls }}</td>
                    <td>{{ $data->nama_sls }}</td>
                    <td>{{ $data->ketua_sls }}</td>
                    <td>{{ number_format($data->laporan_jumlah_kk,0,",",".") }}</td>
                    <td>{{ number_format($data->laporan_jumlah_btt,0,",",".") }}</td>
                    <td>{{ number_format($data->laporan_jumlah_btt_kosong,0,",",".") }}</td>
                    <td>{{ number_format($data->laporan_jumlah_bku,0,",",".") }}</td>
                    <td>{{ number_format($data->laporan_jumlah_bbttn_non,0,",",".") }}</td>
                    <td>{{ number_format($data->laporan_perkiraan_jumlah,0,",",".") }}</td>
                    <td>{{ $data->status_selesai }}</td>
                    <td>{{ $data->status_perubahan_batas }}</td>
                </tr>
            @endforeach
        </tbody>
    @endif
</table>