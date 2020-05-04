<div class="tab-pane show active" id="ckp">
    <section class="datas">
        <div class="table-responsive">
            <br/><br/>
            <table class="table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $ckp->attributes()['uraian'] }}</td>
                        <td class="text-center" rowspan="2">{{ $ckp->attributes()['satuan'] }}</td>
                        
                        <td class="text-center" colspan="3">Kuantitas</td>
                        <td class="text-center" rowspan="2">Tingkat Kualitas</td>
                        
                        <td class="text-center" rowspan="2">{{ $ckp->attributes()['kode_butir'] }}</td>
                        <td class="text-center" rowspan="2">{{ $ckp->attributes()['angka_kredit'] }}</td>
                        <td class="text-center" rowspan="2">{{ $ckp->attributes()['keterangan'] }}</td>
                    </tr>

                    <tr>
                        <td class="text-center" >Target</td>
                        <td class="text-center" >Realisasi</td>
                        <td class="text-center" >%</td>
                    </tr>
                </thead>

                <tbody>
                    <tr><td colspan="10">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                        
                        <td>@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>
                    
                    <tr><td colspan="10">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td>@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                        <td>@{{ data.kualitas }} %</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>

                    <template>
                        <tr>
                            <td colspan="5"><b>JUMLAH</b></td>
                            <td class="text-center">@{{ total_kuantitas }} %</td>
                            <td class="text-center">@{{ total_kualitas }} %</td>
                            <td colspan="9"></td>
                        </tr>
                        
                        <tr>
                            <td colspan="5"><b>CAPAIAN KINERJA PEGAWAI (CKP)</b></td>
                            <td class="text-center" colspan="2">@{{ ((Number(total_kuantitas)+Number(total_kualitas))/2).toFixed(2) }}</td>
                            <td colspan="9"></td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>    
    </section>
</div>