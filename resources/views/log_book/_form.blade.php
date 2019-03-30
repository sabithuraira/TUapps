<div id="app_vue">
    <div class="form-group">
        <label>{{ $model->attributes()['tanggal'] }}:</label>
        
        <div class="input-group date" data-date-autoclose="true" data-provide="datepicker">
            <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" id="tanggal" name="tanggal" value="{{ old('tanggal', date('m/d/Y', strtotime($model->tanggal))) }}">
            <div class="input-group-append">                                            
                <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
            </div>
        </div>
        
        @foreach ($errors->get('tanggal') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
        
    </div>

    <div class="form-group">
        <label>{{ $model->attributes()['waktu'] }}:</label>
        <select class="form-control {{($errors->first('waktu') ? ' parsley-error' : '')}}"  name="waktu">
            @foreach ($item_waktu as $iwaktu)
                <option  value="{{ $iwaktu['id'] }}" 
                    @if ($iwaktu['id'] == old('waktu', $model->waktu))
                        selected="selected"
                    @endif>
                    {{ $iwaktu['waktu'] }}
                </option>
            @endforeach
        </select>
        @foreach ($errors->get('waktu') as $msg)<p class="text-danger">{{ $msg }}</p>@endforeach
    </div>

    <div class="form-group">
        <label>{{ $model->attributes()['isi'] }}:</label>
        <textarea id="isi" class="summernote form-control {{($errors->first('isi') ? ' parsley-error' : '')}}" name="isi" value="{{ old('isi', $model->isi) }}" data-provide="markdown" rows="10"></textarea>
        @foreach ($errors->get('isi') as $msg)
            <p class="text-danger">{{ $msg }}</p>
        @endforeach
    </div>

    <div class="form-group">
        <label>{{ $model->attributes()['flag_ckp'] }}:</label>
        <select class="form-control {{($errors->first('flag_ckp') ? ' parsley-error' : '')}}"  name="flag_ckp">
            <option value=''>Pilih CKP</option>
            <option v-for="(data, index) in list_ckp" :value="data.id" :key="data.id">
                @{{ data.uraian }}
            </option>
        </select>
        @foreach ($errors->get('waktu') as $msg)<p class="text-danger">{{ $msg }}</p>@endforeach
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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    $(function() {
        var initContent = {!! json_encode($model->isi) !!};
        $('#isi').summernote('code', initContent);
    });

    var vm = new Vue({  
        el: "#app_vue",
        data:  {
            list_ckp: [],
            month: new Date().getMonth() + 1,
            year: new Date().getFullYear(),
            pathname : window.location.pathname,
        },
        methods: {
            setCkp: function(){
                var self = this;
                console.log(self.month);
                console.log(self.year);

                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : "{{ url('/ckp/data_ckp/') }}", //self.pathname+"/data_ckp",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        month: self.month, 
                        year: self.year, 
                        type: 1,
                    },
                }).done(function (data) {
                    self.list_ckp = data.datas.utama;
                    // self.list_ckp.concat(data.datas.tambahan);
                    for(i=0;i<data.datas.tambahan.length;++i){
                        self.list_ckp.push(data.datas.tambahan[i]);
                    }
                    
                    console.log(self.list_ckp);

                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
        }
    });


    $('#tanggal').change(function() {
        var tanggal = this.value;
        vm.month = new Date(tanggal).getMonth() + 1;
        vm.year = new Date(tanggal).getFullYear(); //String(event.date).split(" ")[3];

        vm.setCkp();
    });

    $(document).ready(function() {
        console.log("hai");
        console.log(vm.month);
        vm.setCkp();
    });
</script>
@endsection