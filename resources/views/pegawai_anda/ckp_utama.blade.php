<div class="tab-pane show active" id="ckp">
    <div class="row clearfix">
        <div class="col-lg-6 col-md-12 left-box">
            <div class="form-group">
                <label>Bulan:</label>

                <div class="input-group">
                <select class="form-control  form-control-sm"  v-model="ckp_month" name="month">
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
            <br/><br/>
            <table class="table table-sm table-bordered m-b-0">
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
                        <td class="text-center">@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                        <td><input class="form-control  form-control-sm" type="number" :name="'u_kualitas'+data.id" v-model="data.kualitas">%</td>
                        <td>@{{ data.kode_butir }}</td>
                        <td>@{{ data.angka_kredit }}</td>
                        <td>@{{ data.keterangan }}</td>
                    </tr>
                    
                    <tr><td colspan="10">TAMBAHAN</td></tr>
                    <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td>@{{ data.uraian }}</td>
                        <td>@{{data.satuan }}</td>
                        <td class="text-center">@{{data.target_kuantitas }}</td>
                        <td class="text-center">@{{ data.realisasi_kuantitas }}</td>
                        <td class="text-center">@{{ ((data.realisasi_kuantitas/data.target_kuantitas)>1) ? 100 : (data.realisasi_kuantitas/data.target_kuantitas*100).toFixed(1) }}%</td>
                        <td><input class="form-control  form-control-sm" type="number" :name="'t_kualitas'+data.id" v-model="data.kualitas">%</td>
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
                    </template>
                </tbody>
            </table>
        </div>    
    </section>
</div>