<form action="{{action('CkpController@print')}}" method="post">
    @csrf 
    <input type="hidden"  v-model="type" name="p_type">
    <input type="hidden"  v-model="month" name="p_month">
    <input type="hidden"  v-model="year" name="p_year">
    <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak CKP-R &nbsp</button>
    <span class="float-right">&nbsp &nbsp</span>
    <button name="action" class="float-right" type="submit" value="1"><i class="icon-printer"></i>&nbsp Cetak CKP-T &nbsp</button>
</form>
<br/><br/>


<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#utama">UTAMA</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#penilaian">PENILAIAN</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane show active" id="utama">

        <div class="table-responsive">
            <table class="table table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $model->attributes()['uraian'] }}</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['satuan'] }}</td>
                        
                        <td class="text-center" colspan="3">Kuantitas</td>
                        <td class="text-center" rowspan="2">Tingkat Kualitas</td>
                        
                        <td class="text-center" rowspan="2">{{ $model->attributes()['kode_butir'] }}</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['angka_kredit'] }}</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['keterangan'] }}</td>
                    </tr>

                    <tr>
                        <td class="text-center" >Target</td>
                        <td class="text-center" >Realisasi</td>
                        <td class="text-center" >%</td>
                    </tr>
                </thead>

                <tbody>
                    <tr><td colspan="10">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                        <td class="text-center">@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>
                    
                    <tr><td colspan="10">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td class="text-center">@{{ (data.realisasi_kuantitas/data.target_kuantitas)*100 }} %</td>
                        <td class="text-center">@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>

                    <template>
                        <tr>
                            <td colspan="5"><b>JUMLAH</b></td>
                            <td class="text-center">@{{ total_kuantitas }} %</td>
                            <td class="text-center">@{{ total_kualitas }} %</td>
                            

                            <td colspan="9"></td>
                        </tr>
                    </template>

                </tbody>

                
            </table>
        </div>


    </div>
    
    <div class="tab-pane" id="penilaian">
    

        <div class="table-responsive">
            <table class="table table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $model->attributes()['uraian'] }}</td>
                        
                        <td class="text-center" colspan="5">Pengukuran</td>
                        <td class="text-center" rowspan="2">Catatan Koreksi</td>
                        <td class="text-center" rowspan="2">IKI</td>
                    </tr>

                    <tr>
                        <td class="text-center">Kecepatan</td>
                        <td class="text-center">Ketuntasan</td>
                        <td class="text-center">Ketepatan</td>
                        <td class="text-center">rata2</td>
                        <td class="text-center">Penilaian Pimpinan</td>
                    </tr>
                </thead>

                <tbody>
                    <tr><td colspan="9">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td> 
                        <td>@{{ data.kecepatan }}</td>
                        <td>@{{ data.ketepatan }}</td>
                        <td>@{{ data.ketuntasan }}</td>
                        <td>@{{ (data.kecepatan+data.ketepatan+data.ketuntasan)/3 }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>
                            <span>@{{ data.iki_label }}</span>
                        </td>
                    </tr>
                    
                    <tr><td colspan="9">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        
                        <td>@{{ data.kecepatan }}</td>
                        <td>@{{ data.ketepatan }}</td>
                        <td>@{{ data.ketuntasan }}</td>
                        <td>@{{ (data.kecepatan+data.ketepatan+data.ketuntasan)/3 }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>@{{ data.iki }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
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
    
    <style type="text/css">
        * {font-family: Segoe UI, Arial, sans-serif;}
        table{font-size: small;border-collapse: collapse;}
        tfoot tr td{font-weight: bold;font-size: small;}
    </style>
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
                // console.log(this.kegiatan_utama[i].kualitas);
                if(typeof this.kegiatan_utama[i].kualitas !== 'undefined' && this.kegiatan_utama[i].kualitas!=null && this.kegiatan_utama[i].kualitas!='') 
                    result+= parseInt(this.kegiatan_utama[i].kualitas);
            }
            
            for(i=0;i<this.kegiatan_tambahan.length;++i){
                // console.log(this.kegiatan_tambahan[i].kualitas);
                if(typeof this.kegiatan_tambahan[i].kualitas !== 'undefined' && this.kegiatan_tambahan[i].kualitas!=null && this.kegiatan_tambahan[i].kualitas!='')
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

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
    }
});

    $(document).ready(function() {
        vm.setDatas();
    });
</script>
@endsection