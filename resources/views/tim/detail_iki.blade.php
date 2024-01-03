@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('tim')}}">Tim</a></li>                            
    <li class="breadcrumb-item">Detail IKI</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="body">
            <div id="app_vue">
                <div class="form-group">
                    <label>Nama Tim:</label>
                    <input type="text" disabled class="form-control form-control-sm" value="{{ $model->nama_tim }}" />
                </div>

                <div class="table-responsive">
                    <table class="m-b-0 table-bordered table-sm" style="min-width:100%">
                        <thead>
                            <tr class="text-center">
                                <td rowspan="2">No</td>
                                <td rowspan="2">Pegawai</td>
                                <td colspan="3">IKI</td>
                            </tr>

                            <tr class="text-center">
                                <td>Rincian</td>
                                <td>Target</td>
                                <td>Deadline</td>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($participant as $key=>$value)
                                @php 
                                    $all_iki = App\IkiMaster::where('nip', $value->nik_anggota)
                                                    ->where('id_tim', $value->id_tim)->get();
                                    $total_iki = count($all_iki);
                                @endphp
                                @if($total_iki==0)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->nik_anggota }} - {{ $value->nama_anggota }}</td>
                                        <td colspan="3" class="text-center">-</td>
                                    </tr>
                                @else 
                                    <tr>
                                        <td rowspan="{{ $total_iki }}">{{ $key+1 }}</td>
                                        <td rowspan="{{ $total_iki }}">{{ $value->nik_anggota }} - {{ $value->nama_anggota }}</td>
                                        <td>{{ $all_iki[0]->ik }}</td>
                                        <td>{{ $all_iki[0]->target }} {{ $all_iki[0]->satuan }}</td>
                                        <td class="text-right">{{ config('app.months')[$all_iki[0]->bulan] }} {{ $model->tahun }}</td>
                                    </tr>

                                    @if($total_iki>1)
                                        @foreach($all_iki as $key2=>$value2)
                                            @if($key2 > 0)  
                                                <tr>
                                                    <td>{{ $value2->ik }}</td>
                                                    <td>{{ $value2->target }} {{ $value2->satuan }}</td>
                                                    <td class="text-right">{{ config('app.months')[$value2->bulan] }} {{ $model->tahun }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif 
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                                <h4 class="text-center">Please wait...</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
      </div>
  </div>
</div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/multi-select/css/multi-select.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/multi-select/js/jquery.multi-select.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
@endsection