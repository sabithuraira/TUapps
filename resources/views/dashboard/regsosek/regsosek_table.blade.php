<div class="tab-pane show active" id="hai_table">
    <a href="#" onclick="tableToExcel();" class="btn btn-info float-right">Unduh Excel</a>
    <br/><br/>
    <table id="initabel" class="table-bordered table-sm" style="min-width:100%;">
        <thead>
            <tr class="text-center">
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Wilayah</th>
                <th colspan="2">Jumlah Keluarga</th>
                <th colspan="3">Jumlah Keluarga Selesai Cacah</th>
                <th colspan="3">Jumlah SLS</th>
            </tr>

            <tr class="text-center">
                <th>Prelist</th>
                <th>Verifikasi</th>
                <th>PCL</th>
                <th>PML</th>
                <th>KOSEKA</th>

                <th>Target</th>
                <th>Selesai Verifikasi</th>
                <th>Selesai Pencacahn</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_selesai = 0;
                $total_prelist = 0;
                $total_selesai_vk = 0;
                $total_sls = 0;
                $total_pcl = 0;
                $total_pml = 0;
                $total_koseka = 0;
                $total_total = 0;
            @endphp
            @foreach($datas as $key=>$data)
                @php
                    $total_selesai += $data->jumlah_selesai;
                    $total_selesai_vk += $data->jumlah_selesai_vk;
                    $total_prelist += $data->jumlah_prelist;
                    $total_sls  += $data->jumlah_sls;
                    $total_pcl  += $data->jumlah_pcl;
                    $total_pml  += $data->jumlah_pml;
                    $total_koseka  += $data->jumlah_koseka;
                    $total_total += $data->total;
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
                    <td class="text-center">{{ number_format($data->jumlah_prelist,0,",",".") }}</td>
                    <td class="text-center">{{ number_format($data->jumlah_sls,0,",",".") }}</td>

                    <td class="text-center">
                        @if($data->jumlah_sls==0)
                            {{ number_format($data->jumlah_pcl,0,",",".") }} (0 %)
                        @else 
                            {{ number_format($data->jumlah_pcl,0,",",".") }} ({{ round(($data->jumlah_pcl/$data->jumlah_sls*100),1) }} %)
                        @endif
                    </td>
                    <td class="text-center">
                        @if($data->jumlah_sls==0)
                        {{ number_format($data->jumlah_pml,0,",",".") }}  (0 %)
                        @else 
                        {{ number_format($data->jumlah_pml,0,",",".") }}  ({{ round(($data->jumlah_pml/$data->jumlah_sls*100),1) }} %)
                        @endif
                    </td>
                    <td class="text-center">
                        @if($data->jumlah_sls==0)
                        {{ number_format($data->jumlah_koseka,0,",",".") }}  (0 %)
                        @else 
                        {{ number_format($data->jumlah_koseka,0,",",".") }}  ({{ round(($data->jumlah_koseka/$data->jumlah_sls*100),1) }} %)
                        @endif
                    </td>

                    <td class="text-center">
                        {{ number_format($data->total,0,",",".") }}
                    </td>

                    <td class="text-center">
                        @if($data->total==0)
                        {{ number_format($data->jumlah_selesai_vk,0,",",".") }} (0 %)
                        @else
                        {{ number_format($data->jumlah_selesai_vk,0,",",".") }} ({{ round(($data->jumlah_selesai_vk/$data->total*100),1) }} %)
                        @endif 
                    </td>

                    <td class="text-center">
                        @if($data->total==0)
                        {{ number_format($data->jumlah_selesai,0,",",".") }} (0 %)
                        @else
                        {{ number_format($data->jumlah_selesai,0,",",".") }} ({{ round(($data->jumlah_selesai/$data->total*100),1) }} %)
                        @endif 
                    </td>
                </tr>
            @endforeach
            
            <tr class="text-center">
                <td colspan="2"><b>TOTAL</b></td> 
                <td>{{ number_format($total_prelist,0,",",".") }}</td>
                <td>{{ number_format($total_sls,0,",",".") }}</td>

                <td>
                    @if($total_sls==0)
                    {{ number_format($total_pcl,0,",",".") }} (0 %)
                    @else
                    {{ number_format($total_pcl,0,",",".") }} ({{ round(($total_pcl/$total_sls*100),1) }} %)
                    @endif 
                </td>
                <td>
                    @if($total_sls==0)
                    {{ number_format($total_pml,0,",",".") }} (0 %)
                    @else
                    {{ number_format($total_pml,0,",",".") }} ({{ round(($total_pml/$total_sls*100),1) }} %)
                    @endif 
                </td>
                <td>
                    @if($total_sls==0)
                    {{ number_format($total_koseka,0,",",".") }} (0 %)
                    @else
                    {{ number_format($total_koseka,0,",",".") }} ({{ round(($total_koseka/$total_sls*100),1) }} %)
                    @endif 
                </td>

                <td>{{ number_format($total_total,0,",",".") }}</td>

                <td>
                    @if($total_total==0)
                    {{ number_format($total_selesai_vk,0,",",".") }} (0 %)
                    @else
                    {{ number_format($total_selesai_vk,0,",",".") }} ({{ round(($total_selesai_vk/$total_total*100),1) }} %)
                    @endif 
                </td>
                
                <td>
                    @if($total_total==0)
                    {{ number_format($total_selesai,0,",",".") }} (0 %)
                    @else
                    {{ number_format($total_selesai,0,",",".") }} ({{ round(($total_selesai/$total_total*100),1) }} %)
                    @endif 
                </td>
            </tr>
        </tbody>
    </table>
</div>