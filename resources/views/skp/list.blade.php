<form action="{{action('CkpController@print')}}" method="post">
    @csrf 
    <input type="hidden"  v-model="skp_id" name="skp">
    <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak SKP Target &nbsp</button>
    <span class="float-right">&nbsp &nbsp</span>
    <button name="action" class="float-right" type="submit" value="1"><i class="icon-printer"></i>&nbsp Cetak SKP Pengukuran &nbsp</button>
</form>
<br/><br/>


<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#utama">TARGET</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#penilaian">PENGUKURAN</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane show active" id="utama">
        <div class="table-responsive">
            

            <table class="table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td>NO</td>
                        <td colspan="2">I. PEJABAT PENILAI</td>
                        <td>NO</td>
                        <td colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</td>
                    </tr>
                    
                    <tr>
                        <td>1</td>
                        <td>Nama</td>
                        <td>{{  }}</td>
                        <td>NO</td>
                        <td colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</td>
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
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                          
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
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
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
                        
                        <tr>
                            <td colspan="5"><b>CAPAIAN KINERJA PEGAWAI (CKP)</b></td>
                            <td class="text-center" colspan="2">@{{ ((Number(total_kuantitas)+Number(total_kualitas))/2).toFixed(2) }}</td>
                            <td colspan="9"></td>
                        </tr>
                    </template>

                </tbody>

                
            </table>
        </div>


    </div>
    
    <div class="tab-pane" id="penilaian">
        <div class="table-responsive">
            <table class="table-sm table-bordered m-b-0">
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
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
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
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>@{{ data.iki_label }}</td>
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
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        skp_induk: null,
        skp_pengukuran: [],
        skp_target: [],
        tanggal_mulai: '',
        tanggal_selesai: '',
        pathname : window.location.pathname,
    },
    computed: {
        
    },
    watch: {
        tanggal_mulai: function (val) {
            this.setDatas();
        },
        tanggal_selesai: function (val) {
            this.setDatas();
        }
    },
    methods: {
        nilaiRata2: function(val1, val2, val3){
            if(typeof val1 == 'undefined' || val1 == '' || val1 == null) val1 = 0;
            if(typeof val2 == 'undefined' || val2 == '' || val2 == null) val2 = 0;
            if(typeof val3 == 'undefined' || val3 == '' || val3 == null) val3 = 0;

            return ((parseInt(val1)+parseInt(val2)+parseInt(val3))/3).toFixed(2);
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