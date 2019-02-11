<div class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">{{ $model->attributes()['tanggal'] }}</th>
                <th class="text-center">{{ $model->attributes()['isi'] }}</th>

                <th class="text-center">{{ $model->attributes()['is_approve'] }}</th>
                <th class="text-center"></th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>@{{ index+1 }}</td>
                <td>@{{ data.tanggal }}</td>
                <td v-html="data.isi"></td>
                <td class="text-center"  v-if="data.is_approve==0">belum disetujui</td>
                <td class="text-center"  v-else>sudah disetujui</td>

                <td>
                    <a :href="url_log_book+'/'+data.id+'/edit'"><i class="icon-pencil text-info"></i></a>    
                    <a :href="url_log_book+'/'+data.id+''"><i class="fa fa-search text-default"></i></a>    
            
                </td>
            </tr>
        </tbody>
    </table>
</div>


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
      url_log_book: window.location.pathname,
      pathname : window.location.pathname,
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
                // url : "{{ url('/log_book/data_log_book/') }}",
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