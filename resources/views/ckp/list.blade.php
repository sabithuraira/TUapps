<div class="table-responsive">

     <form action="{{action('CkpController@print')}}" method="post">
        @csrf 
        <input type="hidden"  v-model="type" name="p_type">
        <input type="hidden"  v-model="month" name="p_month">
        <input type="hidden"  v-model="year" name="p_year">
        <button class="float-right" type="submit"><i class="icon-printer"></i>&nbsp Cetak CKP &nbsp</button>
    </form>
    <br/><br/>
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
                <td class="text-center">@{{data.target_kuantitas }}</td>
                
                <template v-if="type==2">
                    <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                    <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                    <td class="text-center">@{{ data.kualitas }} %</td>
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
                <td class="text-center">@{{data.target_kuantitas }}</td>
                
                <template v-if="type==2">
                    <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                    <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                    <td class="text-center">@{{ data.kualitas }} %</td>
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
      pathname : window.location.pathname,
    },
    computed: {
        total_column: function () {
            if(this.type==1)
                return 7;
            else
                return 10;
        }
    },
    watch: {
        type: function (val) {
            this.setDatas();
        },
        month: function (val) {
            this.setDatas();
        },
        year: function (val) {
            this.setDatas();
        },
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
                url : self.pathname+"/data_ckp",
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
        },
        // cetakCkp: function(){
        //     var self = this;

        //     $('#wait_progres').modal('show');
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //         }
        //     })
        //     $.ajax({
        //         url : self.pathname+"/print",
        //         method : 'post',
        //         dataType: 'json',
        //         data:{
        //             month: self.month, 
        //             year: self.year, 
        //             type: self.type,
        //         },
        //     }).done(function (data) {

        //         $('#wait_progres').modal('hide');
        //     }).fail(function (msg) {
        //         console.log(JSON.stringify(msg));
        //         $('#wait_progres').modal('hide');
        //     });
        // }
    }
});

    $(document).ready(function() {
        vm.setDatas();
    });

    
    // $('#cetak').click(function(e) {
    //         e.preventDefault();
    //     vm.cetakCkp();
    // });
</script>
@endsection