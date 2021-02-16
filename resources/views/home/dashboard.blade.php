@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Dashboard</li>
</ul>
@endsection

@section('content')
    <div class="container">
        <div class="alert alert-primary">
            <p><b>DASHBOARD MUSI</b></p>
            <p>nantinya akan menampilkan profile pegawai secara acak, informasi DL, CUTI dan Lembur suatu unit kerja..</p>
            <p class="text-right"><i>Data.. data everywhere..</i></p>
        </div>
    
        <div class="card">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-12">
                    @include('home.random_profile')
                </div>
            </div>
        </div>
    </div>
@endsection
