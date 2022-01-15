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
                    <th class="text-center" rowspan="2">Judul</th>
                    <th class="text-center" rowspan="2">Keterangan</th>
                    <th class="text-center" colspan="3" width="30%">File</th>
                    <th class="text-center" rowspan="2">Status</th>
                    <th class="text-center" rowspan="2">Dibuat oleh</th>
                    <th class="text-center" colspan="2" rowspan="2">Aksi</th>
                </tr>
                
                <tr>
                    <th class="text-center"  width="10%">KAK</th>
                    <th class="text-center" width="10%">Nota Dinas</th>
                    <th class="text-center" width="10%">Matriks Perubahan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{ $data->judul }}</td>
                        <td>{{ $data->keterangan }}</td>
                        <td class="text-center">
                            <a href="{{ action('PokController@download', array('jenis'=> 'kak', 'file_name' => $data->kak)) }}">
                                            <i class="fa fa-file-pdf-o text-info"></i> </a><br/>
                        </td>
                        <td class="text-center">
                            <a href="{{ action('PokController@download', array('jenis'=> 'nota_dinas', 'file_name' => $data->nota_dinas)) }}">
                                            <i class="fa fa-file-pdf-o text-info"></i> </a><br/>
                        </td>
                        <td class="text-center">
                            <a href="{{ action('PokController@download', array('jenis'=> 'matrik_anggaran', 'file_name' => $data->matrik_anggaran)) }}">
                                            <i class="fa fa-file-pdf-o text-info"></i> </a><br/>
                        </td>
                        <td class="text-center">
                            {!! $model->listStatus[$data->status_revisi] !!}
                        </td>
                        <td class="text-center">{{ $data->user->name }}</td>
                        <td class="text-center">
                            
                            <div class="btn-group" role="group" aria-label="Basic example">
                                @if($data->status_revisi==0)
                                    <form id="form-delete" action="{{action('PokController@destroy_revisi', $data['id'])}}" method="post">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        
                                        <a href="#" onclick="document.getElementById('form-delete').submit();">
                                            <i class="icon-trash text-danger"></i> 
                                            <p class='text-danger small'>Hapus</p>
                                        </a>
                                    </form>
                                    &nbsp;
                                    @hasanyrole('superadmin|ppk_unit_kerja')
                                        <form id="form-approve" action="{{action('PokController@approve_revisi', $data['id'])}}" method="post">
                                            @csrf
                                            <a href="#" onclick="document.getElementById('form-approve').submit();">
                                                <i class="icon-check text-info"></i> 
                                                <p class='text-info small'>Approve</p>
                                            </a>
                                        </form>
                                    @endhasanyrole
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    <br/>
    {{ $datas->links() }} 
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