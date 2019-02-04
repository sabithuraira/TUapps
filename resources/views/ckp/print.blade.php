<!doctype html>
<html lang="en">

<head>
<link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap/css/bootstrap.min.css') !!}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/farifam.css') !!}">
</head>
<body>


<div id="wrapper">

    <div>
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="card">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-lg-2 col-md-12">
                                <div class="receipt-left">
                                    <img class="img-fluid" src="{!! asset('lucid/assets/images/logo-pusri.png') !!}" style="width: 71px;">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12">
                                <div>
                                    PT. PUPUK SRIWIDJAYA
                                    <p>PALEMBANG</P>
                                    <b>Departemen Sarana & Umum</b>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-12 text-right">
                                <p class="mb-0">No. {{ $model->no }}</p>
                            </div>
                        </div>    
                        <br />                

                        <div class="row clearfix">                                
                            <div class="col-lg-12 col-md-12 text-center">
                                SPPK / SPPAB
                                <p>Surat Permintaan Pemeriksaan Kerusakan/Surat Permintaan Pembuatan Asset Baru<p>
                            </div>
                        </div>
                        <hr/>

                        <div class="row clearfix">                                
                            <div class="col-lg-8 col-md-12">
                                <p class="mb-0">Kepada :<b> {{ $model->kepada }}</b></p>
                                <p class="mb-0">Dari :<b> {{ $model->dari }}</b></p>
                            </div>
                            <div class="col-lg-4 col-md-12 text-right">
                                <p class="mb-0">User Code : {{ $model->user_code }}</p>
                                <p class="mb-0">Cost Centre : {{ $model->cose_centre }}</p>
                                <p class="mb-0">Telp : {{ $model->telp }}</p>
                            </div>
                        </div>        
                        <br/>
                        
                        <div class="row clearfix">                                
                            <div class="col-lg-12 col-md-12">
                                {{ $model->isi }}
                            </div>
                        </div>
                        <br/>
                        <br/>           
                        <div class="row clearfix">
                            <div class="col-lg-8 col-md-12">
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <p class="mb-0"><b>Palembang, </b> {{ $model->tanggal }}</p>
                                <p class="mb-0"><b>{{ $model->ttd_jabatan }}</b></p>
                                <br/><br/>
                                <p class="mb-0">Nama :<b> {{ $model->ttd_nama }}</b></p>
                                <p class="mb-0">Badge :<b> {{ $model->ttd_badge }}</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>

</body>
</html>
