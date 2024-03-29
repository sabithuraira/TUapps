@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">Matrik Tugas</li>
</ul>
@endsection

@section('content')
<div class="container">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
    </div>
    @endif

    <div class="card" id="app_vue">
        <div class="body">
            <form action="{{url('penugasan')}}" method="get">
                <a href="{{action('PenugasanController@create')}}" class="'btn btn-info btn-sm"><i
                        class='fa fa-plus'></i> Penugasan</a>
                <br /><br />
                @csrf

                @if(Auth::user()->kdkab=='00')
                <div class="row clearfix">
                    <div class="col-md-12 left">
                        <select class="form-control  form-control-sm" name="unit_kerja" onchange="this.form.submit()">
                            @foreach ( config('app.unit_kerjas') as $key=>$value)
                            <option @if ($key==old('unit_kerja', substr($unit_kerja,2))) selected="selected" @endif
                                value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br/>
                @endif

                <div class="row clearfix">
                    <div class="col-md-8 left">
                        <select class="form-control  form-control-sm" name="ditugaskan_oleh" onchange="this.form.submit()">
                            <option value="">- Fungsi yang Menugaskan -</option>
                            @foreach ($list_fungsi as $key=>$value)
                            <option value="{{ $value->id }}" @if ($ditugaskan_oleh==$value->id) selected="selected" @endif>{{ $value->nama }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 left">
                        <select class="form-control  form-control-sm" name="month" onchange="this.form.submit()">
                            <option value="">- Pilih Bulan -</option>
                            @foreach ( config('app.months') as $key=>$value)
                            <option value="{{ $key }}" @if ($month==$key) selected="selected" @endif>{{ $value }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 left">
                        <select class="form-control  form-control-sm" name="year" onchange="this.form.submit()">
                            <option value="">- Pilih Tahun -</option>
                            @for ($i=2021;$i<=date('Y');$i++) <option value="{{ $i }}" @if ($year==$i)
                                selected="selected" @endif>{{ $i }}</option>
                                @endfor
                        </select>
                    </div>
                </div>
            </form>
            <br />
            <section class="datas">
                @include('penugasan.list')
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection