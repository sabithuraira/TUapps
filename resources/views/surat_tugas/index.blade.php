@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Daftar Surat Tugas</li>
</ul>
@endsection

@section('content')
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div>
      @endif

      <div class="card">
        <div class="body">      
            <a href="{{action('SuratTugasController@create')}}" class="'btn btn-info btn-sm"><i class='fa fa-plus'></i> Tambah Surat Tugas</a>
              
          <br/><br/>
          <form action="{{url('surat_tugas')}}" method="get">
            <div class="input-group mb-3">
                    
                    @csrf
                    <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </div>
            </div>
          </form>
          <section class="datas">
            @include('surat_tugas.list')
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
