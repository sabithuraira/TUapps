<div class="tab-pane" id="ckp_penilaian">
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12 left-box">
            <div class="form-group">
                <label>Bulan:</label>

                <div class="input-group">
                <select class="form-control  form-control-sm" v-model="ckp_month" name="month">
                        @foreach ( config('app.months') as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 right-box">
            <div class="form-group">
                <label>Tahun:</label>

                <div class="input-group">
                <select class="form-control  form-control-sm"  v-model="ckp_year" name="year">
                    @for ($i=2019;$i<=date('Y');$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                </div>
            </div>
        </div>
    </div>

    <section class="datas">
        <div class="table-responsive">
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
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'u_kecepatan'+data.id" v-model="data.kecepatan"></td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'u_ketepatan'+data.id" v-model="data.ketepatan"></td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'u_ketuntasan'+data.id" v-model="data.ketuntasan"></td>
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'u_penilaian_pimpinan'+data.id" v-model="data.penilaian_pimpinan"></td>
                        <td><input class="form-control  form-control-sm" type="text" :name="'u_catatan_koreksi'+data.id" v-model="data.catatan_koreksi"></td>
                        <td>
                            <span>@{{ data.iki_label }}</span>
                        </td>
                    </tr>
                    
                    <tr><td colspan="9">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'t_kecepatan'+data.id" v-model="data.kecepatan"></td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'t_ketepatan'+data.id" v-model="data.ketepatan"></td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'t_ketuntasan'+data.id" v-model="data.ketuntasan"></td>
                        <td>@{{ nilaiRata2(data.kecepatan,data.ketepatan,data.ketuntasan) }}</td>
                        <td><input class="form-control  form-control-sm" type="number" max="100" :name="'t_penilaian_pimpinan'+data.id" v-model="data.penilaian_pimpinan"></td>
                        <td><input class="form-control  form-control-sm" type="text" :name="'t_catatan_koreksi'+data.id" v-model="data.catatan_koreksi"></td>
                        <td>@{{ data.iki }}</td>
                    </tr>
                </tbody>
            </table>
        </div>    
    </section>
</div>