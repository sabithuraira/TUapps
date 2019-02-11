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

<div class="form-group">
    <label>{{ $model->attributes()['isi'] }}:</label>
    <textarea id="isi" class="summernote form-control {{($errors->first('isi') ? ' parsley-error' : '')}}" name="isi" value="{{ old('isi', $model->isi) }}" data-provide="markdown" rows="10"></textarea>
    @foreach ($errors->get('isi') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script>
    $(function() {
        var initContent = {!! json_encode($model->isi) !!};
        $('#isi').summernote('code', initContent);
    });
</script>
@endsection