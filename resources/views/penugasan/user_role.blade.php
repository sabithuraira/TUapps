@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Kelola User Pemberi Tugas</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <form action="{{url('penugasan/user_role')}}" method="get">
            <div class="input-group mb-3">
                @csrf
                <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                <div class="input-group-append">
                    <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

      <div class="card">
        <div class="body">
          <section class="datas">
            @include('penugasan.user_role_list')
          </section>
      </div>
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
@endsection
