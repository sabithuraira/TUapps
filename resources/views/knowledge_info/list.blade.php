<div class="table-responsive">
    <table class="table-bordered m-b-0" style="min-width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th class="text-center">Kategori</th>
                <th class="text-center">Tag</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ (pagination && pagination.per_page ? (pagination.current_page - 1) * pagination.per_page + index + 1 : index + 1) }}</td>
                <td>@{{ data.title }}</td>
                <td class="text-center">@{{ data.category || '-' }}</td>
                <td class="text-center">@{{ data.tag || '-' }}</td>
                <td class="text-center">
                    <a :href="'{{ url("knowledge_info") }}/' + data.id" class="btn btn-sm btn-info" title="Lihat Detail"><i class="fa fa-eye"></i></a>
                    <a :href="'{{ url("knowledge_info") }}/' + data.id + '/edit'" class="btn btn-sm btn-default" title="Ubah"><i class="icon-pencil text-info"></i></a>
                    <a href="#" role="button" v-on:click="deleteData(data.id)" class="btn btn-sm btn-default" title="Hapus"><i class="fa fa-trash text-danger"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                <h4 class="text-center">Mohon tunggu...</h4>
            </div>
        </div>
    </div>
</div>
