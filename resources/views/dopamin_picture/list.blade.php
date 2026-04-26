<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th class="text-center">Judul</th>
                <th class="text-center">Gambar</th>
                <th class="text-center">Mulai Tayang</th>
                <th class="text-center">Selesai Tayang</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination ? (pagination.current_page - 1) * pagination.per_page + index + 1 : index + 1) }}</td>
                <td>@{{ data.title || '-' }}</td>
                <td class="text-center">
                    <img v-if="getPictureUrl(data)" :src="getPictureUrl(data)" alt="promoting picture" style="max-height:60px; max-width:120px;">
                    <span v-else>-</span>
                </td>
                <td class="text-center">@{{ data.start_date || '-' }}</td>
                <td class="text-center">@{{ data.end_date || '-' }}</td>
                <td class="text-center">
                    <a href="#" role="button" v-on:click="updateData(data.id)" data-toggle="modal" data-target="#form_modal">
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
