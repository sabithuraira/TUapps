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
                                <tr>
                                    <td>
                                        {{ $key+1 }}
                                    </td>
                                    <td>{{ $value->nik_anggota }} - {{ $value->nama_anggota }}</td>
                                    
                                    <td>
                                    </td>

                                    <td>
                                    </td>

                                    <td>
                                    </td>
                                </tr>
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