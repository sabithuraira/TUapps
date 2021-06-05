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
                <tr class="text-center">
                    <th rowspan="2">Judul</th>
                    <th rowspan="2">Keterangan</th>
                    <th rowspan="2">Pegawai yang terlibat</th>
                    <th colspan="2">Waktu</th>
                    <th rowspan="2">Aksi</th>
                </tr>
                
                <tr class="text-center">
                    <th>Mulai</th>
                    <th>Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>
                            {{$data['isi']}}
                        </td>
                        <td>
                            <small><i>{{$data['keterangan']}}</i></small>
                        </td>
                        <td class="text-center">
                            {!! $data->listPeserta !!}
                            
                            <a href="{{ action('PenugasanController@show', Crypt::encrypt($data['id']))}}">
                                 
                                <p class='text-primary small'><i class="fa fa-search text-primary"></i> Detail</p>
                            </a>
                        </td>
                        <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_mulai'])) }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime($data['tanggal_selesai'])) }}</td>
                        <td class="text-center">
                            <a href="{{ action('PenugasanController@edit', Crypt::encrypt($data['id']))}}">
                                <i class="icon-pencil text-primary"></i> 
                                <p class='text-primary small'>Edit/Progres</p>
                            </a>
                        </td>
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