@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item"><a href="{{url('opname_permintaan')}}">OPNAME PERMINTAAN</a></li>                  
    <li class="breadcrumb-item">Form Permintaan</li>
</ul>
@endsection

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <a href="{{action('OpnamePermintaanController@index')}}" class="btn btn-primary"><i class="fa fa-list"></i> <span>Daftar Permintaan</span></a>
          <br/><br/>
          
          <form method="post" action="{{url('opname_permintaan')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Barang:</label>
                <select class="form-control" name="form_id_barang" required>
                    <option value="">- Pilih Barang -</option>
                    @foreach ($master_barang as $key=>$value)
                        <option value="{{ $value->id }}">{{ $value->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Permintaan:</label>
                <input type="date" name="form_tanggal_permintaan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Tanggal Penyerahan:</label>
                <input type="date" name="form_tanggal_penyerahan" class="form-control">
            </div>

            <div class="form-group">
                <label>Jumlah Diminta:</label>
                <input type="number" name="form_jumlah_diminta" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Jumlah Disetujui:</label>
                <input type="number" name="form_jumlah_disetujui" class="form-control">
            </div>

            <div class="form-group">
                <label>Unit Kerja:</label>
                <select class="form-control" name="form_unit_kerja" required>
                    <option value="">- Pilih Unit Kerja -</option>
                    @foreach ($unit_kerja as $key=>$value)
                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Unit Kerja 4:</label>
                <select class="form-control" name="form_unit_kerja4" required>
                    <option value="">- Pilih Unit Kerja 4 -</option>
                    @foreach ($unit_kerja4 as $key=>$value)
                        <option value="{{ $value->id }}">{{ $value->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status Aktif:</label>
                <select class="form-control" name="form_status_aktif">
                    <option value="1">Diajukan</option>
                    <option value="2">Disetujui</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{action('OpnamePermintaanController@index')}}" class="btn btn-default">Batal</a>
          </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
@endsection


