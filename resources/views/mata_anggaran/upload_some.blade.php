@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                           
    <li class="breadcrumb-item">Import Excel</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Import Data Mata Anggaran</h2>
          </div>
          <div class="body">
                <form method="post" action="{{url('mata_anggaran/import_some')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pilih Tahun:</label>
                                <select class="form form-control" name="tahun">
                                    @for($i=2021;$i <= date('Y')+1;++$i)
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
                    <a href="https://docs.google.com/spreadsheets/d/14K6XzAIOOJ--NTPfPCyxhiHNObjP0psE/edit?usp=sharing&ouid=118352400916187049744&rtpof=true&sd=true">Unduh Template Mata Anggaran</a>
                    
                </form>
          </div>
      </div>
  </div>
</div>
@endsection