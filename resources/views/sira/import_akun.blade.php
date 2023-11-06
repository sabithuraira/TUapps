@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>   
    <li class="breadcrumb-item"><a href="{{url('sira')}}">Kelengkapan Administrasi</a></li>                           
    <li class="breadcrumb-item">Import Akun</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Import Akun</h2>
          </div>
          <div class="body">
                <form method="post" action="{{url('sira/import_akun')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Tahun:</label>
                                <select class="form form-control" name="tahun">
                                    @for($i=2023;$i <= date('Y')+1;++$i)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih File:</label>
                                <input type="file" class="form-control" name="excel_file">
                            </div>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button> &nbsp; &nbsp;
                    <a href="https://docs.google.com/spreadsheets/d/1f4FV4ihQfv2QEBp_uvQC_iK97EhXIQY9bcFfUjj6q-0/edit?usp=sharing">Unduh Template Akun</a>
                    
                </form>
          </div>
      </div>
  </div>
</div>
@endsection