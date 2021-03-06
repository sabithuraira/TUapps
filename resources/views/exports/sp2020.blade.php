<table>
    @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
    @else
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Wilayah</th>
                <th>Jumlah Penduduk DP</th>
                <th>Jumlah Penduduk Kondisi Lapangan</th>
                <th>Progres Selesai</th> 
            </tr>
        </thead>
        <tbody>
            @php
                $total_penduduk_dp = 0;
                $total_target_penduduk = 0;
                $total_realisasi_penduduk = 0;
            @endphp
            @foreach($datas as $key=>$data)
                @php
                    $total_penduduk_dp += $data->penduduk_dp; 
                    $total_target_penduduk += $data->target_penduduk; 
                    $total_realisasi_penduduk +=$data->realisasi_penduduk;
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>
                        {{ $data->idw }} - {{ $data->nama }}
                    </td>
                    <td>{{ number_format($data->penduduk_dp,0,",",".") }}</td>
                    <td>{{ number_format($data->target_penduduk,0,",",".") }}</td>
                    <td>
                        {{ number_format($data->realisasi_penduduk,0,",",".") }}

                        @if($data->target_penduduk == 0)
                            (0 %)
                        @else
                            ({{ round(($data->realisasi_penduduk/$data->target_penduduk*100),3) }} %)
                        @endif
                    </td>
                </tr>
            @endforeach
            
            <tr>
                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                <td>{{ number_format($total_penduduk_dp,0,",",".") }}</td>
                <td>{{ number_format($total_target_penduduk,0,",",".") }}</td>
                <td>
                    {{ number_format($total_realisasi_penduduk,0,",",".") }}
                    
                    @if($total_target_penduduk == 0)
                        (0 %)
                    @else
                        ({{ round(($total_realisasi_penduduk/$total_target_penduduk*100),3) }} %)
                    @endif
                </td>
            </tr>
        </tbody>
    @endif
</table>