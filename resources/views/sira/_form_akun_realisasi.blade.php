    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_mak'] }}:</label>
                <input type="text" disabled class="form-control" name="kode_mak" value="{{ $akun->kode_mak }}">
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['kode_akun'] }}:</label>
                <input type="text" disabled class="form-control" name="kode_akun" value="{{ $akun->kode_akun }}">
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['kode_fungsi'] }}:</label>
                <select class="form-control {{($errors->first('kode_fungsi') ? ' parsley-error' : '')}}" id="kode_fungsi" name="kode_fungsi" v-model="data_model.kode_fungsi">
                    @foreach ($model->listFungsi as $key=>$value)
                        <option  value="{{ $key }}" 
                            @if ($key == old('kode_fungsi', $model->kode_fungsi))
                                selected="selected"
                            @endif>
                            {{ $value }}
                        </option>
                    @endforeach
                </select>
                @foreach ($errors->get('kode_fungsi') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['realisasi'] }}:</label>
                <input type="number" class="form-control {{($errors->first('realisasi') ? ' parsley-error' : '')}}" name="realisasi" value="{{ old('realisasi', $model->realisasi) }}" autofocus>
                @foreach ($errors->get('realisasi') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="form-group">
                <label>{{ $model->attributes()['keterangan'] }}:</label>
                <input type="text" class="form-control {{($errors->first('keterangan') ? ' parsley-error' : '')}}" name="keterangan" value="{{ old('keterangan', $model->keterangan) }}" autofocus>
                @foreach ($errors->get('keterangan') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>
    </div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>