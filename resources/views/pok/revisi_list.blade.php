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
                    <th class="text-center">Judul</th>
                    <th class="text-center">Keterangan</th>
                    <th class="text-center">Status</th>
                    <th class="text-center" rowspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{ $data->judul }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td>{{ $data->status }}</td>
                        <td></td>
                    </tr>
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