<table>
    @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
    @else
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Pegawai</th>
                <th>Jabatan Pegawai</th>
                <th>Tujuan</th>
                <th>Nomor Surat Tugas</th>
                <th>Nomor SPD</th>
                <th>Status Tim (Jika Tim)</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Pejabat Penandatangan</th>
                <th>Tingkat Biaya</th>
                <th>Kendaraan</th>
                <th>Status</th>
            </tr>
           
        </thead>
        <tbody>
            @foreach($datas as $key=>$data)
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>
                        @if(strlen($data->nip)>0)
                            {{ $data->nip }} - {{ $data->nama }}
                        @else
                            {{ $data->nama }}
                        @endif
                    </td>
                    <td>{{ $data->jabatan }}</td>
                    <td>{{ $data->tujuan_tugas }}</td>
                    <td>{{ $data->nomor_st }}</td>
                    <td>{{ $data->nomor_spd }}</td>
                    <td>
                        @if(strlen($data->kategori_petugas)>0)
                            {{ $data->listKategoriPetugas[$data->kategori_petugas] }}
                        @endif
                    </td>
                    <td>{{ date('d F Y', strtotime($data->tanggal_mulai)) }}</td>
                    <td>{{ date('d F Y', strtotime($data->tanggal_selesai)) }}</td>
                    <td>{{ $data->pejabat_ttd_nip }} - {{ $data->pejabat_ttd_nama }}</td>
                    <td>
                        @if(strlen($data->tingkat_biaya)>0)
                            {{ $data->listTingkatBiaya[$data->tingkat_biaya] }}
                        @endif
                    </td>
                    <td>
                        @if(strlen($data->kendaraan)>0)
                            {{ $data->listKendaraan[$data->kendaraan] }}
                        @endif
                    </td>
                    <td>
                        @if(strlen($data->status_aktif)>0)
                            {{ $data->listLabelStatus[$data->status_aktif] }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endif
</table>