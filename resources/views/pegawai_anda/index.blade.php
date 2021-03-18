@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Pegawai Anda</li>
</ul>
@endsection

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
        
          <form action="{{url('pegawai_anda')}}" method="get">
            @csrf
            <div class="row clearfix">
              <div class="col-lg-11 col-md-12 left-box">
                <div class="form-group">
                    
                  <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                </div>
              </div>
                      
              <div class="col-lg-1 col-md-12 right-box">
                  <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </form> 
          <section class="datas">
            @include('pegawai_anda.list')
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
