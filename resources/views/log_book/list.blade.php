<div class="table-responsive">
    <table class="table table-sm table-bordered m-b-0">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">{{ $model->attributes()['tanggal'] }}</th>
                <th class="text-center">Mulai</th>
                <th class="text-center">Selesai</th>
                <th class="text-center">{{ $model->attributes()['isi'] }}</th>
                <th class="text-center">{{ $model->attributes()['hasil'] }}</th>
                <th class="text-center">{{ $model->attributes()['catatan_pimpinan'] }}</th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>@{{ index+1 }}</td>
                <td class="text-center">@{{ data.tanggal }}</td>
                <td class="text-center">@{{ data.waktu_mulai }}</td>
                <td class="text-center">@{{ data.waktu_selesai }}</td>
                <td>@{{ data.isi }}</td>
                <td>@{{ data.hasil }}</td>
                <td>@{{ data.catatan_approve }}</td>
            </tr>
        </tbody>
    </table>
</div>

@include('log_book.modal_form')

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


@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">

  
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
    </style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
    
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
        start: {!! json_encode($start) !!},
        end: {!! json_encode($end) !!},
        pathname : window.location.pathname,
        form_id: 0, form_tanggal: '', form_waktu_mulai: '', form_waktu_selesai: '',
        form_isi: '', form_hasil: '', form_catatan_pimpinan: '',
    },
    methods: {
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : self.pathname+"/data_log_book",
                method : 'post',
                dataType: 'json',
                data:{
                    start: self.start, 
                    end: self.end, 
                },
            }).done(function (data) {
                self.datas = data.datas;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        }
    }
});

$(document).ready(function() {
    vm.setDatas();
});

$('#start').change(function() {
    vm.start = this.value;
    vm.setDatas();
});


$('#end').change(function() {
    vm.end = this.value;
    vm.setDatas();
});
</script>
@endsection