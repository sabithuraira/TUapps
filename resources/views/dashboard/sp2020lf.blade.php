<style>
.c3-axis-x text 
{
  font-size: 10px;
}
</style>
<div class="alert alert-primary" role="alert">
    <!-- <p>Ingatkan petugas untuk selalu melaporkan progres lapangan Long Form SP2020 melalui TELEGRAM dan PANTAU progres nya ya..</p> -->
    <p><span style="font-size:30px">&#128071;</span> Persiapan monitoring Long Form SP2020... <span style="font-size:30px">&#9203;</span></p>
</div>
                    
<div class="card">
    <div class="body profilepage_2 blog-page">
        @if ($label == 'prov')
            SUMATERA SELATAN
            <!-- <a class="float-right" href="{{ url('download_sp2020') }}"><button><i class="fa fa-file-excel-o"></i>&nbsp Unduh Excel &nbsp</button></a> -->
        @elseif ($label == 'kab')
            <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
            - {{ $label_kab }}
            <!-- <a class="float-right" href="{{ url('download_sp2020?kab='.$kab) }}"><button><i class="fa fa-file-excel-o"></i>&nbsp Unduh Excel &nbsp</button></a> -->
        @elseif ($label == 'kec')
            <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
            - <u><a href="{{ url('dashboard/index?kab='.$kab) }}">{{ $label_kab }}</a></u>
            - {{ $label_kec }}
            
            <!-- <a class="float-right" href="{{ url('download_sp2020?kab='.$kab.'&kec='.$kec) }}"><button><i class="fa fa-file-excel-o"></i>&nbsp Unduh Excel &nbsp</button></a> -->
        @elseif($label=='desa')
            <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
            - <u><a href="{{ url('dashboard/index?kab='.$kab) }}">{{ $label_kab }}</a></u>
            - <u><a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$kec) }}">{{ $label_kec }}</a></u> 
            - {{ $label_desa }}   
            
            <!-- <a class="float-right" href="{{ url('download_sp2020?kab='.$kab.'&kec='.$kec.'&desa='.$desa) }}"><button><i class="fa fa-file-excel-o"></i>&nbsp Unduh Excel &nbsp</button></a> -->
        @elseif($label=='bs')
        <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
        - <u><a href="{{ url('dashboard/index?kab='.$kab) }}">{{ $label_kab }}</a></u>
        - <u><a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$kec) }}">{{ $label_kec }}</a></u> 
        - <u><a href="{{ url('dashboard/index?kab='.$kab.'&kec='.$kec.'&desa='.$desa) }}">{{ $label_desa }}</a></u> 
        - {{ $bs }}   
        
        <!-- <a class="float-right" href="{{ url('download_sp2020?kab='.$kab.'&kec='.$kec.'&desa='.$desa) }}"><button><i class="fa fa-file-excel-o"></i>&nbsp Unduh Excel &nbsp</button></a> --> 
        @endif
        <br/><br/>
        <div>
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#hai_table">Table Pemutakhiran</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hai_grafik">Grafik Pemutakhiran</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#c2_table">Table C2</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#c2_grafik">Grafik C2</a></li>
            </ul>
            <div class="tab-content">
                @include('dashboard.sp2020lf_table')
                @include('dashboard.sp2020lf_grafik')
                @include('dashboard.sp2020lfc2_table')
                @include('dashboard.sp2020lfc2_grafik')
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="{!! asset('assets/bundles/c3.bundle.js') !!}"></script>
<script>
    var series =  {!! json_encode($persens) !!};
    var chart = c3.generate({
        bindto: '#chart-bar', // id of chart wrapper
        data: {
            columns: [
                // each columns data
                ['data1'].concat(series),
            ],
            type: 'bar', 
            colors: {
                'data1': lucid.colors["blue"]
            },
            names: {
                'data1': 'Persentase dilaporkan: '
            }
        },
        axis: {
            x: {
                type: 'category',
                categories: {!! json_encode($labels) !!},
            },
            y: {
                max: 100,
            },
        },
        bar: {
            ratio: 0.5
        },
        legend: {
            show: false, //hide legend
        },
        padding: {
            bottom: 100,
            top: 10
        },
    });
</script>
@endsection