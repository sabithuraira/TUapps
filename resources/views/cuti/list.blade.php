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
                <th class="text-center" rowspan="2">
                    Pegawai<br />
                </th>
                <th class="text-center" colspan="2">Tanggal</th>
                <th class="text-center" rowspan="2">Jenis Cuti</th>
                <th class="text-center" rowspan="2">Lama Cuti<br />(Hari)</th>
                <th class="text-center" colspan="2">Status</th>
                <th class="text-center" rowspan="2">Print</th>
                <th class="text-center" rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th class="text-center">Mulai</th>
                <th class="text-center">Selesai</th>
                <th class="text-center">Atasan</th>
                <th class="text-center">Pejabat</th>
            </tr>
        </thead>
        <tbody>
            {{-- {{ json_encode($datas) }} --}}
            @foreach($datas as $data)
            <tr>
                <td class="text-center">
                    <u>{{ $data['nip'] }}</u><br />
                    {{ $data['nama'] }}</td>
                <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                <td class="text-center">{{ $data['jenis_cuti'] }}</td>
                <td class="text-center">{{ $data['lama_cuti'] }}</td>
                <td class="text-center">
                    {!! $data->listStatus[$data['status_atasan']] !!}<br />
                    <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                        data-id="{{ Crypt::encrypt($data['id']) }}" data-status="{{ $data['status_atasan'] }}"
                        data-target="#set_status_atasan">
                        <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                    </a>
                </td>
                <td class="text-center">
                    {!! $data->listStatus[$data['status_pejabat']] !!}<br />
                    <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                        data-id="{{ Crypt::encrypt($data['id']) }}" data-status="{{ $data['status_pejabat'] }}"
                        data-target="#set_status_pejabat">
                        <p class='text-muted small'><i class="icon-arrow-up"></i> &nbsp; <u>Ubah Status</u></p>
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{action('CutiController@print_cuti', Crypt::encrypt($data['id']))}}"><i
                            class="fa fa-file-pdf-o text-info"></i></a>
                </td>

                <td class="text-center">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="#" role="button" v-on:click="sendStId" data-toggle="modal"
                            data-id="{{ Crypt::encrypt($data->id) }}" data-target="#set_aktif">
                            <i class="icon-trash text-danger"></i>
                            <p class='text-danger small'>Hapus</p>
                        </a>

                        <a href="{{ action('CutiController@edit', Crypt::encrypt($data['id']))}}">
                            <i class="icon-pencil text-primary"></i>
                            <p class='text-primary small'>Edit</p>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        @endif
    </table>
    <br />
    {{ $datas->links() }}
</div>

<div class="modal" id="set_status_atasan" tabindex="-1" role="dialog">
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
                <button type="button" class="btn btn-primary" v-on:click="setStatus_atasan">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="set_status_pejabat" tabindex="-1" role="dialog">
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
                <button type="button" class="btn btn-primary" v-on:click="setStatus_pejabat">Ya</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">batal</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="set_aktif" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">Anda yakin ingin menghapus cuti ini? Setelah pembatalan data ini tidak
                dapat lagi digunakan.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="setDelete">Ya</button>
                {{-- <form method="POST" action="/cuti/{{ $data->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-primary">Ya</button>
                </form> --}}
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
        list_label_status: {!! json_encode($model->listLabelStatus) !!},
    },
    methods: {
        sendStId: function (event) {
            var self = this;
            if (event) {
                self.st_id = event.currentTarget.getAttribute('data-id');
                self.st_status = event.currentTarget.getAttribute('data-status');
            }
        },
        setStatus_atasan: function ($tipe) {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            $.ajax({
                url :  self.pathname + '/set_status_atasan',
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
        setStatus_pejabat: function ($tipe) {
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            $.ajax({
                url :  self.pathname + '/set_status_pejabat',
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
        setDelete: function (jenis) {
            var self = this;
            $('#wait_progres').modal('show');
            window.location.href = self.pathname +"/"+ self.st_id +"/delete";
            // $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })
            // $.ajax({
            //     url :  self.pathname +"/"+ self.st_id +"/delete",
            //     method : 'GET',
            // }).done(function (data) {
            //     $('#wait_progres').modal('hide');
            //     window.location.reload(true); 
            //     // return redirect('cuti')->with('success', 'Data berhasil dihapus');
            // }).fail(function (msg) {
            //     console.log(JSON.stringify(msg));
            //     $('#wait_progres').modal('hide');
            // });
        },
    }
});
</script>
@endsection