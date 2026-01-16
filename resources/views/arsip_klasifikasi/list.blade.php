<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Kode</th>
                <th class="text-center">Kode 2</th>
                <th class="text-center">Kode 3</th>
                <th class="text-center">Kode 4</th>
                <th class="text-center">Kode Gabung</th>
                <th class="text-center">Judul</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}</td>
                <td class="text-center">@{{ data.kode }}</td>
                <td class="text-center">@{{ data.kode_2 || '-' }}</td>
                <td class="text-center">@{{ data.kode_3 || '-' }}</td>
                <td class="text-center">@{{ data.kode_4 || '-' }}</td>
                <td class="text-center">@{{ data.kode_gabung }}</td>
                <td>@{{ data.judul }}</td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData" 
                        :data-id="data.id"
                        :data-kode="data.kode"
                        :data-kode-2="data.kode_2"
                        :data-kode-3="data.kode_3"
                        :data-kode-4="data.kode_4"
                        :data-kode-gabung="data.kode_gabung"
                        :data-judul="data.judul"
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
                <b class="title" id="defaultModalLabel">Form Arsip Klasifikasi</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id_data">
                
                <div class="form-group">
                    Kode: <span class="text-danger">*</span>
                    <div class="form-line">
                        <input type="text" v-model="form_kode" class="form-control" maxlength="2" placeholder="Masukkan kode (2 karakter)">
                    </div>
                </div>

                <div class="form-group">
                    Kode 2:
                    <div class="form-line">
                        <input type="text" v-model="form_kode_2" class="form-control" maxlength="3" placeholder="Masukkan kode 2 (3 karakter)">
                    </div>
                </div>

                <div class="form-group">
                    Kode 3:
                    <div class="form-line">
                        <input type="text" v-model="form_kode_3" class="form-control" maxlength="3" placeholder="Masukkan kode 3 (3 karakter)">
                    </div>
                </div>

                <div class="form-group">
                    Kode 4:
                    <div class="form-line">
                        <input type="text" v-model="form_kode_4" class="form-control" maxlength="3" placeholder="Masukkan kode 4 (3 karakter)">
                    </div>
                </div>

                <div class="form-group">
                    Kode Gabung: <span class="text-danger">*</span>
                    <div class="form-line">
                        <input type="text" v-model="form_kode_gabung" class="form-control" placeholder="Masukkan kode gabung">
                    </div>
                </div>

                <div class="form-group">
                    Judul: <span class="text-danger">*</span>
                    <div class="form-line">
                        <textarea v-model="form_judul" class="form-control" rows="4" placeholder="Masukkan judul..."></textarea>
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
