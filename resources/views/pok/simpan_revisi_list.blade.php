<div id="app_vue" class="table-responsive">
    @hasanyrole('superadmin|kuasa_anggaran')
        @if (count($datas)>0)
        <div class="row clearfix">
            <div class="col-md-6"></div>
            
            <div class="col-md-6 float-right text-right">
                <a href="#" @click="simpanRevisiDipa" class="btn btn-success">
                    SIMPAN DIPA
                </a>
                &nbsp;&nbsp;
                <a href="#" @click="simpanRevisi" class="btn btn-success">
                    SIMPAN POK
                </a>
            </div>
        </div>
        <br/>
        @endif
    @endhasanyrole
    
    @php 
        $total_lama = 0;
        $total_baru = 0;

        function pembulatan($anggaran){
            if (substr($anggaran,-3)>499){
                return round($anggaran,-3)-1000;
            } else {
                return round($anggaran,-3);
            } 
        }
    @endphp
    <table class="table-sm table-bordered m-b-0" style="min-width:100%">
        @if (count($datas)==0)
        <thead>
            <tr><th>Tidak ditemukan data</th></tr>
        </thead>
        @else
            <thead>
                <tr class="text-center">
                    <th colspan="3">SEMULA</th>
                    <th colspan="3">MENJADI</th>
                    <th rowspan="2"></th>
                </tr>
                
                <tr class="text-center">
                    <th>Ket POK</th>
                    <th>Rincian Jumlah</th>
                    <th>Biaya</th>
                    <th>Ket POK</th>
                    <th>Rincian Jumlah</th>
                    <th>Biaya</th>
                </tr>
            </thead>

            <tbody>
                @php 
                    $id_kro = ''; $kro = null;
                    $id_ro = ''; $ro = null;
                    $id_komponen = ''; 
                    $id_sub_komponen = '';
                    $id_mata_anggaran = '';

                    $total_kro_semula = 0;
                    $total_kro_menjadi = 0;
                @endphp
                @foreach($datas as $key=>$data) 

                    @php 
                        $old_data = null;

                        $total_baru += pembulatan($data->harga_jumlah);
                        if($data->old_rencana_id!=null){
                            $old_data = \App\PokRincianAnggaran::find($data->old_rencana_id);
                            $old_mata_anggaran = \App\PokMataAnggaran::find($old_data->id_mata_anggaran);

                            if($old_data->jumlah_rincian_estimasi!=null){
                                if($old_data->jumlah_rincian_realisasi!=null){
                                    $total_lama += (pembulatan($old_lama->harga_jumlah)-pembulatan($old_lama->jumlah_rincian_realisasi));
                                }
                                else{
                                    $total_lama += (pembulatan($old_lama->harga_jumlah)-pembulatan($old_lama->jumlah_rincian_estimasi));
                                }
                            }
                            else{
                                $total_lama += pembulatan($old_data->harga_jumlah);
                            }
                        }
                    @endphp 

                    @if($id_kro!=$data->id_kro)
                        @if($id_kro!='')
                            <tr>
                                <td colspan="3">
                                    <b>Jumlah Semula</b>: Rp. {{ number_format($total_kro_semula) }}
                                </td>
                                <td colspan="3">
                                    <b>Jumlah Menjadi</b>: Rp. {{ number_format($total_kro_menjadi) }}
                                </td>
                                <td></td>
                            </tr>
                        @endif
                        @php 
                            $total_kro_semula = 0;
                            $total_kro_menjadi = 0;
                            if($old_data!=null) $total_kro_semula += pembulatan($old_data->harga_jumlah);
                            $total_kro_menjadi += pembulatan($data->harga_jumlah);
                            $id_kro = $data->id_kro;
                            $kro = \App\PokKro::find($id_kro);
                        @endphp
                        <tr>
                            <td colspan="7">
                                <b>KRO</b>: {{ $kro->kode }} - {{ $kro->label }}
                            </td>
                        </tr>
                    @else 
                        @php 
                            if($old_data!=null) $total_kro_semula += pembulatan($old_data->harga_jumlah);
                            $total_kro_menjadi += pembulatan($data->harga_jumlah);
                        @endphp
                    @endif

                    <tr>
                        @if($id_ro!=$data->id_ro)
                            @php 
                                $id_ro = $data->id_ro;
                                $ro = \App\PokRo::find($id_ro);
                            @endphp
                        @endif

                        @if($old_data==null)
                            <td></td>
                            <td></td>
                            <td></td>
                        @else
                                @php 
                                    $old_id_ro = $old_mata_anggaran->id_ro;
                                    $old_ro = \App\PokRo::find($old_id_ro);
                                @endphp
                            <td>
                                <b>RO</b>:  {{ $ro->kode }} - {{ $ro->label }}<br/>
                                <b>Komponen</b>: {{ $data->kode_komponen }} - {{ $data->label_komponen }}<br/>
                                <b>Sub Komponen</b>: {{ $data->kode_sub_komponen }} - {{ $data->label_sub_komponen }}<br/>
                                <b>Akun</b>: {{ $data->kode_mata_anggaran }} - {{ $data->label_mata_anggaran }}<br/>    
                                <b>Detail</b>: {{ $old_data->label }}<br/>    
                            </td>
                            <td>
                                <b>Volume</b>: {{ $old_data->volume }}<br/>
                                <b>Satuan</b>:  {{ $old_data->satuan }}<br/>
                                <b>Harga Satuan</b>:  {{ number_format($old_data->harga_satuan) }}<br/>
                            </td>
                            <td>
                                <b>Biaya</b>: {{ number_format($old_data->harga_jumlah) }}<br/>
                                <b>Estimasi</b>: {{ number_format($old_data->jumlah_rincian_estimasi) }}<br/>
                                <b>Realisasi</b>: {{ number_format($old_data->jumlah_rincian_realisasi) }}<br/>
                            </td>
                        @endif
                        
                        <td>
                            <b>RO</b>: {{ $ro->kode }} - {{ $ro->label }}<br/>
                            <b>Komponen</b>: {{ $data->kode_komponen }} - {{ $data->label_komponen }}<br/>
                            <b>Sub Komponen</b>: {{ $data->kode_sub_komponen }} - {{ $data->label_sub_komponen }}<br/>
                            <b>Akun</b>: {{ $data->kode_mata_anggaran }} - {{ $data->label_mata_anggaran }}<br/>    
                            <b>Detail</b>: {{ $data->label }}<br/>    
                        </td>
                        <td>
                            <b>Volume</b>: {{ $data->volume }}<br/>
                            <b>Satuan</b>: {{ $data->satuan }}<br/>
                            <b>Harga Satuan</b>: {{ number_format($data->harga_satuan) }}<br/>
                        </td>
                        <td>
                            Biaya</b>: {{ number_format($data->harga_jumlah) }}<br/>
                        </td>
                        <td class="text-center">
                            <a href="#" role="button" data-revisi_id="{{ $data->id }}" @click="deleteRevisi"> 
                                <i class="icon-trash text-danger"></i>
                                <p class='text-danger small'>Hapus Revisi</p>
                            </a>
                        </td>
                    </tr>

                    
                    @if($key+1==count($datas))
                        <tr>
                            <td colspan="3">
                                <b>Jumlah Semula</b>: Rp. {{ number_format($total_kro_semula) }}
                            </td>
                            <td colspan="3">
                                <b>Jumlah Menjadi</b>: Rp. {{ number_format($total_kro_menjadi) }}
                            </td>
                            <td></td>
                        </tr>
                    @endif

                @endforeach
                <tr>
                    <td colspan="2" class="text-center"><b>JUMLAH SEMULA</b></td>
                    <td><b>Rp. {{ number_format($total_lama) }}</b></td>
                    <td colspan="2" class="text-center"><b>JUMLAH MENJADI</b></td>
                    <td><b>Rp. {{ number_format($total_baru) }}</b></td>
                    <td></td>
                </tr>
            </tbody>
        @endif
    </table>

    <input type="hidden" id="total_lama" value="{{ $total_lama }}">
    <input type="hidden" id="total_baru" value="{{ $total_baru }}">

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
        },
        methods: {
            deleteRevisi: function() { 
                var self = this;
                
                if(confirm("Anda yakin ingin menghapus data ini?")){
                    if(event){
                        var revisi_id = event.currentTarget.getAttribute('data-revisi_id');
                        
                        $('#wait_progres').modal('show');
                        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                        $.ajax({
                            url :  "{{ url('pok/delete_revisi') }}",
                            method : 'post',
                            dataType: 'json',
                            data:{
                                revisi_id: revisi_id,
                            },
                        }).done(function (data) {
                            if(data.status=='error') alert('error, refresh halaman dan ulangi lagi');
                            else location.reload() //alert("Data berhasil disimpan")

                            $('#wait_progres').modal('hide');
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progre').modal('hide');
                        });
                    }
                }
            },
            simpanRevisi: function() { 
                var self = this;
                
                if(confirm("Anda yakin ingin menyimpan dan menampilkan revisi?")){
                    
                    var total_lama = $("#total_lama").val();
                    var total_baru = $("#total_baru").val();

                    if(total_lama>total_baru){
                        alert("Anggaran pada DETAIL lama masih lebih besar dari anggaran pada DETAIL perubahan");
                    }
                    else if(total_lama<total_baru){
                        alert("Jumlah biaya pada REVISI tidak cukup, mohon periksa kembali");    
                    }
                    else{

                        $('#wait_progres').modal('show');
                        $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                        $.ajax({
                            url :  "{{ url('pok/save_revisi') }}",
                            method : 'post',
                            dataType: 'json',
                        }).done(function (data) {
                            if(data.status=='error') alert('error, refresh halaman dan ulangi lagi');
                            else{
                                alert("Data berhasil disimpan")
                                location.reload() 
                            }

                            $('#wait_progres').modal('hide');
                        }).fail(function (msg) {
                            console.log(JSON.stringify(msg));
                            $('#wait_progre').modal('hide');
                        });
                    }
                }
            },
            simpanRevisiDipa: function() { 
                var self = this;
                
                if(confirm("Anda yakin ingin menyimpan dan menampilkan revisi?")){
                    
                    $('#wait_progres').modal('show');
                    $.ajaxSetup({ headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')} })

                    $.ajax({
                        url :  "{{ url('pok/save_revisi') }}",
                        method : 'post',
                        dataType: 'json',
                    }).done(function (data) {
                        if(data.status=='error') alert('error, refresh halaman dan ulangi lagi');
                        else{
                            alert("Data berhasil disimpan")
                            location.reload() 
                        }

                        $('#wait_progres').modal('hide');
                    }).fail(function (msg) {
                        console.log(JSON.stringify(msg));
                        $('#wait_progre').modal('hide');
                    });
                }
            },
        }
    });

    $(document).ready(function() {
    });
</script>
@endsection