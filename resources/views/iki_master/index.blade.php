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
                            <table class="table table-sm table-bordered text-center" style="font-size: small">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">IK</th>
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
                                                    <td>{{  $i+1 }}</td>
                                                    <td style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ik }} </td>
                                                    <td>{{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    <td colspan="3">
                                                        @if ($request->user == $auth->nip_baru)
                                                        <a href="#" role="button" v-on:click="addLogBook"  
                                                            class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-label_iki="{{ $dt->ik }}"
                                                            data-id_iki="{{ $dt->id }}" 
                                                            data-target="#add_logbooks">
                                                        <i class="fa fa-plus-circle"></i> <span>Tambah Log Book</span></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @else 
                                                <tr>
                                                    <td rowspan="{{ $total_logbook+1 }}">{{ $i+1 }}</td>
                                                    <td rowspan="{{ $total_logbook+1 }}" style="max-width: 200px; word-wrap: break-word; white-space:normal">
                                                        {{ $dt->ik }} </td>
                                                    <td rowspan="{{ $total_logbook+1 }}">{{ $dt->target . ' ' . $dt->satuan }}</td>
                                                    <td colspan="3">
                                                        @if ($request->user == $auth->nip_baru)
                                                        <a href="#" role="button" v-on:click="addLogBook"  
                                                            class="btn btn-sm btn-primary" data-toggle="modal" 
                                                            data-label_iki="{{ $dt->ik }}"
                                                            data-id_iki="{{ $dt->id }}" 
                                                            data-target="#add_logbooks">
                                                        <i class="fa fa-plus-circle"></i> <span>Tambah Log Book</span></a>
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
                            <input type="text" name="nip" id="nip_tambah_iki" value="{{ $request->user }}"
                                readonly hidden required>
                            <div class="form-group">
                                <label>Nama IK</label>
                                <input type="text" name="ik" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <input type="text" name="satuan" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Target</label>
                                <input type="text" name="target" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="">Semua</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024" selected>2024</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label> Tim</label>
                                <select name="id_tim" id="id_tim_tambah_iki"
                                    class="form-control show-tick ms search-select">
                                    @foreach ($tim_user as $tim)
                                        <option value="{{ $tim->id }}"> {{ $tim->nama_tim }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Referensi Sumber IKI</label>
                                <select name="referensi_sumber" id="referensi_sumber_tambah_iki"
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
                                    <option value="">Semua</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024" selected>2024</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bulan</label>
                                <select name="bulan" id="bulan_edit_iki"
                                    class="form-control show-tick ms search-select">
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
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
                        this.id_edit_iki = event.currentTarget.getAttribute('data-id_iki');
                        this.ik_edit_iki = event.currentTarget.getAttribute('data-ik');
                        this.satuan_edit_iki = event.currentTarget.getAttribute('data-satuan');
                        this.target_edit_iki = event.currentTarget.getAttribute('data-target_iki');
                        document.getElementById('bulan_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-bulan');
                        document.getElementById('tahun_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-tahun');
                        document.getElementById('id_tim_edit_iki').value = event.currentTarget
                            .getAttribute(
                                'data-id_tim');
                        document.getElementById('referensi_jenis_edit_iki').value = event.currentTarget
                            .getAttribute('data-referensi_jenis');
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
                }
            });


            $(document).ready(function() {
                $('.datepicker').datepicker({
                    endDate: 'd',
                });
                
            });

            $('#form_tanggal').change(function() {
                vm.form_tanggal = this.value;
            });
        </script>
    @endsection
