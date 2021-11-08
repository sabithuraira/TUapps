<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas)==0)
        <thead>
            <tr>
                <th>Tidak ditemukan data</th>
            </tr>
        </thead>
        @else
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Ket Surat</th>
                    <th class="text-center" rowspan="2">
                        Pegawai<br/>
                        <span class="badge bg-dark text-white">K</span><small>=Ketua Tim</small> 
                        <span class="badge bg-dark text-white">A</span><small>=Anggota</small>
                    </th>
                    <th class="text-center" colspan="2">Tanggal</th>
                    <th class="text-center" rowspan="2">Status</th>
                    <th class="text-center" colspan="3">Cetak</th>
                    <th class="text-center" rowspan="2">Aksi</th>
                </tr>
                <tr>
                    <th class="text-center">Mulai</th>
                    <th class="text-center">Selesai</th>
                    <th class="text-center">Surat Tugas</th>
                    <th class="text-center">SPD</th>
                    <th class="text-center">Kwitansi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                
                    @if ($data['status_aktif']!=2)
                    <tr>
                        <td class="text-center">
                            <u>{{$data['nomor_st']}}</u><br/>
                            {{ $data->SuratIndukRel->tugas }}<br/>
                            {{$data['tujuan_tugas']}}
                        </td>
                        <td class="text-center">
                            <u>{{ $data['nip'] }}</u><br/>
                            {{ $data['nama'] }}
                            
                            @if ($data['kategori_petugas']==1)
                                <span class="badge bg-dark text-white">K</span>
                            @elseif($data['kategori_petugas']==2)
                                <span class="badge bg-dark text-white">A</span>
                            @endif
                        </td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_aktif']] !!}<br/>
                            <a href="#" role="button" v-on:click="sendStId" 
                                    data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}"
                                    data-status="{{ $data['status_aktif'] }}" 
                                    data-target="#set_status">
                                <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                            </a>
                        </td>
                        
                        <td class="text-center">
                            @if($data->SuratIndukRel->kategori==3)
                                <a href="{{action('SuratTugasController@print_st_pelatihan', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a>
                            @else
                                <a href="{{action('SuratTugasController@print_st', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($data['nomor_spd']!='' && $data->SuratIndukRel->sumber_anggaran!=3)
                                @if($data->SuratIndukRel->kategori==3)
                                    <a href="{{action('SuratTugasController@print_spd_pelatihan', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a>
                                @else
                                    <a href="#" role="button" v-on:click="setNipSpd" 
                                            data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                            data-nip_spd="{{ $data['spd_ttd_nip'] }}" 
                                            data-target="#set_spd">
                                        <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Pejabat TTD SPD</u></p>
                                    </a>
                                    <a href="{{action('SuratTugasController@print_spd', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a>
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($data['nomor_spd']!='' && $data->SuratIndukRel->sumber_anggaran!=3)
                                @if($data->SuratIndukRel->kategori==3)
                                    <a href="{{ action('SuratTugasController@print_kwitansi_pelatihan', Crypt::encrypt($data['id']))}}">
                                        <i class="fa fa-file-pdf-o text-info"></i> <u>Cetak</u></a><br/>
                                @else
                                    <a href="{{ action('SuratTugasController@print_kwitansi', Crypt::encrypt($data['id']))}}">
                                        <i class="fa fa-file-pdf-o text-info"></i> <u>Cetak</u></a><br/>
                                @endif
                                @if($data['status_aktif']<=5)
                                    @if($data->SuratIndukRel->kategori==3)
                                        <a href="{{ action('SuratTugasController@insert_kwitansi_pelatihan', Crypt::encrypt($data['id']))}}">
                                            <i class="icon-arrow-right text-info"></i> <u>Input</u>
                                        </a>
                                    @else
                                        <a href="{{ action('SuratTugasController@insert_kwitansi', Crypt::encrypt($data['id']))}}">
                                            <i class="icon-arrow-right text-info"></i> <u>Input</u>
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="#" role="button" v-on:click="sendStId" 
                                    data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                    data-target="#set_aktif"> 
                                    <i class="icon-trash text-danger"></i>
                                    <p class='text-danger small'>Batalkan</p>
                                </a>

                                <a href="{{ action('SuratTugasController@edit', Crypt::encrypt($data['id']))}}">
                                    <i class="icon-pencil text-primary"></i> 
                                    <p class='text-primary small'>Edit</p>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td class="text-center">
                            <u>{{$data['nomor_st']}}</u><br/>
                            {{$data['tujuan_tugas']}}
                        </td>
                        <td class="text-center">
                            <u>{{$data['nip']}}</u><br/>
                            {{$data['nama']}}
                            
                            @if ($data['kategori_petugas']==1)
                                <span class="badge bg-dark text-white">K</span>
                            @elseif($data['kategori_petugas']==2)
                                <span class="badge bg-dark text-white">K</span>
                            @endif
                        </td>
                        <td class="text-center" colspan="8">DIBATALKAN</td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        @endif
    </table>
    <br/>
    {{ $datas->links() }} 
