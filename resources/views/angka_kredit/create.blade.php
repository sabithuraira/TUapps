@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('angka_kredit')}}">Angka Kredit</a></li>                            
    <li class="breadcrumb-item">Tambah Data</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
  <div class="col-md-12">
      <div class="card">
          <div class="header">
              <h2>Tambah Rincian Angka Kredit</h2>
          </div>
          <div class="body">
              <form method="post" action="{{url('angka_kredit')}}" enctype="multipart/form-data">
              @csrf
                    <div class="form-group">
                        <label>Peruntukan:</label>
                        <select class="form-control {{($errors->first('jenis') ? ' parsley-error' : '')}}"  name="uraian" value="{{ old('uraian') }}" autofocus>
                            <option>- Pilih Peruntukan -</option>
                            @foreach ($item_jenis as $ijenis)
                                <option value="{{ $ijenis['id'] }}">{{ $ijenis['uraian'] }}</option>
                            @endforeach
                        </select>
                      @foreach ($errors->get('uraian') as $msg)<p class="text-danger">{{ $msg }}</p>@endforeach
                    </div>

                    <div class="form-group">
                        <label>Kode:</label>
                        <input type="text" class="form-control {{($errors->first('kode') ? ' parsley-error' : '')}}" name="kode" value="{{ old('kode') }}">
                        @foreach ($errors->get('kode') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label>Butir Kegiatan:</label>
                        <input type="text" class="form-control {{($errors->first('butir_kegiatan') ? ' parsley-error' : '')}}" name="butir_kegiatan" value="{{ old('butir_kegiatan') }}">
                        @foreach ($errors->get('butir_kegiatan') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label>Satuan Hasil:</label>
                        <input type="text" class="form-control {{($errors->first('satuan_hasil') ? ' parsley-error' : '')}}" name="satuan_hasil" value="{{ old('satuan_hasil') }}">
                        @foreach ($errors->get('satuan_hasil') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    
                    <div class="form-group">
                        <label>Angka Kredit:</label>
                        <input type="text" class="form-control {{($errors->first('angka_kredit') ? ' parsley-error' : '')}}" name="angka_kredit" value="{{ old('angka_kredit') }}">
                        @foreach ($errors->get('angka_kredit') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    
                    <div class="form-group">
                        <label>Batas Penilaian:</label>
                        <input type="text" class="form-control {{($errors->first('batas_penilaian') ? ' parsley-error' : '')}}" name="batas_penilaian" value="{{ old('batas_penilaian') }}">
                        @foreach ($errors->get('batas_penilaian') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    
                    <div class="form-group">
                        <label>Pelaksana:</label>
                        <input type="text" class="form-control {{($errors->first('pelaksana') ? ' parsley-error' : '')}}" name="pelaksana" value="{{ old('pelaksana') }}">
                        @foreach ($errors->get('pelaksana') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>

                    
                    <div class="form-group">
                        <label>Bukti Fisik:</label>
                        <input type="text" class="form-control {{($errors->first('bukti_fisik') ? ' parsley-error' : '')}}" name="bukti_fisik" value="{{ old('bukti_fisik') }}">
                        @foreach ($errors->get('bukti_fisik') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                  <br>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
          </div>
      </div>
  </div>
</div>
@endsection
