<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['jenis_surat'] }}:</label>
            <select class="form-control {{($errors->first('jenis_surat') ? ' parsley-error' : '')}}"  name="jenis_surat">
                <option value="">- Pilih Jenis Surat -</option>
                @foreach ($model->listJenis as $key=>$value)
                    <option value="{{ $key }}" 
                        @if ($key == old('jenis_surat', $model->jenis_surat))
                            selected="selected"
                        @endif >{{ $value }}</option>
                @endforeach
            </select>
            @foreach ($errors->get('jenis_surat') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>{{ $model->attributes()['tanggal'] }}:</label>
            <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" value="{{ old('tanggal', date('m/d/Y', strtotime($model->tanggal))) }}">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
            @foreach ($errors->get('tanggal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['perihal'] }}:</label>
            <input type="text" class="form-control {{($errors->first('perihal') ? ' parsley-error' : '')}}" name="perihal" value="{{ old('perihal', $model->perihal) }}">
            @foreach ($errors->get('perihal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>{{ $model->attributes()['nomor_petunjuk'] }}:</label>
            <input type="text" class="form-control {{($errors->first('nomor_petunjuk') ? ' parsley-error' : '')}}" name="nomor_petunjuk" value="{{ old('nomor_petunjuk', $model->nomor_petunjuk) }}">
            @foreach ($errors->get('nomor_petunjuk') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['nomor_urut'] }}:</label>
            <input type="text" class="form-control {{($errors->first('nomor_urut') ? ' parsley-error' : '')}}" name="nomor_urut" value="{{ old('nomor_urut', $model->nomor_urut) }}">
            @foreach ($errors->get('nomor_urut') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>{{ $model->attributes()['nomor'] }}:</label>
            <input type="text" class="form-control {{($errors->first('nomor') ? ' parsley-error' : '')}}" name="nomor" value="{{ old('nomor', $model->nomor) }}">
            @foreach ($errors->get('nomor') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

    <div class="form-group">
        <label>{{ $model->attributes()['alamat'] }}:</label>
        <input type="text" class="form-control {{($errors->first('alamat') ? ' parsley-error' : '')}}" name="alamat" value="{{ old('alamat', $model->alamat) }}">
        @foreach ($errors->get('alamat') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
    </div>


<br>
<button type="submit" class="btn btn-primary">Simpan</button>


@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
@endsection