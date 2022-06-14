<div class="tab-pane show active" id="c2_table">
    <a href="#" onclick="tableToExcel2();" class="btn btn-info float-right">Unduh Excel</a>
    <br/><br/>
    <table id="initabel2" class="table table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th rowspan="2">No</th>
                @if($label!='bs')
                    <th rowspan="2">Nama Wilayah</th>
                @else 
                    <th rowspan="2">NURTS - Nama KRT</th>
                @endif
                <th colspan="3">Jumlah ART</th>
                @if($label!='bs')
                <th colspan="5">Jumlah RT</th>
                @endif
            </tr>
            
            <tr class="text-center">
                <th>Total</th>
                <th>Perempuan 10-54</th>
                <th>Mati</th>

                @if($label!='bs')
                <th>Target</th>
                <th>Realisasi</th>
                <th>Dilaporkan</th>
                <th>Diterima Kortim</th>
                <th>Diterima Koseka</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $total_art = 0;
                $total_perempuan_1549 = 0;
                $total_mati = 0;

                if($label!='bs'){
                    $total_terlapor = 0;
                    $total_total = 0;
                    $total_kortim = 0;
                    $total_koseka = 0;
                }
            @endphp
            @foreach($datas_c2 as $key=>$data)
                @php
                    $total_art += $data->jumlah_art; 
                    $total_perempuan_1549 += $data->jumlah_perempuan_1549; 
                    $total_mati += $data->jumlah_mati;

                    if($label!='bs'){
                        $total_terlapor += $data->terlapor;
                        $total_total += ($datas[$key]->total*16);
                        $total_kortim += $datas[$key]->c2_terima_kortim;
                        $total_koseka += $datas[$key]->c2_terima_koseka;

                        $total_koseka = 0;
                    }
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
                    <td class="text-center">{{ number_format($data->jumlah_art,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_perempuan_1549,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_mati,0,",",".") }}</td>
                    @if($label!='bs')
                    <td class="text-center">{{ $datas[$key]->total*16 }}</td>
                    <td class="text-center">{{ $data->terlapor }}</td>
                    <td class="text-center">
                        @if($datas[$key]->total==0)
                            (0 %)
                        @else 
                            ({{ round(($data->terlapor/($datas[$key]->total*16)*100),1) }} %)
                        @endif
                    </td>

                    <td class="text-center">
                        {{ $datas[$key]->c2_terima_kortim }}
                        ({{ round(($datas[$key]->c2_terima_kortim/($datas[$key]->total*16)*100),1) }} %)
                    </td>
                    <td class="text-center">
                        {{ $datas[$key]->c2_terima_koseka }}
                        ({{ round(($datas[$key]->c2_terima_koseka/($datas[$key]->total*16)*100),1) }} %)
                    </td>
                    @endif
                </tr>
            @endforeach
            
            <tr class="text-center">
                <td colspan="2"><b>TOTAL</b></td> 
                <td>{{ number_format($total_art,0,",",".") }}</td>
                <td>{{ number_format($total_perempuan_1549,0,",",".") }}</td>
                <td>{{ number_format($total_mati,0,",",".") }}</td>
                @if($label!='bs')
                    <td class="text-center">{{ $total_total }}</td>
                    <td class="text-center">{{ $total_terlapor }}</td>
                    <td class="text-center">
                        @if($total_total==0)
                            (0 %)
                        @else
                            ({{ round(($total_terlapor/$total_total*100),1) }} %)
                        @endif
                    </td>
                
                    <td class="text-center">
                        {{ $total_kortim }}
                        ({{ round(($total_kortim/$total_total*100),1) }} %)
                    </td>
                    <td class="text-center">
                        {{ $total_koseka }}
                        ({{ round(($total_koseka/$total_total*100),1) }} %)
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
</div>