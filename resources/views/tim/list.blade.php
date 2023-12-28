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
                    <th>Nama Tim</th>
                    <th>Ketua Tim</th>
                    <th>Jumlah Anggota</th>
                    <th>Unit Kerja</th>
                    <th>Tahun</th>
                    <th colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td class="text-center">{{ $data['nama_tim'] }}</td>
                        <td class="text-center">
                            {{ $data['nama_ketua_tim'] }}<br/>
                            <span class="text-muted">{{ $data['nik_ketua_tim'] }}</span>
                        </td>
                        <td class="text-center">{{ $data['jumlah_anggota'] }}</td>
                        <td class="text-center">{{ $data['kode_kab'] }}</td>
                        <td class="text-center">{{ $data['tahun'] }}</td>
                        <td class="text-center">
                            <a href="{{ action('TimController@edit', Crypt::encrypt($data['id']))}}">
                                <i class="icon-pencil text-primary"></i> 
                                <p class='text-primary small'>Edit</p>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ action('TimController@progres', Crypt::encrypt($data['id']))}}">
                                <i class="icon-speedometer text-primary"></i> 
                                <p class='text-primary small'>Detail</p>
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
});
</script>
@endsection