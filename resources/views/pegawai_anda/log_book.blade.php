
<div class="tab-pane" id="log_book">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 left-box">

            <div class="form-group">
                <label>Rentang Waktu:</label>
                
                <div class="input-daterange input-group" data-provide="datepicker">
                    <input type="text" class="input-sm form-control" v-model="start" id="start">
                    <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                    
                    <input type="text" class="input-sm form-control" v-model="end" id="end">
                </div>
            </div>
        </div>
    </div>

    <section class="datas">
        <div class="table-responsive">
            <table class="table table-sm table-bordered m-b-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Mulai</th>
                        <th class="text-center">Selesai</th>
                        <th class="text-center">Isi</th>
                        <th class="text-center">Hasil</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(data, index) in datas" :key="data.id">
                        <td>@{{ index+1 }}</td>
                        <td class="text-center">@{{ data.tanggal }}</td>
                        <td class="text-center">@{{ data.waktu_mulai }}</td>
                        <td class="text-center">@{{ data.waktu_selesai }}</td>
                        <td>@{{ data.isi }}</td>
                        <td>@{{ data.hasil }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>