<div class="row clearfix">      
    <div class="col-lg-6 col-md-12 left-box">
        <div class="form-group">
            <label>Pilih SKP yang diperbaharui:</label>
            <div class="input-group">
                <select class="form-control  form-control-sm" v-model="skp_id">
                    <option value="0">BUAT SKP BARU</option>
                    @foreach ($skp_induk as $key=>$value)
                        <option value="{{ $value->id }}">{{ date('d M Y', strtotime($value->tanggal_mulai)) }} - {{ date('d M Y', strtotime($value->tanggal_selesai)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix">  
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#target">TARGET</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pengukuran">PENGUKURAN</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active" id="target">   
            <label>Rentang Waktu SKP</label>                                 
            <div class="input-daterange input-group" data-provide="datepicker">
                <input type="text" class="input-sm form-control" id="tanggal_mulai">
                <span class="input-group-addon">to</span>
                <input type="text" class="input-sm form-control" id="tanggal_selesai">
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table-sm table-bordered m-b-0" style="min-width:100%">
                    <thead>
                        <tr>
                            <th>NO</th><th colspan="2">I. PEJABAT PENILAI</th>
                            <th>NO</th><th colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nama</td>
                            <td>
                                <select class="form-control form-control-sm" v-model="skp_induk.pimpinan_id" id="pimpinan_id" @change="setPimpinan">
                                    <option v-for="(data, index) in list_pegawai" :key="data.id" :value="data.email">@{{ data.name }}</option>
                                </select>
                            </td>
                            <td>1</td>
                            <td colspan="2">Nama</td>
                            <td colspan="4">
                            
                                <select class="form-control form-control-sm" disabled v-model="skp_induk.user_id">
                                    <option v-for="(data, index) in list_pegawai" :key="data.id" :value="data.email">@{{ data.name }}</option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>2</td>
                            <td>NIP</td>
                            <td>@{{ pimpinan_nip }}</td>
                            <td>2</td>
                            <td colspan="2">NIP</td>
                            <td colspan="4">@{{ user_nip }}</td>
                        </tr>
                        
                        <tr>
                            <td>3</td>
                            <td>Pangkat/Gol. Ruang</td>
                            <td> @{{ skp_induk.pimpinan_pangkat }} / @{{ skp_induk.pimpinan_gol }} </td>
                            <td>3</td>
                            <td colspan="2">Pangkat/Gol. Ruang</td>
                            <td colspan="4">@{{ skp_induk.user_pangkat }} / @{{ skp_induk.user_gol }} </td>
                        </tr>
                        
                        <tr>
                            <td>4</td>
                            <td>Jabatan</td>
                            <td>@{{ skp_induk.pimpinan_jabatan }}</td>
                            <td>4</td>
                            <td colspan="2">Jabatan</td>
                            <td colspan="4">@{{ skp_induk.user_jabatan }}</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Unit Kerja</td>
                            <td>@{{ skp_induk.pimpinan_unit_kerja }}</td>
                            <td>5</td>
                            <td colspan="2">Unit Kerja</td>
                            <td colspan="4">@{{ skp_induk.user_unit_kerja }}</td>
                        </tr>

                        <tr class="text-center">
                            <th rowspan="2">NO</th>
                            <th rowspan="2" colspan="2">III. KEGIATAN TUGAS JABATAN</th>
                            <th rowspan="2">AK</th>
                            <th colspan="6">TARGET</th>
                        </tr>
                        
                        <tr class="text-center">
                            <th colspan="2">KUANT/OUTPUT</th>
                            <th>KUAL/MUTU</th>
                            <th colspan="2">WAKTU</th>
                            <th>BIAYA</th>
                        </tr>
                        
                        <tr class="text-center">
                            <td colspan="10"><button class="btn btn-info" @click="addTarget">Tambah Rincian</button></td>
                        </tr>

                        <tr v-for="(data, index) in skp_target" :key="index">
                            <td>@{{ index+1 }}</td>
                            <td colspan="2"><input type="text" class="form-control" v-model="data.uraian" /></td>
                            <td>@{{ data.kode_point_kredit }}</td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.target_kuantitas" /></td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.satuan" /></td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.target_kualitas" /></td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.waktu" /></td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.satuan_waktu" /></td>
                            <td class="text-center"><input type="text" class="form-control" v-model="data.biaya" /></td>
                        </tr>
                    </tbody>
                </table>
                <br/>
                <button class="btn btn-success float-right" @click="saveTarget">SIMPAN</button>
            </div>
        </div>
        
        <div class="tab-pane" id="pengukuran">
            <div class="table-responsive">
                <button class="btn btn-info" @click="addPengukuran">Tambah Rincian</button>
                <br/><br/>
                <table class="table table-sm table-bordered m-b-0" style="min-width:200%">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th class="text-center" rowspan="2">I. Kegiatan Tugas Jabatan</th>
                            <th rowspan="2">AK</th>
                            <th class="text-center" colspan="6">TARGET</th>
                            <th rowspan="2">AK</th>
                            <th class="text-center" colspan="6">REALISASI</th>
                            <th rowspan="2">PENGHITUNGAN</th>
                            <th class="text-center" rowspan="2">NILAI CAPAIAN SKP</th>
                        </tr>

                        <tr class="text-center">
                            <td colspan="2">Kuant/Output</td>
                            <td>Kual/Mutu</td>
                            <td colspan="2">Waktu</td>
                            <td>Biaya</td>
                            
                            <td colspan="2">Kuant/Output</td>
                            <td>Kual/Mutu</td>
                            <td colspan="2">Waktu</td>
                            <td>Biaya</td>
                        </tr>
                        
                        <tr class="text-center">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td colspan="2">4</td>
                            <td>5</td>
                            <td colspan="2">6</td>
                            <td>7</td>
                            <td>8</td>
                            <td colspan="2">9</td>
                            <td>10</td>
                            <td colspan="2">11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(data, index) in skp_pengukuran" :key="'pengukuran'+index">
                            <td>@{{ index+1 }}</td>
                            <td><input type="text" class="form-control form-control" v-model="data.uraian"></td> 

                            <td>..</td>
                            <td><input type="number" class="form-control form-control-sm" size="8" v-model="data.target_kuantitas"></td>
                            <td><input type="text" class="form-control form-control-sm" v-model="data.target_satuan"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.target_kualitas"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.target_waktu"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.target_satuan_waktu"></td>
                            <td><input type="text" class="form-control form-control-sm" v-model="data.target_biaya"></td>
                            
                            <td>..</td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.realisasi_kuantitas"></td>
                            <td><input type="text" class="form-control form-control-sm" v-model="data.realisasi_satuan"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.realisasi_kualitas"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.realisasi_waktu"></td>
                            <td><input type="text" class="form-control form-control-sm" size="1" v-model="data.realisasi_satuan_waktu"></td>
                            <td><input type="text" class="form-control form-control-sm" v-model="data.realisasi_biaya"></td>

                            <td>@{{ data.penghitungan }}</td>
                            <td>@{{ data.nilai_capaian_skp }}</td>
                        </tr>
                    </tbody>
                </table>
                
                <br/>
                <button class="btn btn-success float-right" @click="savePengukuran">SIMPAN</button>
            </div>
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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        list_skp: {!! json_encode($skp_induk) !!},
        list_pegawai: {!! json_encode($list_pegawai) !!},
        list_pangkat: {!! json_encode($list_pangkat) !!},
        cur_user_id :  {!! json_encode($cur_user_id) !!}, 
        skp_id: 0,
        skp_induk: {
            'id': null,
            'tanggal_mulai': null,
            'tanggal_selesai': null,
            'user_id': null,
            'user_pangkat': null,
            'user_gol': null,
            'user_jabatan': null,
            'user_unit_kerja': null,
            'pimpinan_id': null,
            'pimpinan_pangkat': null,
            'pimpinan_gol': null,
            'pimpinan_jabatan': null,
            'pimpinan_unit_kerja': null,
            'versi': null,
            'created_at': null,
            'updated_at': null,
        },
        pimpinan_nip: '', user_nip: '',
        skp_pengukuran: [],
        skp_target: [],
        tanggal_mulai: '',
        tanggal_selesai: '',
        pathname : window.location.pathname.replace("/create", ""),
    },
    watch: {
        skp_id: function (val) {
            this.setDatas();
        },
    },
    methods: {
        setSkpId: function(){
            if(this.list_skp.length>0) this.skp_id = this.list_skp[0].id
            else this.skp_id = 0
        },
        setDatas: function(){
            var self = this
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') }
            })
            $.ajax({
                url : self.pathname+ "/" + self.skp_id + "/data_skp",
                method : 'get',
                dataType: 'json',
            }).done(function (data) {
                if(data.datas.skp_induk!=null){
                    self.skp_induk = data.datas.skp_induk;
                    self.skp_pengukuran = data.datas.skp_pengukuran;
                    self.skp_target = data.datas.skp_target;
                    
                    $('#tanggal_mulai').val(self.changeDateFormat(self.skp_induk.tanggal_mulai))
                    $('#tanggal_selesai').val(self.changeDateFormat(self.skp_induk.tanggal_selesai))
                    
                    let cur_pegawai = self.list_pegawai.find( ({ email }) => email ==self.skp_induk.pimpinan_id);
                    self.skp_induk.pimpinan_pangkat = self.list_pangkat[cur_pegawai.nmgol.replace(" ", "")]
                    self.skp_induk.pimpinan_gol = cur_pegawai.nmgol
                    self.skp_induk.pimpinan_jabatan = cur_pegawai.nmjab 
                    self.skp_induk.pimpinan_unit_kerja = cur_pegawai.nmorg
                    self.skp_induk.pimpinan_id = cur_pegawai.email
                    self.pimpinan_nip = cur_pegawai.nip_baru
                }
                else{
                    self.skp_induk = {'id': null,
                        'tanggal_mulai': null, 'tanggal_selesai': null,
                        'pimpinan_id': null, 'pimpinan_pangkat': null, 'pimpinan_gol': null,
                        'pimpinan_jabatan': null, 'pimpinan_unit_kerja': null,
                        'versi': null, 'created_at': null,'updated_at': null};

                    self.skp_pengukuran = []
                    self.skp_target = []
                    
                    $('#tanggal_mulai').val("")
                    $('#tanggal_selesai').val("")
                }
                
                self.setUser();
                
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setPimpinan: function(e){
            // console.log(e.target.selectedIndex)
            let cur_pegawai = this.list_pegawai[e.target.selectedIndex]
            this.skp_induk.pimpinan_pangkat = this.list_pangkat[cur_pegawai.nmgol.replace(" ", "")]
            this.skp_induk.pimpinan_gol = cur_pegawai.nmgol
            this.skp_induk.pimpinan_jabatan = cur_pegawai.nmjab 
            this.skp_induk.pimpinan_unit_kerja = cur_pegawai.nmorg
            this.skp_induk.pimpinan_id = cur_pegawai.email
            this.pimpinan_nip = cur_pegawai.nip_baru
        },
        setUser: function(){
            let cur_pegawai = this.list_pegawai.find( ({ email }) => email ==this.cur_user_id);
            this.skp_induk.user_pangkat = this.list_pangkat[cur_pegawai.nmgol.replace(" ", "")]
            this.skp_induk.user_gol = cur_pegawai.nmgol
            this.skp_induk.user_jabatan = cur_pegawai.nmjab 
            this.skp_induk.user_unit_kerja = cur_pegawai.nmorg
            this.skp_induk.user_id = this.cur_user_id;
            this.user_nip = cur_pegawai.nip_baru
        },
        addTarget: function(){
            this.skp_target.push({
                'id' : '', 'id_induk' : '', 'user_id': '',
                'uraian': '', 'satuan': '', 'target_kuantitas': '',
                'kode_point_kerdit': '', 'angka_kredit': '', 'target_kualitas': '',
                'waktu': '', 'satuan_waktu': '', 'biaya': '', 'jenis': '',
                'created_by': '', 'updated_by': '', 'created_at': '', 'updated_at': '',
            });
        },
        addPengukuran: function(){
            this.skp_pengukuran.push({
                'id' : '', 'id_induk' : '', 'user_id': '',
                'uraian': '', 'kode_point_kredit': '', 
                'target_satuan': '', 'target_kuantitas': '','target_kualitas': '','target_waktu': '','target_satuan_waktu': '','target_biaya': '','target_angka_kredit': '',
                'realisasi_satuan': '', 'realisasi_kuantitas': '','realisasi_kualitas': '','realisasi_waktu': '','realisasi_satuan_waktu': '','realisasi_biaya': '','realisasi_angka_kredit': '',
                'penghitungan': '', 'nilai_capaian_skp': '', 'jenis': '',
                'created_by': '', 'updated_by': '', 'created_at': '', 'updated_at': '',
            });
        },
        saveTarget: function(){
            var self = this
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + "/store_target",
                method : 'post',
                dataType: 'json',
                data:{
                    skp_id: self.skp_id,
                    skp_induk: self.skp_induk,
                    skp_target: self.skp_target,
                },
            }).done(function (data) {
                // console.log(data.success)
                window.location = self.pathname
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        savePengukuran: function(){
            var self = this
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + "/store_target",
                method : 'post',
                dataType: 'json',
                data:{
                    skp_id: self.skp_id,
                    skp_induk: self.skp_induk,
                    skp_pengukuran: self.skp_pengukuran,
                },
            }).done(function (data) {
                window.location = self.pathname
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        changeDateFormat: function(label){
            var mydate = new Date(label);
            return (mydate.getMonth()+1)+"/"+mydate.getDate()+"/"+mydate.getFullYear();
        }
    }
});

$('#tanggal_mulai').change(function() {
    vm.skp_induk.tanggal_mulai = this.value;
});

$('#tanggal_selesai').change(function() {
    vm.skp_induk.tanggal_selesai = this.value;
});

    $(document).ready(function() {
        vm.setUser();
        vm.setSkpId();
        // vm.setDatas();
    });
</script>
@endsection