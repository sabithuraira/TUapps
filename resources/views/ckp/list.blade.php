<div class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th class="text-center" rowspan="2">{{ $model->attributes()['uraian'] }}</th>
                <th class="text-center" rowspan="2">{{ $model->attributes()['satuan'] }}</th>
                
                <th v-if="type==1" class="text-center" rowspan="2">Target Kuantitas</th>
                <template v-else>
                    <th class="text-center" colspan="3">Kuantitas</th>
                    <th class="text-center" rowspan="2">Tingkat Kualitas</th>
                </template>

                <th class="text-center" rowspan="2">{{ $model->attributes()['kode_butir'] }}</th>
                <th class="text-center" rowspan="2">{{ $model->attributes()['angka_kredit'] }}</th>
                <th class="text-center" rowspan="2">{{ $model->attributes()['keterangan'] }}</th>
            </tr>

            <tr v-show="type!=1">
                <th class="text-center" >Target</th>
                <th class="text-center" >Realisasi</th>
                <th class="text-center" >%</th>
            </tr>
        </thead>

        <tbody>
            <tr><td :colspan="total_column">UTAMA</td></tr>
            <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                <td>@{{ index+1 }}</td>
                <td>@{{ data.uraian }}</td>
                <td>@{{data.satuan }}</td>
                <td>@{{data.target_kuantitas }}</td>
                
                <template v-if="type==2">
                    <td>@{{ data.realisasi_kuantitas }}</td>
                    <td>%</td>
                    <td>@{{ data.kualitas }}</td>
                </template>

                <td>@{{ data.kode_butir }}</td>
                <td>@{{ data.angka_kredit }}</td>
                <td>@{{ data.keterangan }}</td>
            </tr>
            
            <tr><td :colspan="total_column">TAMBAHAN</td></tr>
            <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                <td>@{{ index+1 }}</td>
                <td>@{{ data.uraian }}</td>
                <td>@{{data.satuan }}</td>
                <td>@{{data.target_kuantitas }}</td>
                
                <template v-if="type==2">
                    <td>@{{ data.realisasi_kuantitas }}</td>
                    <td>%</td>
                    <td>@{{ data.kualitas }}</td>
                </template>

                <td>@{{ data.kode_butir }}</td>
                <td>@{{ data.angka_kredit }}</td>
                <td>@{{ data.keterangan }}</td>
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
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      kegiatan_utama: [],
      kegiatan_tambahan: [],
      type: 1,
      month: parseInt({!! json_encode($month) !!}),
      year: {!! json_encode($year) !!},
      total_utama: 1,
      total_tambahan: 1,
    },
    computed: {
        total_column: function () {
            if(this.type==1)
                return 7;
            eles
                return 10;
        }
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
                url : "{{ url('/ckp/data_ckp/') }}",
                method : 'post',
                dataType: 'json',
                data:{
                    month: self.month, 
                    year: self.year, 
                    type: self.type,
                },
            }).done(function (data) {
                self.kegiatan_utama = data.datas.utama;
                self.kegiatan_tambahan = data.datas.tambahan;


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


    $('#month').change(function() {
        vm.setDatas();
    });

    $('#year').change(function() {
        vm.setDatas();
    });
  
    $('#type').change(function() {
        vm.setDatas();
    });
</script>
@endsection