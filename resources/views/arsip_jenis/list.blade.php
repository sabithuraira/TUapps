<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Title</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Masa Retensi (Tahun)</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}</td>
                <td>@{{ data.title }}</td>
                <td>@{{ data.deskripsi }}</td>
                <td class="text-center">@{{ data.masa_retensi_tahun }}</td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData" 
                        :data-id="data.id"
                        :data-title="data.title"
                        :data-deskripsi="data.deskripsi"
                        :data-masa-retensi-tahun="data.masa_retensi_tahun"
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
                <b class="title" id="defaultModalLabel">Form Arsip Jenis</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id_data">
                
                <div class="form-group">
                    Title: <span class="text-danger">*</span>
                    <div class="form-line">
                        <input type="text" v-model="form_title" class="form-control" placeholder="Masukkan title">
                    </div>
                </div>

                <div class="form-group">
                    Deskripsi: <span class="text-danger">*</span>
                    <div class="form-line">
                        <textarea v-model="form_deskripsi" class="form-control" rows="4" placeholder="Masukkan deskripsi..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    Masa Retensi (Tahun): <span class="text-danger">*</span>
                    <div class="form-line">
                        <input type="number" v-model="form_masa_retensi_tahun" class="form-control" placeholder="Masukkan masa retensi dalam tahun" min="1">
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

