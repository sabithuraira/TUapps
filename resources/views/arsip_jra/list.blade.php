<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Label JRA</th>
                <th class="text-center">Deskripsi JRA</th>
                <th class="text-center">Aktif (Tahun)</th>
                <th class="text-center">Inaktif (Tahun)</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination ? (pagination.current_page - 1) * pagination.per_page + index + 1 : index + 1) }}</td>
                <td>@{{ data.label_jra }}</td>
                <td>@{{ data.deskripsi_jra }}</td>
                <td class="text-center">@{{ data.aktif_tahun }}</td>
                <td class="text-center">@{{ data.inaktif_tahun }}</td>
                <td>@{{ data.keterangan }}</td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData" 
                        :data-id="data.id"
                        :data-label-jra="data.label_jra"
                        :data-deskripsi-jra="data.deskripsi_jra"
                        :data-aktif-tahun="data.aktif_tahun"
                        :data-inaktif-tahun="data.inaktif_tahun"
                        :data-keterangan="data.keterangan"
                        data-toggle="modal" 
                        data-target="#form_modal">
                        <i class="icon-pencil text-info"></i>
                    </a>
                    &nbsp;
                    <a href="#" role="button" v-on:click="deleteData(data.id)">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal Form -->
<div class="modal" id="form_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">Form JRA (Jadwal Retensi Arsip)</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id_data">
                
                <div class="form-group">
                    Label JRA: <span class="text-danger">*</span>
                    <div class="form-line">
                        <input type="text" v-model="form_label_jra" class="form-control" placeholder="Masukkan label JRA" maxlength="255">
                    </div>
                </div>

                <div class="form-group">
                    Deskripsi JRA:
                    <div class="form-line">
                        <textarea v-model="form_deskripsi_jra" class="form-control" rows="4" placeholder="Masukkan deskripsi JRA..."></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            Aktif (Tahun):
                            <div class="form-line">
                                <input type="number" v-model="form_aktif_tahun" class="form-control" placeholder="Tahun aktif" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            Inaktif (Tahun):
                            <div class="form-line">
                                <input type="number" v-model="form_inaktif_tahun" class="form-control" placeholder="Tahun inaktif" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    Keterangan:
                    <div class="form-line">
                        <textarea v-model="form_keterangan" class="form-control" rows="2" placeholder="Keterangan (opsional)..."></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="save-btn">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

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
