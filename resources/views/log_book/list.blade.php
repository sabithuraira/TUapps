<div class="table-responsive">
    <table class="table m-b-0">
        <tbody v-for="(data, index) in all_dates" :key="data.val">
            <tr >
                <th colspan="3">
                    @{{ data.label }}
                </th>
            </tr>

            <tr v-for="(data2, index2) in list_times" :key="data2.id">
                <td>
                    <template v-if="getId(data.val, data2.id)!=0">
                        <i v-on:click="redirectEdit" class="text-primary icon-pencil" :data-id="getId(data.val, data2.id)"></i>
                    </template>
                    
                    <template v-if="getId(data.val, data2.id)==0">
                        &nbsp &nbsp &nbsp
                    </template>

                    &nbsp &nbsp &nbsp
                    
                    @{{ data2.waktu }}
                </td>
                <td v-html="showIsi(data.val, data2.id)"></td>
                <td v-html="showKomentar(data.val, data2.id)"></td>
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

<div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span id="myModalLabel">Catatan Pimpinan</span>
            </div>
            
            <div class="modal-body">
                <table class="table table-hover table-bordered table-condensed">
                    <tbody>
                        <tr>
                            <td>
                                <input type="hidden" v-model="id_row"/>
                                <textarea class="form-control" v-model="catatan_approve" data-provide="markdown" rows="10"></textarea>
                            </td>  
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button v-on:click="saveKomentar" class="btn btn-primary" data-dismiss="modal" id="btn-submit">Save changes</button>
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
      all_dates: [],
      list_times: [],
      catatan_approve: '',
      id_row: 0,
    },
    methods: {
        redirectEdit: function(event){
            var self = this;
            if (event) {
                self.id_row = event.currentTarget.dataset.id;
                window.location.replace(self.pathname+"/"+self.id_row+"/edit");
            }
        },
        komentar: function (event) {
            var self = this;
            if (event) {
                self.id_row = event.currentTarget.dataset.id;

                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : self.pathname+"/komentar",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id_row,
                    },
                }).done(function (data) {
                    self.catatan_approve = data.result;
                    $('#wait_progres').modal('hide');
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });

            }
        },
        saveKomentar: function (event) {
            var self = this;
            if (event) {
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : self.pathname+"/save_komentar",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id_row, 
                        catatan_approve: self.catatan_approve,
                    },
                }).done(function (data) {
                    $('#wait_progres').modal('hide');
                    window.location.reload(false); 
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            }
        },
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
                self.all_dates = data.all_dates;
                self.list_times = data.list_times;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        showIsi: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el => (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) 
            {
                result=rowData.isi;
                // console.log(JSON.stringify(rowData));
                if(rowData.flag_ckp!=null){
                    result += '<p><u>';
                    result += '[Referensi CKP: '+rowData.label_ckp + ']';
                    result += '</u></p>';
                }
            }
            else 
            { 
                result = '';
            }

            return result;
        },
        showKomentar: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el =>  (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) result=rowData.catatan_approve;
            else result = '';

            return result;
        },
        getId: function(tanggal, waktu){
            var self = this;
            const rowData = self.datas.find(el =>  (el.tanggal == tanggal && el.waktu == waktu));

            if(rowData!=undefined) result=rowData.id;
            else result = 0;

            return result;
        },
    }
});

$(document).ready(function() {
    vm.setDatas();
});

$('#btn_comment').click(function() {
    $('#form_modal').modal('show');
    vm.id_row = 0;
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