<div id="load">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Barang</th>
                <th>Tanggal Permintaan</th>
                <th>Tanggal Penyerahan</th>
                <th>Jumlah Diminta</th>
                <th>Jumlah Disetujui</th>
                <th>Unit Kerja</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-if="datas.length == 0">
                <td colspan="10" class="text-center">Tidak ada data</td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td class="text-center">@{{ index+1 }}</td>
                <td>@{{ data.master_barang ? data.master_barang.nama_barang : '-' }}</td>
                <td class="text-center">@{{ formatDate(data.tanggal_permintaan) }}</td>
                <td class="text-center">@{{ formatDate(data.tanggal_penyerahan) }}</td>
                <td class="text-center">@{{ data.jumlah_diminta }}</td>
                <td class="text-center">@{{ data.jumlah_disetujui || '-' }}</td>
                <td>
                    <div>@{{ data.unit_kerja4 ? data.unit_kerja4.nama : '-' }}</div>
                    <div class="text-muted" style="font-size: 0.85em;" v-if="data.created_by && typeof data.created_by === 'object' && data.created_by.name">
                        <i class="icon-user"></i> @{{ data.created_by.name }}
                    </div>
                </td>
                <td class="text-center">
                    <span v-if="data.status_aktif == 1" class="badge badge-info">Diajukan</span>
                    <span v-if="data.status_aktif == 2" class="badge badge-success">Disetujui</span>
                </td>
                <td class="text-center">
                    <a href="#" v-if="data.status_aktif != 2" v-on:click="updateData" 
                        :data-id="data.id"
                        :data-id-barang="data.id_barang"
                        :data-tanggal-permintaan="data.tanggal_permintaan"
                        :data-tanggal-penyerahan="data.tanggal_penyerahan || ''"
                        :data-jumlah-diminta="data.jumlah_diminta"
                        :data-jumlah-disetujui="data.jumlah_disetujui || ''"
                        :data-unit-kerja="data.unit_kerja"
                        :data-unit-kerja4="data.unit_kerja4"
                        :data-status-aktif="data.status_aktif"
                        data-toggle="modal" 
                        data-target="#form_modal">
                        <i class="fa fa-pencil-square-o text-info"></i>
                    </a>
                    <a :href="'{{ url('opname_permintaan/print') }}/' + data.id" class="ml-1" target="_blank" title="Cetak PDF">
                        <i class="fa fa-file-pdf-o text-danger"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>