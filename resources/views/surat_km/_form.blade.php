<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['jenis_surat'] }}:</label>
                <select class="form-control {{($errors->first('jenis_surat') ? ' parsley-error' : '')}}" v-model="jenis_surat" name="jenis_surat" @change="setNomor">
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
                <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                    <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" id="tanggal" v-model="tanggal">
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
                <select class="form-control {{($errors->first('nomor_petunjuk') ? ' parsley-error' : '')}}" name="nomor_petunjuk">
                    <option value="">- Pilih Jenis Surat -</option>
                    @foreach ($model->listPetunjuk as $key=>$value)
                        <option value="{{ $key }}" 
                            @if ($key == old('nomor_petunjuk', $model->nomor_petunjuk))
                                selected="selected"
                            @endif >{{ $value }} - {{ $key }}</option>
                    @endforeach
                </select>
                @foreach ($errors->get('nomor_petunjuk') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        
        <div v-show="jenis_surat==1" class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['nomor'] }}:</label>
                <input type="text" class="form-control {{($errors->first('nomor') ? ' parsley-error' : '')}}" name="nomor" value="{{ old('nomor', $model->nomor) }}">
                @foreach ($errors->get('nomor') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>{{ $model->attributes()['nomor_urut'] }}:</label>
                <input type="text" class="form-control {{($errors->first('nomor_urut') ? ' parsley-error' : '')}}" name="nomor_urut"  v-model="nomor_urut">
                <p class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</p>
                @foreach ($errors->get('nomor_urut') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        
        <div class="col-md-6 left">
            <div class="form-group">
                <label>{{ $model->attributes()['alamat'] }}:</label>
                <input type="text" class="form-control {{($errors->first('alamat') ? ' parsley-error' : '')}}" name="alamat" value="{{ old('alamat', $model->alamat) }}">
                @foreach ($errors->get('alamat') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Simpan</button>

    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                    <h4 class="text-center">Please wait...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data:  {
        jenis_surat: {!! json_encode($model->jenis_surat) !!},
        tanggal: {!! json_encode(date('m/d/Y', strtotime($model->tanggal))) !!},
        nomor_urut: {!! json_encode($model->nomor_urut) !!},
        pathname : (window.location.pathname).replace("/create", ""),
    },
    methods: {
        setNomor: function(){
            var self = this;
            $('#wait_progres').modal('show');
            console.log(self.tanggal);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                url :  "{{ url('/surat_km/nomor_urut/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    jenis_surat: self.jenis_surat, 
                    tanggal: self.tanggal,
                },
            }).done(function (data) {
                self.nomor_urut = data.total;

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
    }
});

$(document).ready(function() {
    vm.setNomor();
});

$('.date').datepicker()
    .on('changeDate', function(e) {
        vm.tanggal = $('#tanggal').val();
        vm.setNomor();
});
</script>
@endsection