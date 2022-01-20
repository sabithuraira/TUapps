@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li> 
    <li class="breadcrumb-item"><a href="{{url('/pok')}}">Anggaran</a></li>                           
    <li class="breadcrumb-item">Simpan Revisi</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <section class="datas">
                    @include('pok.simpan_revisi_list')
                </section>
            </div>
        </div>
    </div>
</div>
@endsection