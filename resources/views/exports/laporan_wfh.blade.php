<table>
    <thead>
        <tr>
            <th colspan="7" style="text-align:center;font-weight:bold">LAPORAN PELAKSANAN TUGAS HARIAN SELAMA PERIODE WORK FROM HOME</th>
        </tr>
        
        <tr>@for ($j = 0; $j < 7; $j++)<th></th>@endfor</tr>
        
        <tr><th colspan="7">NAMA : {{ $user->name }}</th></tr>
        <tr><th colspan="7">UNIT KERJA : {{ $user->nmorg }} {{ $user->nmwil }}</th></tr>
        <tr><th colspan="7">TANGGAL : {{ date('d M Y', strtotime($tanggal)) }}</th></tr>
        
        <tr>
            <th rowspan="2" style="font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">NO</th>
            <th rowspan="2" style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">DESKRIPSI PEKERJAAN/PENUGASAN</th>
            <th colspan="2" style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">KUANTITAS</th>
            <th rowspan="2" style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">DURASI WAKTU PENGERJAAN</th>
            <th rowspan="2" style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">PEMBERI TUGAS</th>
            <th rowspan="2" style="font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">STATUS PENYELESAIAN</th>
        </tr>
        
        <tr>
            <th style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">VOLUME</th>
            <th style="text-align:center;font-weight:bold;border:1px solid #000000;background-color:#A9A9A9">SATUAN</th>
        </tr>
        
        <tr>
            <th style="text-align:center;border:1px solid #000000">[1]</th>
            <th style="text-align:center;border:1px solid #000000">[2]</th>
            <th style="text-align:center;border:1px solid #000000">[3]</th>
            <th style="text-align:center;border:1px solid #000000">[4]</th>
            <th style="text-align:center;border:1px solid #000000">[5]</th>
            <th style="text-align:center;border:1px solid #000000">[6]</th>
            <th style="text-align:center;border:1px solid #000000">[7]</th>
        </tr>
    </thead>

    <tbody>
        @foreach($datas as $key=>$data)
            @php
                $mulai_time = strtotime("2020-10-10 ".$data['waktu_mulai'].":00");
                $selesai_time = strtotime("2020-10-10 ".$data['waktu_selesai'].":00");
                $selisih_time = round(abs($selesai_time - $mulai_time) / 60,2)." menit";
            @endphp
            <tr>
                <td style="text-align:center;border:1px solid #000000">{{ $key+1 }}</td>
                <td style="border:1px solid #000000">{{ $data['isi'] }}</td>
                <td style="text-align:center;border:1px solid #000000">{{ $data['volume'] }}</td>
                <td style="border:1px solid #000000">{{ $data['satuan'] }}</td>
                <td style="text-align:center;border:1px solid #000000">{{ $selisih_time }}</td>
                <td style="text-align:center;border:1px solid #000000">{{ $data['pemberi_tugas'] }}</td>
                <td style="text-align:center;border:1px solid #000000">{{ $data['status_penyelesaian'] }} %</td>
            </tr>
        @endforeach

        <tr><td colspan="7" style="font-size:9px">Jumlah Baris Disesuaikan dengan kebutuhan</td></tr>
        <tr><td colspan="7" style="font-size:9px">Kolom (3) dan (4) : Dokumen/Berkas/Responden/Tabel dll.</td></tr>
        <tr><td colspan="7" style="font-size:9px">Kolom (5) : Jam/Hari</td></tr>
        <tr><td colspan="7" style="font-size:9px">Kolom (7) : Diisi oleh Atasan Langsung dalam bentuk % thd target harian</td></tr>
        
        @for ($i = 0; $i < 2; $i++)
            <tr>
                @for ($j = 0; $j < 7; $j++)
                    <th></th>
                @endfor
            </tr>
        @endfor

        <tr>
            <td colspan="4" style="text-align:center">Atasan Langsung (sebut jabatannya)</td>
            <td colspan="3" style="text-align:center">Lokasi Tugas, tanggal tanda tangan</td>
        </tr>

        @for ($i = 0; $i < 2; $i++)
            <tr>
                @for ($j = 0; $j < 7; $j++)
                    <th></th>
                @endfor
            </tr>
        @endfor
        
        <tr>
            <td colspan="4" style="text-align:center">{{ $user->pimpinan->name }}</td>
            <td colspan="3" style="text-align:center">{{ $user->name }}</td>
        </tr>
        
        <tr>
            <td colspan="4" style="text-align:center">NIP. {{ $user->pimpinan->nip_baru }}</td>
            <td colspan="3" style="text-align:center">NIP. {{ $user->nip_baru }}</td>
        </tr>
    </tbody>
</table>