<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">Ket Surat</th>
                    <th class="text-center" rowspan="2">Pegawai</th>
                    <th class="text-center" colspan="2">Tanggal</th>
                    <th class="text-center" colspan="3">Status</th>
                    <th class="text-center" rowspan="2" colspan="2">Aksi</th>
                    <th class="text-center" colspan="2">Cetak</th>
                </tr>
                
                <tr>
                    <th class="text-center">Mulai</th>
                    <th class="text-center">Selesai</th>
                    <th class="text-center">LPD</th>
                    <th class="text-center">Kelengkapan Dok</th>
                    <th class="text-center">Pembayaran</th>
                    <th class="text-center">Surat Tugas</th>
                    <th class="text-center">SPD</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                
                    @if ($data['status_aktif']==1)
                    <tr>
                        <td class="text-center">
                            <u>{{$data['nomor_st']}}</u><br/>
                            {{$data['tujuan_tugas']}}
                        </td>
                        <td class="text-center">
                            <u>{{$data['nip']}}</u><br/>
                            {{$data['nama']}}
                        </td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_kumpul_lpd']] !!}<br/>
                            <a href="#" role="button" v-on:click="sendStId" 
                                    data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                    data-target="#set_lpd"> 
                                <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                            </a>
                        </td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_kumpul_kelengkapan']] !!}<br/>
                            <a href="#" role="button" v-on:click="sendStId" 
                                    data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                    data-target="#set_kelengkapan"> 
                                <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                            </a>
                        </td>
                        <td class="text-center">
                            {!! $data->listStatus[$data['status_pembayaran']] !!}<br/>
                            <a href="#" role="button" v-on:click="sendStId" 
                                    data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                    data-target="#set_pembayaran"> 
                                <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                            </a>
                        </td>
                        
                        <td class="text-center">
                            <a href="{{action('SuratTugasController@edit', Crypt::encrypt($data['id']))}}"><i class="icon-pencil text-info"></i></a></td>
                        <td class="text-center">
                            <a href="#" role="button" v-on:click="sendStId" 
                                data-toggle="modal" data-id="{{ Crypt::encrypt($data['id']) }}" 
                                data-target="#set_aktif"> 
                                <i class="icon-trash"></i>
                                <p class='text-muted small'>Batalkan</p>
                            </a>
                        </td>
                        
                        <td class="text-center"><a href="{{action('SuratTugasController@print_st', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a></td>
                        <td class="text-center"><a href="{{action('SuratTugasController@print_st', Crypt::encrypt($data['id']))}}"><i class="fa fa-file-pdf-o text-info"></i></a></td>
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
                        </td>
                        <td class="text-center" colspan="9">DIBATALKAN</td>
                    </tr>
                    @endif
                
                
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>

<div class="modal" id="set_lpd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin merubah status LPD?
            :</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setLpd">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_kelengkapan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin merubah status Pengumpulan kelengkapan dokumen?
            :</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setKelengkapan">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_pembayaran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin merubah status pembayaran?
            :</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setPembayaran">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_aktif" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin membatalkan surat tugas ini? Setelah pembatalan data ini tidak dapat lagi digunakan.</div>
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
    },
    methods: {
        sendStId: function (event) {
            var self = this;
            if (event) {
                self.st_id = event.currentTarget.getAttribute('data-id');
            }
        },
        setLpd: function (jenis) {
            var self = this;
            $('#set_lpd').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + '/set_lpd',
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
        setKelengkapan: function (jenis) {
            var self = this;
            $('#set_kelengkapan').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + '/set_kelengkapan',
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
        setPembayaran: function (jenis) {
            var self = this;
            $('#set_pembayaran').modal('hide');
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

            $.ajax({
                url :  self.pathname + '/set_pembayaran',
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
        
        setAktif: function (jenis) {
            var self = this;
            $('#set_aktif').modal('hide');
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