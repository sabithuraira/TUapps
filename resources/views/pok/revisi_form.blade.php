<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['judul'] }}:</label>
    <input type="text" class="form-control {{($errors->first('judul') ? ' parsley-error' : '')}}" name="judul" value="{{ old('judul', $model->judul) }}" autofocus>
    @foreach ($errors->get('judul') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['keterangan'] }}:</label>
    <textarea type="text" class="form-control {{($errors->first('keterangan') ? ' parsley-error' : '')}}" name="keterangan">{{ old('keterangan', $model->keterangan) }}</textarea>
    @foreach ($errors->get('keterangan') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach    
</div>

<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['kak'] }} <small>(pdf)</small>:</label>
    
    @if (strlen($model['kak'])>1)
        <input type="file" class="form-control {{($errors->first('kak') ? ' parsley-error' : '')}}" name="kak">
    @else
        <input type="file" class="form-control {{($errors->first('kak') ? ' parsley-error' : '')}}" name="kak" required>
    @endif
    
    @foreach ($errors->get('kak') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
    @if (strlen($model['kak'])>1)
        <a href="{{ action('PokController@unduh', ['tindak_lanjut', 'file', $model['kak']]  )}}"><i class=" icon-arrow-down"></i> Unduh File</a>
    @endif
</div>


<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['nota_dinas'] }} <small>(pdf)</small>:</label>
    
    @if (strlen($model['nota_dinas'])>1)
        <input type="file" class="form-control {{($errors->first('nota_dinas') ? ' parsley-error' : '')}}" name="nota_dinas">
    @else
        <input type="file" class="form-control {{($errors->first('nota_dinas') ? ' parsley-error' : '')}}" name="nota_dinas" required>
    @endif
    
    @foreach ($errors->get('nota_dinas') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
    @if (strlen($model['nota_dinas'])>1)
        <a href="{{ action('PokController@unduh', ['tindak_lanjut', 'file', $model['nota_dinas']]  )}}"><i class=" icon-arrow-down"></i> Unduh File</a>
    @endif
</div>


<div class="form-group">
    <label><span style="color: red; display:block; float:right">*</span>{{ $model->attributes()['matrik_anggaran'] }} <small>(pdf)</small>:</label>
    
    @if (strlen($model['matrik_anggaran'])>1)
        <input type="file" class="form-control {{($errors->first('matrik_anggaran') ? ' parsley-error' : '')}}" name="matrik_anggaran">
    @else
        <input type="file" class="form-control {{($errors->first('matrik_anggaran') ? ' parsley-error' : '')}}" name="matrik_anggaran" required>
    @endif
    
    @foreach ($errors->get('matrik_anggaran') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
    
    @if (strlen($model['matrik_anggaran'])>1)
        <a href="{{ action('PokController@unduh', ['tindak_lanjut', 'file', $model['matrik_anggaran']]  )}}"><i class=" icon-arrow-down"></i> Unduh File</a>
    @endif
</div>



<br>
<button type="submit" class="btn btn-primary">Simpan</button>