<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Kata Motivasi</th>
                <th class="text-center">Dikutip Dari</th>
                <th class="text-center">Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination ? (pagination.current_page - 1) * pagination.per_page + index + 1 : index + 1) }}</td>
                <td>@{{ data.kata_motivasi }}</td>
                <td>@{{ data.dikutip_dari }}</td>
                <td class="text-center">
                    <span v-if="data.is_active == 1" class="badge badge-success">Aktif</span>
                    <span v-else class="badge badge-secondary">Nonaktif</span>
                </td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData"
                        :data-id="data.id"
                        :data-kata-motivasi="data.kata_motivasi"
                        :data-dikutip-dari="data.dikutip_dari"
                        :data-is-active="data.is_active"
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
