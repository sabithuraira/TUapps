<form action="{{action('CkpController@print')}}" method="post">
    @csrf 
    <input type="hidden"  v-model="skp_id" name="skp">
    <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak SKP Target &nbsp</button>
    <span class="float-right">&nbsp &nbsp</span>
    <button name="action" class="float-right" type="submit" value="1"><i class="icon-printer"></i>&nbsp Cetak SKP Pengukuran &nbsp</button>
</form>
<br/><br/>

<template v-if="skp_induk!=null">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#target">TARGET</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pengukuran">PENGUKURAN</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane show active" id="target">
            <div class="table-responsive">
                <table class="table-sm table-bordered m-b-0" style="min-width:100%">
                    <thead>
                        <tr>
                            <td>NO</td><td colspan="2">I. PEJABAT PENILAI</td>
                            <td>NO</td><td colspan="6">II. PEGAWAI NEGERI SIPIL YANG DINILAI</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nama</td>
                            <td></td>
                            <td>1</td>
                            <td colspan="2">Nama</td>
                            <td colspan="4"></td>
                        </tr>
                        
                        <tr>
                            <td>2</td>
                            <td>NIP</td>
                            <td></td>
                            <td>2</td>
                            <td colspan="2">NIP</td>
                            <td colspan="4"></td>
                        </tr>
                        
                        <tr>
                            <td>3</td>
                            <td>Pangkat/Gol. Ruang</td>
                            <td>@{{ skp_induk.user_pangkat }} / @{{ skp_induk.user_gol }} </td>
                            <td>3</td>
                            <td colspan="2">Pangkat/Gol. Ruang</td>
                            <td colspan="4">@{{ skp_induk.pimpinan_pangkat }} / @{{ skp_induk.pimpinan_gol }} </td>
                        </tr>
                        
                        <tr>
                            <td>4</td>
                            <td>Jabatan</td>
                            <td>@{{ skp_induk.user_jabatan }}</td>
                            <td>4</td>
                            <td colspan="2">Jabatan</td>
                            <td colspan="4">@{{ skp_induk.user_jabatan }}</td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Unit Kerja</td>
                            <td>@{{ skp_induk.user_unit_kerja }}</td>
                            <td>5</td>
                            <td colspan="2">Unit Kerja</td>
                            <td colspan="4">@{{ skp_induk.user_unit_kerja }}</td>
                        </tr>

                        <tr>
                            <th rowspan="2">NO</th>
                            <th rowspan="2" colspan="2">III. KEGIATAN TUGAS JABATAN</th>
                            <th rowspan="2">AK</th>
                            <th colspan="6">TARGET</th>
                        </tr>
                        
                        <tr>
                            <th colspan="2">KUANT/OUTPUT</th>
                            <th>KUAL/MUTU</th>
                            <th colspan="2">WAKTU</th>
                            <th>BIAYA</th>
                        </tr>

                        <tr v-for="(data, index) in skp_target" :key="data.id">
                            <td>@{{ index+1 }}</td>
                            <td colspan="2">@{{ data.uraian }}</td>
                            <td>@{{ data.kode_point_kredit }}</td>
                            <td class="text-center">@{{ data.target_kuantitas }}</td>
                            <td class="text-center">@{{ data.satuan }}</td>
                            <td class="text-center">@{{ data.target_kualitas }}</td>
                            <td class="text-center">@{{ data.waktu }}</td>
                            <td class="text-center">@{{ data.satuan_waktu }}</td>
                            <td class="text-center">@{{ data.biaya }} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="tab-pane" id="pengukuran">
            <div class="table-responsive">
                <table class="table-sm table-bordered m-b-0">
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th class="text-center" rowspan="2">I. Kegiatan Tugas Jabatan</th>
                            <th rowspan="2">AK</th>
                            <th class="text-center" colspan="6">TARGET</th>
                            <th rowspan="2">AK</th>
                            <th class="text-center" colspan="6">REALISASI</th>
                            <th rowspan="2">PENGHITUNGAN</th>
                            <th rowspan="2">NILAI CAPAIAN SKP</th>
                        </tr>

                        <tr class="text-center">
                            <td coslpan="2">Kuant/Output</td>
                            <td coslpan="2">Kual/Mutu</td>
                            <td>Waktu</td>
                            <td>Biaya</td>
                            
                            <td coslpan="2">Kuant/Output</td>
                            <td coslpan="2">Kual/Mutu</td>
                            <td>Waktu</td>
                            <td>Biaya</td>
                        </tr>
                        
                        <tr class="text-center">
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td colspan="2">4</td>
                            <td>5</td>
                            <td colspan="2">6</td>
                            <td>7</td>
                            <td>8</td>
                            <td colspan="2">9</td>
                            <td>10</td>
                            <td colspan="2">11</td>
                            <td>12</td>
                            <td>13</td>
                            <td>14</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(data, index) in skp_pengukuran" :key="data.id">
                            <td>@{{ index+1 }}</td>
                            <td>@{{ data.uraian }}</td> 

                            <td>@{{ data.target_angka_kredit }}</td>
                            <td>@{{ data.target_kuantitas }}</td>
                            <td>@{{ data.target_satuan }}</td>
                            <td>@{{ data.target_kualitas }}</td>
                            <td>@{{ data.target_waktu }}</td>
                            <td>@{{ data.target_satuan_waktu }}</td>
                            <td>@{{ data.target_biaya }}</td>
                            
                            <td>@{{ data.realisasi_angka_kredit }}</td>
                            <td>@{{ data.realisasi_kuantitas }}</td>
                            <td>@{{ data.realisasi_satuan }}</td>
                            <td>@{{ data.realisasi_kualitas }}</td>
                            <td>@{{ data.realisasi_waktu }}</td>
                            <td>@{{ data.realisasi_satuan_waktu }}</td>
                            <td>@{{ data.realisasi_biaya }}</td>

                            <td>@{{ data.penghitungan }}</td>
                            <td>@{{ data.nilai_capaian_skp }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>
<template v-else>
    <div class="alert alert-primary" role="alert">
    Data SKP belum ada/dipilih
    </div>
</template>

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
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
        list_skp: {!! json_encode($skp_induk) !!},
        skp_id: 0,
        skp_induk: null,
        skp_pengukuran: [],
        skp_target: [],
        tanggal_mulai: '',
        tanggal_selesai: '',
        pathname : window.location.pathname,
    },
    watch: {
        tanggal_mulai: function (val) {
            this.setDatas();
        },
        tanggal_selesai: function (val) {
            this.setDatas();
        }
    },
    methods: {
        setSkpId: function(){
            if(this.list_skp.length>0) this.skp_id = this.list_skp[0].id
            else this.skp_id = 0
        },
        setDatas: function(){
            var self = this;
            $('#wait_progres').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            $.ajax({
                url : self.pathname+ "/" + self.skp_id + "/data_skp",
                method : 'get',
                dataType: 'json',
            }).done(function (data) {
                self.skp_induk = data.datas.skp_induk;
                self.skp_pengukuran = data.datas.skp_pengukuran;
                self.skp_target = data.datas.skp_target;
                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
    }
});

    $(document).ready(function() {
        vm.setSkpId();
        vm.setDatas();
    });
</script>
@endsection