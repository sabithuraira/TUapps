@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li> 
    <li class="breadcrumb-item"><a href="{{url('/pok')}}">Anggaran</a></li>                           
    <li class="breadcrumb-item">Data POK</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2>Import Excel</h2>
            </div>
            <div class="body">
                <section class="datas">
                    @include('pok.list')
                </section>
            </div>
        </div>
    </div>
</div>
@endsection