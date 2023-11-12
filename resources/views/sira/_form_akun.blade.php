<a href="{{action('SiraController@import_akun')}}" class="btn btn-info">Import Akun Excel</a>
<br/><br/>        

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['kode_mak'] }}:</label>
                <input type="text" class="form-control {{($errors->first('kode_mak') ? ' parsley-error' : '')}}" name="kode_mak" value="{{ old('kode_mak', $model->kode_mak) }}" autofocus>
                @foreach ($errors->get('kode_mak') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['mak'] }}:</label>
                <input type="text" class="form-control {{($errors->first('mak') ? ' parsley-error' : '')}}" name="mak" value="{{ old('mak', $model->mak) }}" autofocus>
                @foreach ($errors->get('mak') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['kode_akun'] }}:</label>
                <input type="text" class="form-control {{($errors->first('kode_akun') ? ' parsley-error' : '')}}" name="kode_akun" value="{{ old('kode_akun', $model->kode_akun) }}" autofocus>
                @foreach ($errors->get('kode_akun') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['akun'] }}:</label>
                <input type="text" class="form-control {{($errors->first('akun') ? ' parsley-error' : '')}}" name="akun" value="{{ old('akun', $model->akun) }}" autofocus>
                @foreach ($errors->get('akun') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>
    </div>

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
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['pagu'] }}:</label>
                <input type="number" class="form-control {{($errors->first('pagu') ? ' parsley-error' : '')}}" name="pagu" value="{{ old('pagu', $model->pagu) }}" autofocus>
                @foreach ($errors->get('pagu') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach    
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['realisasi'] }}:</label>
                <input type="number" disabled class="form-control {{($errors->first('realisasi') ? ' parsley-error' : '')}}" name="realisasi" value="{{ old('realisasi', $model->realisasi) }}" autofocus>  
            </div>
        </div>
    </div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>