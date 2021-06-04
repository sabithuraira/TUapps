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
                    <th class="text-center">Pegawai yang terlibat</th>
                    <th class="text-center" colspan="2">Waktu</th>
                    <th class="text-center" rowspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td class="text-center">
                            <u>{{$data['isi']}}</u>
                        </td>
                        <td class="text-center">
                            <small><u>{{$data['keterangan']}}</u></small>
                        </td>
                        <td class="text-center">
                        </td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                        <td>{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                        <td class="text-center"></td>
                        
                        <td class="text-center"></td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    <br/>
    {{ $datas->links() }} 
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
    },
    methods: {
    }
});
</script>
@endsection