
<div class="modal" id="modal_realisasi" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">@{{ form_transaksi.rincian_label }}</b>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Judul</th>
                            <th>Jumlah Estimasi</th>
                            <th>Ket. Estimasi</th>
                            <th>Jumlah Realisasi</th>
                            <th>Ket. Realisasi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in list_transaksi" :key="data.id">
                            <td class="text-center">@{{ index+1 }}</td>
                            <td>@{{ data.label }}</td>
                            <td>Rp. @{{ moneyFormat(data.total_estimasi) }}</td>
                            <td>@{{ data.ket_estimasi }}</td>
                            <td>Rp. @{{ moneyFormat(data.total_realisasi) }}</td>
                            <td>@{{ data.ket_realisasi }}</td>
                            <td>
                                @hasanyrole('superadmin|pengelola_realisasi')
                                    <a href="#" v-on:click="setTransaksiDetail" :data-id="data.id" 
                                        :data-label="data.label" :data-ket_estimasi="data.ket_estimasi" 
                                        :data-total_estimasi="data.total_estimasi" :data-ket_realisasi="data.ket_realisasi" 
                                        :data-total_realisasi="data.total_realisasi"
                                        data-toggle="modal" data-target="#modal_form_realisasi"> <i class="fa fa-pencil-square-o"></i></a>
                                @endhasanyrole
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>