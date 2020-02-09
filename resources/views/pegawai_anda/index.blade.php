@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/pegawai_anda')}}"><i class="icon-home"></i></a></li>                     
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
