<div class="tab-pane" id="ckp_penilaian">
    <section class="datas">
        <div class="table-responsive">
            <br/><br/>
            <table class="table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <td rowspan="2">No</td>
                        <td class="text-center" style="width:100%" rowspan="2">{{ $ckp->attributes()['uraian'] }}</td>
                        
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
                    <tr><td colspan="9">UTAMA</td></tr>
                    <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td> 
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
                    
                    <tr><td colspan="9">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{ data.kecepatan }}</td>
                        <td>@{{ data.ketepatan }}</td>
                        <td>@{{ data.ketuntasan }}</td>
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td>@{{ data.penilaian_pimpinan }}</td>
                        <td>@{{ data.catatan_koreksi }}</td>
                        <td>@{{ data.iki }}</td>
                    </tr>
                </tbody>
            </table>
        </div>    
    </section>
</div>