<div class="tab-pane" id="c2_table">
    <table class="table table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th rowspan="2">No</th>
                @if($label!='bs')
                    <th rowspan="2">Nama Wilayah</th>
                @else 
                    <th rowspan="2">NURTS - Nama KRT</th>
                @endif
                <th colspan="4">Jumlah ART</th>
                @if($label!='bs')
                <th rowspan="2">Progres Dilaporkan</th>
                @endif
            </tr>
            
            <tr class="text-center">
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Perempuan 10-54</th>
                <th>Mati</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_laki = 0;
                $total_perempuan = 0;
                $total_perempuan_1549 = 0;
                $total_mati = 0;
                $total_terlapor = 0;
                $total_total = 0;
            @endphp
            @foreach($datas_c2 as $key=>$data)
                @php
                    $total_laki += $data->jumlah_laki; 
                    $total_perempuan += $data->jumlah_perempuan;
                    $total_perempuan_1549 += $data->jumlah_perempuan_1549; 
                    $total_mati += $data->jumlah_mati;
                    $total_terlapor += $data->terlapor;
                    $total_total += ($data->total*16);
                @endphp
                <tr>
                    <td>{{ ($key+1) }}</td>
                    <td>
                        @if($label == 'prov')
                            <a href="{{ url('dashboard/index?kab='.$data->idw) }}">{{ $data->idw }} - {{ $data->nama }}</a>
                        @elseif ($label == 'kab')
                            <a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$data->idw) }}">{{ $data->idw }} - {{ $data->nama }}</a>
                        @elseif ($label == 'kec')
                            <a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$kec.'&desa='.$data->idw) }}">{{ $data->idw }} - {{ $data->nama }}</a>
                        @elseif($label=='desa')
                            <a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$kec.'&desa='.$desa.'&bs='.$data->idw) }}">{{ $data->idw }} - {{ $data->nama }}</a>
                        @else
                            {{ $data->idw }} - {{ $data->nama }} 
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($data->jumlah_laki,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_perempuan,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_perempuan_1549,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_mati,0,",",".") }}</td>
                    @if($label!='bs')
                    <td class="text-center">
                        @if($data->total==0)
                            (0 %)
                        @else 
                            ({{ round(($data->terlapor/($data->total*16)*100),3) }} %)
                        @endif
                    </td>
                    @endif
                </tr>
            @endforeach
            
            <tr class="text-center">
                <td colspan="2"><b>TOTAL</b></td> 
                <td>{{ number_format($total_laki,0,",",".") }}</td>
                <td>{{ number_format($total_perempuan,0,",",".") }}</td>
                <td>{{ number_format($total_perempuan_1549,0,",",".") }}</td>
                <td>{{ number_format($total_mati,0,",",".") }}</td>
                @if($label!='bs')
                    <td class="text-center">
                        @if($total_total==0)
                            (0 %)
                        @else
                            ({{ round(($total_terlapor/$total_total*100),3) }} %)
                        @endif
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
</div>