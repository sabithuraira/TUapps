<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th class="text-center">Periode Aktif</th>
                <th class="text-center">Aturan Validasi</th>
                <th class="text-center">Satuan Kerja</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination && pagination.per_page ? (pagination.current_page - 1) * pagination.per_page + index + 1 : index + 1) }}</td>
                <td>
                    <span>@{{ data.question }}</span>
                    <span class="badge badge-secondary ml-1" style="font-size: 0.75rem;">@{{ getTypeQuestionLabel(data.type_question) }}</span>
                </td>
                <td class="text-center">@{{ formatDateId(data.start_active) }} — @{{ formatDateId(data.last_active) }}</td>
                <td class="text-center">@{{ data.validate_rule || '-' }}</td>
                <td class="text-center">@{{ data.satker }}</td>
                <td class="text-center">
                    <a :href="getHasilUrl(data.id)" class="btn btn-sm btn-info" title="Lihat Hasil">
                        <i class="fa fa-list-alt"></i> Hasil
                    </a>
                    <a href="#" role="button" v-on:click="updateData"
                        :data-id="data.id"
                        :data-question="data.question"
                        :data-type-question="data.type_question"
                        :data-start-active="data.start_active"
                        :data-last-active="data.last_active"
                        :data-validate-rule="data.validate_rule"
                        :data-satker="data.satker"
                        data-toggle="modal"
                        data-target="#form_modal"
                        class="btn btn-sm btn-default">
                        <i class="icon-pencil text-info"></i>
                    </a>
                    <a href="#" role="button" v-on:click="deleteData(data.id)" class="btn btn-sm btn-default">
                        <i class="fa fa-trash text-danger"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
