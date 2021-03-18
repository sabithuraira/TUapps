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

            <template v-if="type==2">
                <tr>
                    <td colspan="5"><h4>JUMLAH</h4></td>
                    <td class="text-center">@{{ total_kuantitas }} %</td>
                    <td class="text-center">@{{ total_kualitas }} %</td>
                    

                    <td colspan="3"></td>
                </tr>
            </template>

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
    //   total_kuantitas: 0,
    //   total_kualitas: 0,
    },
    computed: {
        total_column: function () {
            if(this.type==1)
                return 7;
            else
                return 10;
        },
        total_kuantitas: function(){
            var result = 0;

            for(i=0;i<this.kegiatan_utama.length;++i){
                if(typeof this.kegiatan_utama[i].target_kuantitas !== 'undefined') 
                    result+= (this.kegiatan_utama[i].realisasi_kuantitas/this.kegiatan_utama[i].target_kuantitas*100)
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                if(typeof this.kegiatan_tambahan[i].target_kuantitas !== 'undefined')
                    result+= (this.kegiatan_tambahan[i].realisasi_kuantitas/this.kegiatan_tambahan[i].target_kuantitas*100)
            }

            return parseFloat(result/(this.kegiatan_utama.length+this.kegiatan_tambahan.length)).toFixed(2);
        },
        total_kualitas: function(){
            var result = 0;

            for(i=0;i<this.kegiatan_utama.length;++i){
                if(typeof this.kegiatan_utama[i].kualitas !== 'undefined') 
                    result+= parseInt(this.kegiatan_utama[i].kualitas);
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                if(typeof this.kegiatan_tambahan[i].kualitas !== 'undefined')
                    result+= parseInt(this.kegiatan_tambahan[i].kualitas);
            }

            return parseFloat(result/(this.kegiatan_utama.length+this.kegiatan_tambahan.length)).toFixed(2);
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

                // var t_kuantitas = 0;
                // var t_kualitas = 0;

                // for(i=0;i<self.kegiatan_utama.length;++i){
                //     // console.log(self.kegiatan_utama[i].kualitas);
                //     if(typeof self.kegiatan_utama[i].target_kuantitas !== 'undefined') 
                //         t_kuantitas+= (self.kegiatan_utama[i].realisasi_kuantitas/self.kegiatan_utama[i].target_kuantitas*100)
                
                //     if(self.kegiatan_utama[i].kualitas != null) 
                //         t_kualitas+= self.kegiatan_utama[i].kualitas;
                // }

                // for(i=0;i<self.kegiatan_tambahan.length;++i){
                //     // console.log(self.kegiatan_tambahan[i].kualitas);
                //     if(typeof self.kegiatan_tambahan[i].target_kuantitas !== 'undefined')
                //         t_kuantitas+= (self.kegiatan_tambahan[i].realisasi_kuantitas/self.kegiatan_tambahan[i].target_kuantitas*100)
                    
                //     if(self.kegiatan_tambahan[i].kualitas != null)
                //         t_kualitas+= self.kegiatan_tambahan[i].kualitas;
                // }

                // console.log(t_kualitas);
                // console.log(t_kuantitas);

                // self.total_kuantitas = t_kuantitas/(self.kegiatan_utama.length+self.kegiatan_tambahan.length);
                // self.total_kualitas = t_kualitas/(self.kegiatan_utama.length+self.kegiatan_tambahan.length);

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