@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Log Book</li>
</ul>
@endsection

@section('content')
    <div class="container">
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card" id="app_vue">
        <div class="body">
          <a href="#" role="button" v-on:click="addLogBook"  class="btn btn-primary" data-toggle="modal" data-target="#add_logbooks"><i class="fa fa-plus-circle"></i> <span>Tambah Log Book</span></a>
          <br/><br/>
          <div class="row clearfix">
                <div class="col-lg-12 col-md-12 left-box">
                    <div class="form-group">
                        <label>Tampilkan mulai - hingga:</label>
                           
                        <div class="input-daterange input-group" data-provide="datepicker">
                            <input type="text" class="input-sm form-control" v-model="start" id="start">
                            <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                            
                            <input type="text" class="input-sm form-control" v-model="end" id="end">
                        </div>

                    </div>
                </div>

            </div>

          <section class="datas">
              @include('log_book.list')
          </section>
      </div>
    </div>
  </div>
@endsection
