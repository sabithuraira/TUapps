<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['pegawai_id'] }}:</label>
            <select class="form-control {{($errors->first('pegawai_id') ? ' parsley-error' : '')}}"  name="pegawai_id">
                @foreach ($list_pegawai as $pegawai)
                    <option  value="{{ $pegawai->email }}" 
                        @if ($pegawai->email == old('pegawai_id', $model->pegawai_id))
                            selected="selected"
                        @endif>
                        {{ $pegawai->nip_baru }} - {{ $pegawai->name }}
                    </option>
                @endforeach
            </select>
            @foreach ($errors->get('pegawai_id') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['nomor_surat'] }}:</label>
            <input type="text" class="form-control {{($errors->first('nomor_surat') ? ' parsley-error' : '')}}" name="nomor_surat" value="{{ old('nomor_surat', $model->nomor_surat) }}">
            @foreach ($errors->get('nomor_surat') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="form-group">
    <label>{{ $model->attributes()['nama_kegiatan'] }}:</label>
    <input type="text" class="form-control {{($errors->first('nama_kegiatan') ? ' parsley-error' : '')}}" name="nama_kegiatan" value="{{ old('nama_kegiatan', $model->nama_kegiatan) }}">
    @foreach ($errors->get('nama_kegiatan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['penjelasan'] }}:</label>
    <input type="text" class="form-control {{($errors->first('penjelasan') ? ' parsley-error' : '')}}" name="penjelasan" value="{{ old('penjelasan', $model->penjelasan) }}">
    @foreach ($errors->get('penjelasan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>Tanggal:</label>
        <div class="input-daterange input-group" data-provide="datepicker">
            
            <input type="text" class="input-sm form-control {{($errors->first('tanggal_mulai') ? ' parsley-error' : '')}}" name="tanggal_mulai" value="{{ old('tanggal_mulai', $model->tanggal_mulai) }}">
            @foreach ($errors->get('tanggal_mulai') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach

            <span class="input-group-addon"> &nbsp s/d &nbsp </span>

            <input type="text" class="form-control {{($errors->first('tanggal_selesai') ? ' parsley-error' : '')}}" name="tanggal_selesai" value="{{ old('tanggal_selesai', $model->tanggal_selesai) }}">
            @foreach ($errors->get('tanggal_selesai') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </label>
</div>

<input type="hidden" name="is_kepala" value="1">


<div class="form-group">
    <label>{{ $model->attributes()['pejabat_ttd'] }}:</label>
    <select class="form-control {{($errors->first('pejabat_ttd') ? ' parsley-error' : '')}}"  name="pejabat_ttd">
        @foreach ($list_pejabat as $pejabat)
            <option  value="{{ $pejabat->email }}" 
                @if ($pejabat->email == old('pejabat_ttd', $model->pejabat_ttd))
                    selected="selected"
                @endif>
                {{ $pejabat->nip_baru }} - {{ $pejabat->name }}
            </option>
        @endforeach
    </select>
    @foreach ($errors->get('pejabat_ttd') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>STATUS: </label>
    <label class="fancy-checkbox">
        <input type="checkbox" name="is_lpd">
        <span>{{ $model->attributes()['is_lpd'] }}</span>
    </label>
    <label class="fancy-checkbox">
        <input type="checkbox" name="is_kelengkapan">
        <span>{{ $model->attributes()['is_kelengkapan'] }}</span>
    </label>
    <label class="fancy-checkbox">
        <input type="checkbox" name="is_lunas">
        <span>{{ $model->attributes()['is_lunas'] }}</span>
    </label>
    <p id="error-checkbox"></p>
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
@endsection
