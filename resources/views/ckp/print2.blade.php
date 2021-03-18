<!doctype html>
<html lang="en">

<head>

<!-- VENDOR CSS -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<!-- <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}"> -->
<!-- <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/font-awesome/css/font-awesome.min.css') !!}"> -->

</head>
<body class="theme-cyan">


<div id="wrapper">

    <div id="main-content">
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="body">
                            <!-- <h4>Invoice Details</h4> -->
                           
                                <div>
                                    <div class="row clearfix">
                                        <div class="col-md-6 col-sm-6">
                                        </div>
                                        <div class="col-md-6 col-sm-6 text-right">
                                            <div class="row clearfix">
                                                <div class="col-md-8 col-sm-8"></div>
                                                <div class="col-md-4 col-sm-4 text-right">
                                                    <h5 class="text-center" style='border:2px #444444 solid;'>CKP-T</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-center">TARGET KINERJA PEGAWAI TAHUN {{ $year }}</h5>
                                    
                                    <div class="row clearfix">
                                        <div class="col-md-2 col-sm-2">
                                            <p class="m-b-0">Satuan Organisasi</p>
                                            <p class="m-b-0">Nama</p>
                                            <p class="m-b-0">Jabatan</p>
                                            <p>Periode</p>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <p class="m-b-0">: {{ $year}}</p>
                                            <p class="m-b-0">: {{ $year}}</p>
                                            <p class="m-b-0">: {{ $year}}</p>
                                            <p>: {{ $year}}</p>    
                                        </div>
                                        <div class="col-md-4 col-sm-4 text-right">
                                        </div>
                                    </div>

                                    <div class="row clearfix">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2"  class="w-50">{{ $model->attributes()['uraian'] }}</th>
                                                            <th rowspan="2">{{ $model->attributes()['satuan'] }}</th>
                                                            
                                                            
                                                             @if ($type == 1)
                                                                <th rowspan="2">Target Kuantitas</th>
                                                            @else
                                                                <th colspan="3">Kuantitas</th>
                                                                <th rowspan="2">Tingkat Kualitas</th>
                                                            @endif

                                                            <th rowspan="2">{{ $model->attributes()['kode_butir'] }}</th>
                                                            <th rowspan="2">{{ $model->attributes()['angka_kredit'] }}</th>
                                                            <th rowspan="2">{{ $model->attributes()['keterangan'] }}</th>
                                                        </tr>

                                                        @if ($type != 1)
                                                            <tr>
                                                                <th>Target</th>
                                                                <th>Realisasi</th>
                                                                <th>%</th>
                                                            </tr>
                                                        @endif
                                                    </thead>
                                                    <tbody>
                                                        <tr class="text-center">
                                                            @php
                                                                $no_column = 1;
                                                            @endphp
                                                            <td>({{ $no_column++ }})</td>
                                                            <td>({{ $no_column++ }})</td>
                                                            <td>({{ $no_column++ }})</td>
                                                            <td>({{ $no_column++ }})</td>
                                                            
                                                            @if ($type == 2)
                                                                <td>({{ $no_column++ }})</td>
                                                                <td>({{ $no_column++ }})</td>
                                                                <td>({{ $no_column++ }})</td>
                                                            @endif

                                                            <td>({{ $no_column++ }})</td>
                                                            <td>({{ $no_column++ }})</td>
                                                            <td>({{ $no_column++ }})</td>
                                                        </tr>
                                                        @php
                                                            $total_column = ($type==1) ? 7 : 10;
                                                        @endphp
                                                        
                                                        <tr><td colspan="{{ $total_column }}">UTAMA</td></tr>
                                                        @foreach($datas['utama'] as $key=>$data)
                                                        
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{$data->uraian }}</td>
                                                                <td>{{$data->satuan }}</td>
                                                                <td>{{$data->target_kuantitas }}</td>

                                                                @if ($type == 2)
                                                                    <td>{{ $data->realisasi_kuantitas }}</td>
                                                                    <td>%</td>
                                                                    <td>{{ $data->kualitas }}</td>
                                                                @endif

                                                                <td>{{ $data->kode_butir }}</td>
                                                                <td>{{ $data->angka_kredit }}</td>
                                                                <td>{{ $data->keterangan }}</td>
                                                            </tr>
                                                        @endforeach

                                                        
                                                        <tr><td colspan="{{ $total_column }}">TAMBAHAN</td></tr>
                                                        @foreach($datas['tambahan'] as $key=>$data)
                                                        
                                                            <tr>
                                                                <td>{{ $key+1 }}</td>
                                                                <td>{{$data->uraian }}</td>
                                                                <td>{{$data->satuan }}</td>
                                                                <td>{{$data->target_kuantitas }}</td>

                                                                @if ($type == 2)
                                                                    <td>{{ $data->realisasi_kuantitas }}</td>
                                                                    <td>%</td>
                                                                    <td>{{ $data->kualitas }}</td>
                                                                @endif

                                                                <td>{{ $data->kode_butir }}</td>
                                                                <td>{{ $data->angka_kredit }}</td>
                                                                <td>{{ $data->keterangan }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row clearfix">
                                        <div class="col-md-6">
                                            <b>Penilaian Kinerja</b>
                                            <p>Tanggal: {{ $year }}</p>
                                        </div>
                                    </div> 
                                    <br/>
                                    
                                    <div class="row clearfix">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3 text-center">
                                            <p>Pegawai Yang Dinilai</p>
                                            <p></p>
                                            <p></p>
                                            <p>( Sabit Huraira)</p>
                                            <p>NIP.  19890823 201211 1 001</p>
                                        </div>
                                        
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3 text-center">
                                            <p>Pejabat Penilai</p>
                                            <p></p>
                                            <p></p>
                                            <p>( Bambang Sri Yuwono)</p>
                                            <p>NIP.  19671112 199101 1 001</p>
                                        </div>
                                        <div class="col-md-2"></div>
                                        <!-- <div class="col-md-6 text-right">
                                            <p class="m-b-0"><b>Sub-total:</b> 2930.00</p>
                                            <p class="m-b-0">Discout: 12.9%</p>
                                            <p class="m-b-0">VAT: 12.9%</p>                                        
                                            <h3 class="m-b-0 m-t-10">USD 2930.00</h3>
                                        </div>                 -->
                                    </div> 
                                </div>   

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</body>
</html>
