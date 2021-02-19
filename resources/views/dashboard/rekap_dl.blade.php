@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>            
    <li class="breadcrumb-item"><a href="{{url('log_book')}}"> CKP</a></li>                      
    <li class="breadcrumb-item">Rekapitulasi CKP</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app_vue">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body"> 
            <form action="{{url('dashboard/rekap_dl')}}" method="get">
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-12">
                        <label>Unit Kerja:</label>
                        <div class="form-group">
                            <div class="input-group">
                                <select class="form-control  form-control-sm" name="uk" onchange='this.form.submit()'>
                                    @foreach(config('app.unit_kerjas') as $key=>$value)
                                        <option value="{{ $key }}" 
                                         @if($uk==$key)
                                            selected="selected"
                                         @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 left-box">
                        <div class="form-group">
                            <label>Bulan:</label>
                            <div class="input-group">
                                <select class="form-control  form-control-sm" name="month" onchange='this.form.submit()'>
                                    @foreach(config('app.months') as $key=>$value)
                                        <option value="{{ $key }}" 
                                        @if($month==$key)
                                            selected="selected"
                                         @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 right-box">
                        <div class="form-group">
                            <label>Tahun:</label>

                            <div class="input-group">
                            <select class="form-control  form-control-sm" name="year" onchange='this.form.submit()'>
                                @for ($i=2019;$i<=date('Y');$i++)
                                    <option value="{{ $i }}" 
                                    @if($year==$i)
                                        selected="selected"
                                    @endif>{{ $i }}</option>
                                @endfor
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="datas">
                <div id="load">
                    <div class="table-responsive">
                        <table class="table-bordered m-b-0" style='min-width:100%'>
                            @php 
		                        $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                            @endphp
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama</th>
                                    @for($i=1;$i<=$d;++$i)
                                        @if($i<10)
                                            <th>0{{ $i }}</th>
                                        @else
                                            <th>{{ $i }}</th>
                                        @endif
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $key=>$value)
                                    <tr >
                                        <td>{{ $key+1 }}.</td>
                                        <td>{{ $value->nama }}</td>
                                        @for($i=1;$i<=$d;++$i)
                                            @php 
                                                $var_name = "day".$i;
                                                $cur_data = $value->$var_name;
                                            @endphp
                                            @if($cur_data==1)
                                                <td class="text-center bg-primary text-white">DL</td>
                                            @else
                                                @if(in_array($i,$list_libur))
                                                    <td class="text-center bg-warning text-white"></td>
                                                @else

                                                    <td class="text-center text-white"></td>
                                                @endif
                                            @endif
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
      </div>
    </div>
  </div>
@endsection