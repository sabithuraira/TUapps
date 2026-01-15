<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Content</th>
                <th class="text-center">Status Verifikasi</th>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ index+1 }}</td>
                <td>@{{ data.content }}</td>
                <td class="text-center">
                    <span v-if="data.status_verifikasi == 1" class="badge badge-warning">Belum Verifikasi</span>
                    <span v-if="data.status_verifikasi == 2" class="badge badge-success">Disetujui</span>
                    <span v-if="data.status_verifikasi == 3" class="badge badge-danger">Tidak Disetujui</span>
                </td>
                <td class="text-center">@{{ formatDate(data.created_at) }}</td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData" 
                        :data-id="data.id"
                        :data-content="data.content"
                        :data-status-verifikasi="data.status_verifikasi"
                        data-toggle="modal" 
                        data-target="#form_modal">
                        <i class="icon-pencil text-info"></i>
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
                <b class="title" id="defaultModalLabel">Form Curhat Anonim</b>
            </div>
            <div class="modal-body">
                <input type="hidden" v-model="form_id_data">
                
                <div class="form-group">
                    Content: <span class="text-danger">*</span>
                    <div class="form-line">
                        <textarea v-model="form_content" class="form-control" rows="5" placeholder="Masukkan curhat..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    Status Verifikasi:
                    <div class="form-line">
                        <select class="form-control" v-model="form_status_verifikasi">
                            @if(isset($list_status_verifikasi))
                                @foreach($list_status_verifikasi as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            @else
                                <option value="1">Belum Verifikasi</option>
                                <option value="2">Disetujui</option>
                                <option value="3">Tidak Disetujui</option>
                            @endif
                        </select>
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