</div>

<div class="modal" id="set_status" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Rubah status menjadi:
                <select class="form-control {{($errors->first('mak') ? ' parsley-error' : '')}}" v-model="st_status">
                    <option v-for="(value, index) in list_label_status" :value="index">
                        @{{ value }}
                    </option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setStatus">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_spd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Pilih Pejabat yang menandatangani SPD:
                <select class="form-control" v-model="st_spd_ttd_nip" id="ttd_spd">
                    @foreach ($list_pejabat as $value)
                        <option value="{{ $value->nip_baru }}">{{ $value->name }} - {{ $value->nip_baru }} </option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setPejabatSpd">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_aktif" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin membatalkan surat tugas ini? Setelah pembatalan data ini tidak
                dapat lagi digunakan.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setAktif">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200"
                        height="200" alt="Loading..."></div>
                <h4 class="text-center">Please wait...</h4>
            </div>
        </div>
    </div>
</div>

@section('css')
<meta name="_token" content="{{csrf_token()}}" />
<meta name="csrf-token" content="@csrf">
<style type="text/css">
    * {
        font-family: Segoe UI, Arial, sans-serif;
    }

    table {
        font-size: small;
        border-collapse: collapse;
    }

    tfoot tr td {
        font-weight: bold;
        font-size: small;
    }
</style>
<link rel="stylesheet"
    href="{!! asset('lucid/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') !!}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js') !!}"></script>
<script>
    var vm = new Vue({  
    el: "#app_vue",
    data:  {
        datas: [],
        pathname : window.location.pathname,
        st_id: 0,
        st_status: 1,
        st_spd_ttd_nip: '',
        st_spd_ttd_nama: '',
        st_spd_ttd_jabatan: '',
        list_label_status: {!! json_encode($model->listLabelStatus) !!},
        list_pejabat:  {!! json_encode($list_pejabat) !!},
    },
    methods: {
        setDataPejabat(){
            var self = this;
            var pejabat_ttd_nip = $("#ttd_spd")[0].selectedIndex;
            
            self.st_spd_ttd_nama = self.list_pejabat[pejabat_ttd_nip].name;
            self.st_spd_ttd_jabatan = self.list_pejabat[pejabat_ttd_nip].nmjab;
        },
        setNipSpd(event){
            var self = this;
            if (event) {
                self.st_id = event.currentTarget.getAttribute('data-id');
                self.st_spd_ttd_nip = event.currentTarget.getAttribute('data-nip_spd');
            }
        },
        sendStId: function (event) {
            var self = this;
            if (event) {
                self.st_id = event.currentTarget.getAttribute('data-id');
                self.st_status = event.currentTarget.getAttribute('data-status');
            }
        },
        setPejabatSpd: function (jenis) {
            var self = this;
            self.setDataPejabat();
            $('#set_spd').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            $.ajax({
                url :  self.pathname + '/set_pejabat_spd',
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.st_id,
                    spd_ttd_nip: self.st_spd_ttd_nip,
                    spd_ttd_nama: self.st_spd_ttd_nama,
                    spd_ttd_jabatan: self.st_spd_ttd_jabatan,
                },
            }).done(function (data) {
                window.location.reload(false); 
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setStatus: function (jenis) {
            var self = this;
            $('#set_pembayaran').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            $.ajax({
                url :  self.pathname + '/set_status',
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.st_id,
                    form_status_data: self.st_status,
                },
            }).done(function (data) {
                window.location.reload(false); 
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        setAktif: function (jenis) {
            var self = this;
            $('#set_pembayaran').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            $.ajax({
                url :  self.pathname + '/set_aktif',
                method : 'post',
                dataType: 'json',
                data:{
                    form_id_data: self.st_id,
                },
            }).done(function (data) {
                window.location.reload(false); 
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
    }
});
</script>
@endsection