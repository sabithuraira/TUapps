@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="alert alert-primary" role="alert">
            <p>Teruntuk mata yang menikmati tabel dan grafik ini, kami adalah <b>MONITORING SP2020</b> yang sedang diujicobakan oleh sang tuan..</p>
            <p>Boleh abaikan, rasakan, atau berikan saran.. Sekian.. #SP2020KitoSenianan</p>
        </div>
                            
        <div class="card">
            <div class="body profilepage_2 blog-page">
                <div>
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#hai_table">Table</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hai_grafik">Grafik</a></li>
                    </ul>
                    <div class="tab-content">
                        @include('hai_table')
                        @include('hai_grafik')
                    </div>
                </div>
            </div>
        </div>
  </div>
@endsection