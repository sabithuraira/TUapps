@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Master SLS Regsosek</li>
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
          <a href="{{action('RegsosekController@create')}}" class="btn btn-info">Tambah</a>
          <br/><br/>
          <form action="{{url('regsosek')}}" method="get">
              @csrf
              <div class="input-group mb-3">
                  <input type="text" class="form-control" name="keyword" id="search" value="{{ $keyword }}" placeholder="Search..">

                  <div class="input-group-append">
                      <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                  </div>
              </div>
          </form>

          <section class="datas">
            @include('regsosek.list')
          </section>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
