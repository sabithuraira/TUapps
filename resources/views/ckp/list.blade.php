<form action="{{action('CkpController@print')}}" method="post">
    @csrf 
    <input type="hidden"  v-model="type" name="p_type">
    <input type="hidden"  v-model="month" name="p_month">
    <input type="hidden"  v-model="year" name="p_year">
    <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak CKP-R &nbsp</button>
    <span class="float-right">&nbsp &nbsp</span>
    <button name="action" class="float-right" type="submit" value="1"><i class="icon-printer"></i>&nbsp Cetak CKP-T &nbsp</button>
</form>
<br/><br/>


<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#utama">UTAMA</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#penilaian">PENILAIAN</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane show active" id="utama">

        <div class="table-responsive">
            <table class="table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $model->attributes()['uraian'] }}</td>
                        <td class="text-center" rowspan="2">Pemberi Tugas</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['satuan'] }}</td>
                        
                        <td class="text-center" colspan="3">Kuantitas</td>
                        <td class="text-center" rowspan="2">Tingkat Kualitas</td>
                        
                        <td class="text-center" rowspan="2">{{ $model->attributes()['kode_butir'] }}</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['angka_kredit'] }}</td>
                        <td class="text-center" rowspan="2">{{ $model->attributes()['keterangan'] }}</td>
                    </tr>

                    <tr>
                        <td class="text-center" >Target</td>
                        <td class="text-center" >Realisasi</td>
                        <td class="text-center" >%</td>
                    </tr>
                </thead>

                <tbody>
                    <tr><td colspan="11">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{ data.pemberi_tugas_nama }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                          
                        <td class="text-center">@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>
                    
                    <tr><td colspan="11">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{ data.pemberi_tugas_nama }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                        <td class="text-center">@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>

                    <template>
                        <tr>
                            <td colspan="6"><b>JUMLAH</b></td>
                            <td class="text-center">@{{ total_kuantitas }} %</td>
                            <td class="text-center">@{{ total_kualitas }} %</td>
                            <td colspan="9"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="6"><b>CAPAIAN KINERJA PEGAWAI (CKP)</b></td>
                            <td class="text-center" colspan="2">@{{ ((Number(total_kuantitas)+Number(total_kualitas))/2).toFixed(2) }}</td>
                            <td colspan="9"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="tab-pane" id="penilaian">
        <div class="table-responsive">
            <table class="table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $model->attributes()['uraian'] }}</td>
                        <td class="text-center" rowspan="2">Pemberi Tugas</td>
                        <td class="text-center" colspan="5">Pengukuran</td>
                        <td class="text-center" rowspan="2">Catatan Koreksi</td>
                        <td class="text-center" rowspan="2">IKI</td>
                    </tr>

                    <tr>
                        <td class="text-center">Kecepatan</td>
                        <td class="text-center">Ketuntasan</td>
                        <td class="text-center">Ketepatan</td>
                        <td class="text-center">rata2</td>
                        <td class="text-center">Penilaian Pimpinan</td>
                    </tr>
                </thead>

                <tbody>
                    <tr><td colspan="10">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td> 
                        <td>@{{ data.pemberi_tugas_nama }}</td>
                        <td>@{{ data.kecepatan }}</td>
                        <td>@{{ data.ketepatan }}</td>
                        <td>@{{ data.ketuntasan }}</td>
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>
                            <span>@{{ data.iki_label }}</span>
                        </td>
                    </tr>
                    
                    <tr><td colspan="10">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        
                        <td>@{{ data.kecepatan }}</td>
                        <td>@{{ data.ketepatan }}</td>
                        <td>@{{ data.ketuntasan }}</td>
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>@{{ data.iki_label }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>