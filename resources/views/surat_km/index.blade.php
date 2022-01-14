@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Surat</li>
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
          <a href="{{action('SuratKmController@create')}}" class="btn btn-info">Tambah</a>
          <br/>
          <small class="text-muted font-italic font-weight-lighter float-left">*Pengguna hanya dapat melihat & mengelola surat di unit kerja masing-masing.</small>
    
          <form action="{{url('surat_km')}}" method="get">
              @csrf
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                      <label>Kata Kunci:</label>
                      <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search.." onchange="this.form.submit()">
                  </div>
                </div>

                <div class="col-lg-6">
                  
                  <div class="form-group">
                      <label>Jenis Surat:</label>
                      
                      <div class="input-group">
                          <select class="form-control  form-control-sm" name="jenis" onchange="this.form.submit()">
                            <option value="" 
                                    @if ("" == old('jenis', $jenis))
                                        selected="selected"
                                    @endif >- Semua Jenis -</option>
                            @foreach ($model->listJenis as $key=>$value)
                                <option value="{{ $key }}" 
                                    @if ($key == old('jenis', $jenis))
                                        selected="selected"
                                    @endif >{{ $value }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                </div>
              </div>
          </form>
          <section class="datas">
              @include('surat_km.list')
          </section>
      </div>
    </div>
  </div>
@endsection

