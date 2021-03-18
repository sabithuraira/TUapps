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
                    <div class="form-group">
                        <label>Pilih File:</label>
                        <input type="file" class="form-control" name="excel_file">
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary">Simpan</button> &nbsp; &nbsp;
                    <a href="https://laci.bps.go.id/s/mgTJ5a68wqNPmy3">Unduh Template Mata Anggaran</a>
                    
                </form>
          </div>
      </div>
  </div>
</div>
@endsection