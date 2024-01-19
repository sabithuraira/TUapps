@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">IKI Pegawai</li>
    </ul>
@endsection

@section('content')
    <div id="app_vue">
        <div class="container">
            <br />
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div><br />
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div><br />
            @endif

            <div class="card">
                <div class="body">
                    @if (($auth->hasanyrole('kepegawaian|superadmin') && $request->user) || $request->user == $auth->nip_baru)
                        <a href="#modal_tambah_iki" class="btn btn-info" data-toggle="modal"
                            data-target="#modal_tambah_iki">
                            Tambah
                        </a>
                    @endif
                    <br /><br />
                    <form action="{{ url('iki_pegawai') }}" method="get">
                        <div class="row px-2">
                            <div class="col-8">
                                <label for="" class="label">Pegawai</label>
                                <select name="user" id="user_filter" class="form-control show-tick ms search-select"
                                    required onchange="this.form.submit()">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($user_list as $usr)
                                        <option value="{{ $usr->nip_baru }}"
                                            @if ($request->user == $usr->nip_baru) selected @endif>
                                            {{ $usr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Tahun</label>
                                <select name="tahun" id="tahun_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    @for ($i=2022;$i<=date('Y');$i++) 
                                        <option value="{{ $i }}" @if ($request->tahun==$i) selected="selected" @endif>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="" class="label">Bulan</label>
                                <select name="bulan" id="bulan_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="" selected>Semua</option>
                                    @foreach ($model->namaBulan as $g => $bln)
                                        <option value="{{ ++$g }}"
                                            @if ($request->bulan == $g) selected @endif>{{ $bln }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row px-2">
                        <div class="col table-responsive">
                            <table class="table-bordered" style="font-size: small;width:100%;min-width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">IK</th>
                                        <th rowspan="2">Bulan</th>
                                        <th rowspan="2">Target & Satuan</th>
                                        <th colspan="3">Rincian Logbook</th>
                                    </tr>

                                    <tr>
                                        <th>Isi</th>
                                        <th>Volume</th>
                                        <th>Bukti Dukung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($datas) > 0)
                                        @foreach ($datas as $i => $dt)
                                            @php 
                                                $all_logbook = App\LogBook::where('id_iki', $dt->id)->get();
                                                $total_logbook = count($all_logbook);
                                            @endphp

                                            @if($total_logbook==0)
                                                <tr>
                                                    <td class="text-center">{{  $i+1 }}</td>
                                                    <td class="text-center" style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ik }} </td>
                                                    <td class="text-center">
                                                        {{ config('app.months')[$dt->bulan] }}<br/>
                                                        {{ $dt->tahun }}
                                                    </td>
                                                    <td class="text-center">{{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    <td class="text-center pb-2 pt-2" colspan="3">
                                                        @if ($request->user == $auth->nip_baru)
                                                        <a href="#" role="button" v-on:click="addLogBook"  
                                                            class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-label_iki="{{ $dt->ik }} [{{ config('app.months')[$dt->bulan] }} {{ $dt->tahun }}]"
                                                            data-id_iki="{{ $dt->id }}" 
                                                            data-target="#add_logbooks">
                                                        <i class="fa fa-plus-circle"></i> <span>Log Book</span></a>

                                                        <a class="btn btn-warning btn-sm" href="#modal_edit_iki"
                                                            data-toggle="modal" data-target="#modal_edit_iki"
                                                            data-id_iki="{{ $dt->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            data-satuan = "{{ $dt->satuan }}"
                                                            data-target_iki="{{ $dt->target }}"
                                                            data-bulan="{{ $dt->bulan }}"
                                                            data-tahun="{{ $dt->tahun }}"
                                                            data-id_tim="{{ $dt->id_tim }}"
                                                            data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                            @click="btn_edit_iki($event)">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="#modal_hapus_iki"
                                                            data-toggle="modal" data-target="#modal_hapus_iki"
                                                            data-id_iki="{{ $dt->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            @click="btn_hapus_iki($event)">
                                                            <i class="fa fa-trash"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else 
                                                <tr>
                                                    <td class="text-center" rowspan="{{ $total_logbook+1 }}">{{ $i+1 }}</td>
                                                    <td class="text-center" rowspan="{{ $total_logbook+1 }}" style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ik }} </td>
                                                    <td class="text-center" rowspan="{{ $total_logbook+1 }}">
                                                        {{ config('app.months')[$dt->bulan] }}<br/>
                                                        {{ $dt->tahun }}
                                                    </td>
                                                    <td class="text-center" rowspan="{{ $total_logbook+1 }}">{{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    <td class="text-center pb-2 pt-2" colspan="3">
                                                        @if ($request->user == $auth->nip_baru)
                                                        <a href="#" role="button" v-on:click="addLogBook"  
                                                            class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-label_iki="{{ $dt->ik }} [{{ config('app.months')[$dt->bulan] }} {{ $dt->tahun }}]"
                                                            data-id_iki="{{ $dt->id }}" 
                                                            data-target="#add_logbooks">
                                                        <i class="fa fa-plus-circle"></i> <span>Log Book</span></a>

                                                        <a class="btn btn-warning btn-sm" href="#modal_edit_iki"
                                                            data-toggle="modal" data-target="#modal_edit_iki"
                                                            data-id_iki="{{ $dt->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            data-satuan = "{{ $dt->satuan }}"
                                                            data-target_iki="{{ $dt->target }}"
                                                            data-bulan="{{ $dt->bulan }}"
                                                            data-tahun="{{ $dt->tahun }}"
                                                            data-id_tim="{{ $dt->id_tim }}"
                                                            data-referensi_sumber="{{ $dt->referensi_sumber }}"
                                                            @click="btn_edit_iki($event)">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                        <a class="btn btn-danger btn-sm" href="#modal_hapus_iki"
                                                            data-toggle="modal" data-target="#modal_hapus_iki"
                                                            data-id_iki="{{ $dt->id }}"
                                                            data-ik="{{ $dt->ik }}"
                                                            @click="btn_hapus_iki($event)">
                                                            <i class="fa fa-trash"></i>
                                                        @endif
                                                    </td>
                                                </tr>

                                                @foreach ($all_logbook as $i2 => $dt2)
                                                    <tr>
                                                        <td>{{ $dt2->isi }}</td>
                                                        <td>{{ $dt2->volume }} {{ $dt2->satuan }}</td>
                                                        <td>{{ $dt2->link_bukti_dukung }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif 

                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">Belum ada IKI / Belum pilih pegawai</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('iki_master.modal_form')

        <div class="modal fade" id="modal_tambah_iki" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Tambah IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_tambah_iki" action="{{ url('iki_pegawai') }}" method="POST">
                            @csrf
                            <input type="text" name="nip" id="nip_tambah_iki" 
                                v-model="form_iki.nip" readonly hidden required>
                            <div class="form-group">
                                <label>Nama IK</label>
                                <input type="text" name="ik" v-model="form_iki.nama_iki" 
                                    class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan"  v-model="form_iki.satuan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="text" name="target" v-model="form_iki.target" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_tambah_iki"
                                    v-model="form_iki.tahun"
                                    class="form-control show-tick ms search-select">
                                    <option value="">- Pilih Tahun -</option>
                                    @for ($i=date('Y');$i>=2023;$i--)
                                        <option  value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label> <span class="text-muted">(cek pada bulan yang aktif untuk IKI ini)</span><br/>
                                @foreach ( config('app.months') as $key=>$value)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" v-model="form_iki.bulan" name="bulan[]" type="checkbox" value="{{ $key }}">
                                        <span class="form-check-label">{{ $value }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label> Tim</label>
                                <select name="id_tim" id="id_tim_tambah_iki" v-model="form_iki.tim" 
                                    class="form-control show-tick ms search-select">
                                    @foreach ($tim_user as $tim)
                                        <option value="{{ $tim->id }}"> {{ $tim->nama_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_tambah_iki"
                                    v-model="form_iki.referensi" 
                                    class="form-control show-tick ms search-select">
                                    <option value="">Tidak ada referensi</option>
                                    @foreach ($iki_atasan as $iki_ats)
                                        <option value="{{ $iki_ats->id }}">{{ $iki_ats->ik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_tambah_iki">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_edit_iki" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit IKI</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_edit_iki" method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Nama IK</label>
                                <input type="text" name="ik" v-model="ik_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" v-model="satuan_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="text" name="target" v-model="target_edit_iki" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">- Pilih Tahun -</option>
                                    @for ($i=date('Y');$i>=2023;$i--)
                                        <option  value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">- Pilih Bulan -</option>
                                    @foreach ( config('app.months') as $key=>$value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label> Tim</label>
                                <select name="id_tim" id="id_tim_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    @foreach ($tim_user as $tim)
                                        <option value="{{ $tim->id }}"> {{ $tim->nama_tim }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Tidak ada referensi</option>
                                    @foreach ($iki_atasan as $iki_ats)
                                        <option value="{{ $iki_ats->id }}">{{ $iki_ats->ik }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_edit_iki">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection


@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/select2/select2.css') !!}" />
@endsection

    @section('scripts')
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
        <script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
        <script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>

        <script>
            var timUser = @json($tim_user);
            var ikiAtasan = @json($iki_atasan);
            var vm = new Vue({
                el: "#app_vue",
                data: {
                    id_edit_iki: '',
                    ik_edit_iki: '',
                    satuan_edit_iki: '',
                    target_edit_iki: '',
                    timUser: timUser,
                    ikiAtasan: ikiAtasan,
                    pathname : window.location.pathname,

                    form_id: 0, form_tanggal: '', form_waktu_mulai: '', form_waktu_selesai: '',
                    form_isi: '', form_hasil: '', form_volume: '',  form_satuan: '',
                    form_pemberi_tugas: '', 
                    form_id_iki:'', form_label_iki:'', 
                    form_jumlah_jam: '',
                    form_link_bukti_dukung: '',
                    form_id_kegiatan: '',
                    keyword_kegiatan: '',

                    list_kegiatan: [],
                    form_iki: {
                        nip: {!! json_encode($request->user) !!}, 
                        nama_iki: '', satuan: '', target: '',
                        tahun: '', bulan: [], tim: '', referensi: ''
                    },
                },
                methods: {
                    addLogBook: function (event) {
                        var self = this;
                        if (event) {
                            self.form_id = 0;
                            self.form_tanggal = '';
                            self.form_waktu_mulai = '';
                            self.form_waktu_selesai = '';
                            self.form_isi = '';
                            self.form_hasil = '';
                            self.form_volume = '';
                            self.form_satuan = '';
                            self.form_pemberi_tugas = '';
                            self.form_jumlah_jam = '';
                            self.form_link_bukti_dukung = '';
                            self.form_id_kegiatan = '';
                            self.form_label_iki = event.currentTarget.getAttribute('data-label_iki');
                            self.form_id_iki = event.currentTarget.getAttribute('data-id_iki');
                        }
                    },
                    saveLogBook: function () {
                        var self = this;

                        if(self.form_tanggal.length==0 ||  self.form_jumlah_jam.length==0 || 
                            self.form_isi.length==0 || self.form_volume.length==0 || self.form_satuan.length==0 || 
                            self.form_pemberi_tugas.length==0){
                            alert("Pastikan isian tanggal, waktu mulai - selesai, isi, volume, satuan dan pemberi tugas telah diisi");
                        }
                        else{
                            if(isNaN(self.form_volume)){
                                alert("Isian 'Volume' harus angka");    
                            }
                            else{
                                $('#wait_progres').modal('show');
                                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                                $.ajax({
                                    url :  "{{ url('/log_book/') }}",
                                    method : 'post',
                                    dataType: 'json',
                                    data:{
                                        id: self.form_id,
                                        tanggal: self.form_tanggal,
                                        // waktu_mulai: self.form_waktu_mulai,
                                        // waktu_selesai: self.form_waktu_selesai, 
                                        isi: self.form_isi, 
                                        hasil: self.form_hasil,
                                        volume: self.form_volume,
                                        satuan: self.form_satuan,
                                        pemberi_tugas: self.form_pemberi_tugas,
                                        id_iki: self.form_id_iki,
                                        jumlah_jam: self.form_jumlah_jam,
                                        link_bukti_dukung: self.form_link_bukti_dukung,
                                        id_kegiatan: self.form_id_kegiatan,
                                    },
                                }).done(function (data) {
                                    $('#add_logbooks').modal('hide');
                                    location.reload();
                                }).fail(function (msg) {
                                    console.log(JSON.stringify(msg));
                                    $('#wait_progres').modal('hide');
                                });
                            }  
                        }
                    },
                    btn_edit_iki: function(event) {
                        var self = this;

                        self.id_edit_iki = event.currentTarget.getAttribute('data-id_iki');
                        self.ik_edit_iki = event.currentTarget.getAttribute('data-ik');
                        self.satuan_edit_iki = event.currentTarget.getAttribute('data-satuan');
                        self.target_edit_iki = event.currentTarget.getAttribute('data-target_iki');

                        document.getElementById('bulan_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-bulan');
                        document.getElementById('tahun_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-tahun');
                        document.getElementById('id_tim_edit_iki').value = event.currentTarget
                            .getAttribute('data-id_tim');
                        document.getElementById('referensi_sumber_edit_iki').value = event.currentTarget
                            .getAttribute('data-referensi_sumber');

                        document.getElementById('form_edit_iki').action = window.location.origin +
                            window.location
                            .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                    },
                    btn_hapus_iki: function(event) {
                        document.getElementById('id_iki_hapus_iki').value = event.currentTarget
                            .getAttribute(
                                'data-id_iki');
                        document.getElementById('text_hapus_iki').innerHTML = event.currentTarget
                            .getAttribute(
                                'data-ik');
                        document.getElementById('form_hapus_iki').action = window.location.origin +
                            window.location
                            .pathname + '/' + event.currentTarget.getAttribute('data-id_iki');
                    },
                    selectKegiatan: function (event) {
                        var self = this;
                        if (event) {
                            self.form_isi = event.currentTarget.getAttribute('data-subkegiatan') + " - " + event.currentTarget.getAttribute('data-uraian_pekerjaan');
                            self.form_id_kegiatan = event.currentTarget.getAttribute('data-id');

                            $('#select_kegiatan').modal('hide');
                        }
                    },
                    searchKegiatan: function(){
                        var self = this;
                        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                        $.ajax({
                            url :  "{{ url('master_pekerjaan/search_data') }}",
                            method : 'post',
                            dataType: 'json',
                            data:{
                                keyword: self.keyword_kegiatan,
                            },
                        }).done(function (data) {
                            self.list_kegiatan = data.datas.data;
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progres').modal('hide');
                        });
                    },
                    validateSubmit:function(){
                        var self = this;

                        let err_msg = []
                        if(self.form_iki.nama_iki.length==0 || self.form_iki.nama_iki==null) err_msg.push("Nama IKI tidak boleh kosong")
                        if(self.form_iki.satuan.length==0 || self.form_iki.satuan==null) err_msg.push("Satuan tidak boleh kosong")
                        if(self.form_iki.target.length==0 || self.form_iki.target==null) err_msg.push("Target tidak boleh kosong")
                        if(self.form_iki.tahun.length==0 || self.form_iki.tahun==null) err_msg.push("Tahun tidak boleh kosong")
                        if(self.form_iki.bulan.length==0) err_msg.push("Bulan minimal dipilih 1")
                        if(self.form_iki.tim.length==0 || self.form_iki.tim==null) err_msg.push("Informasi TIM tidak boleh kosong")

                        if(err_msg.length==0) return true
                        else{
                            alert(err_msg.join())
                            return false
                        }
                    }
                }
            });


            $(document).ready(function() {
                $('.datepicker').datepicker({
                    endDate: 'd',
                });
                vm.searchKegiatan();
            });

            $('#form_tambah_iki').on('submit', function() {
                return vm.validateSubmit();
            });

            $('#form_tanggal').change(function() {
                vm.form_tanggal = this.value;
            });
        </script>
    @endsection
