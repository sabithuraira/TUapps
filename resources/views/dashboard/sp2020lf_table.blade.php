<div class="tab-pane show active" id="hai_table">
    <a href="#" onclick="tableToExcel();" class="btn btn-info float-right">Unduh Excel</a>
    <br/><br/>
    <table id="initabel" class="table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Wilayah</th>
                <th colspan="6">Jumlah</th>
                <th rowspan="2">Progres Dilaporkan</th>
                <th rowspan="2">Diterima Kortim</th>
                <th rowspan="2">Diterima Koseka</th>
            </tr>
            
            <tr class="text-center">
                <th>RT</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>RT Ada Kematian</th>
                <th>BS Target</th>
                <th>BS Terlapor</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_ruta = 0;
                $total_laki = 0;
                $total_perempuan = 0;
                $total_ruta_ada_mati = 0;
                $total_terlapor = 0;
                $total_total = 0;
                $total_kortim = 0;
                $total_koseka = 0;
            @endphp
            @foreach($datas as $key=>$data)
                @php
                    if($data->jumlah_ruta!=''){
                        $total_ruta += $data->jumlah_ruta; 
                        $total_laki += $data->jumlah_laki; 
                        $total_perempuan += $data->jumlah_perempuan; 
                        $total_ruta_ada_mati += $data->jumlah_ruta_ada_mati;
                    } 
                    
                    $total_terlapor += $data->terlapor;
                    $total_total += $data->total;
                    $total_kortim += $data->terima_kortim;
                    $total_koseka += $data->terima_koseka;
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
                        @else
                            {{ $data->idw }} - {{ $data->nama }}
                        @endif
                    </td>
                    <td class="text-center">{{ number_format($data->jumlah_ruta,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_laki,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_perempuan,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_ruta_ada_mati,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->total,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->terlapor,0,",",".") }}</td>
                    <td class="text-center">
                        ({{ round(($data->terlapor/$data->total*100),1) }} %)
                    </td>
                    <td class="text-center">{{ number_format($data->terima_kortim,0,",",".") }} ({{ round(($data->terima_kortim/$data->total*100),1) }} %)</td>
                    <td class="text-center">{{ number_format($data->terima_koseka,0,",",".") }} ({{ round(($data->terima_koseka/$data->total*100),1) }} %)</td>
                </tr>
            @endforeach
            
            <tr class="text-center">
                <td colspan="2"><b>TOTAL</b></td> 
                <td>{{ number_format($total_ruta,0,",",".") }}</td>
                <td>{{ number_format($total_laki,0,",",".") }}</td>
                <td>{{ number_format($total_perempuan,0,",",".") }}</td>
                <td>{{ number_format($total_ruta_ada_mati,0,",",".") }}</td>
                <td>{{ number_format($total_total,0,",",".") }}</td>
                <td>{{ number_format($total_terlapor,0,",",".") }}</td>
                <td class="text-center">
                    ({{ round(($total_terlapor/$total_total*100),1) }} %)
                </td>
                <td>{{ number_format($total_kortim,0,",",".") }} ({{ round(($total_kortim/$total_total*100),1) }} %)</td>
                <td>{{ number_format($total_koseka,0,",",".") }} ({{ round(($total_koseka/$total_total*100),1) }} %)</td>
            </tr>
        </tbody>
    </table>
</div>