<div class="form-group">
    <label>{{ $model->attributes()['judul']}}:</label>
    <input type="text" class="form-control {{($errors->first('judul') ? ' parsley-error' : '')}}" name="judul" value="{{ old('judul', $model->judul) }}">
    @foreach ($errors->get('judul') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>  

<div class="form-group">
    <label>{{ $model->attributes()['deskripsi']}}:</label>
    <textarea id="deskripsi" class="summernote form-control {{($errors->first('deskripsi') ? ' parsley-error' : '')}}" name="deskripsi" value="{{ old('deskripsi', $model->deskripsi) }}" rows="10"></textarea>
    @foreach ($errors->get('deskripsi') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>


<div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group demo-masked-input">
                <label>{{ $model->attributes()['waktu_mulai']}}:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="text" class="form-control datetime {{($errors->first('waktu_mulai') ? ' parsley-error' : '')}}" name="waktu_mulai" value="{{ old('waktu_mulai', $model->waktu_mulai) }}"  placeholder="Ex: 30-07-2019 23:59">
                </div>
                @foreach ($errors->get('waktu_mulai') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        
        <div class="col-md-6 left">
            <div class="form-group demo-masked-input">
                <label>{{ $model->attributes()['waktu_selesai']}}:</label>
                
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                    </div>
                    <input type="text" class="form-control datetime {{($errors->first('waktu_selesai') ? ' parsley-error' : '')}}" name="waktu_selesai" value="{{ old('waktu_selesai', $model->waktu_selesai) }}"  placeholder="Ex: 30-07-2019 23:59">
                    <!-- <input type="text" class="form-control datetime" placeholder="Ex: 30/07/2016 23:59"> -->
                </div>

                @foreach ($errors->get('waktu_selesai') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

<div class="form-group">
    <label>{{ $model->attributes()['notulen']}}:</label>
    <textarea id="notulen" class="summernote form-control {{($errors->first('notulen') ? ' parsley-error' : '')}}" name="notulen" value="{{ old('notulen', $model->notulen) }}" rows="10"></textarea>
    @foreach ($errors->get('notulen') as $msg)
        <p class="text-danger">{{ $msg }}</p>
    @endforeach
</div>

<div class="form-group">
    <label>{{ $model->attributes()['keterangan']}}:</label>
    <textarea id="keterangan" class="summernote form-control {{($errors->first('keterangan') ? ' parsley-error' : '')}}" name="keterangan" value="{{ old('keterangan', $model->keterangan) }}" rows="10"></textarea>
    @foreach ($errors->get('keterangan') as $msg)
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
    <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
    <script src="{!! asset('lucid/assets/vendor/jquery.maskedinput/jquery.maskedinput.min.js') !!}"></script>
    <script>
        $(function() {
            var initDeskripsi = {!! json_encode(old('deskripsi', $model->deskripsi)) !!};
            $('#deskripsi').summernote('code', initDeskripsi);
            
            var initNotulen = {!! json_encode(old('notulen', $model->notulen)) !!};
            $('#notulen').summernote('code', initNotulen);
            
            var initKeterangan = {!! json_encode(old('keterangan', $model->keterangan)) !!};
            $('#keterangan').summernote('code', initKeterangan);
            
        });

        $(document).ready(function() {
            var $demoMaskedInput = $('.demo-masked-input');
            $demoMaskedInput.find('.datetime').inputmask('d-m-y h:s', { placeholder: '__-__-____ __:__', alias: "datetime", hourFormat: '24' });
        });
    </script>
@endsection