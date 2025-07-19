<div id="load">
    <form action="{{action('OpnamePersediaanController@print_persediaan')}}" method="post">
        @csrf 
        <input type="hidden"  v-model="month" name="p_month">
        <input type="hidden"  v-model="year" name="p_year">
        <button name="action" class="float-right ml-1 mr-1" type="submit" value="2"><i class="fa fa-file-excel-o"></i>&nbsp Cetak Excel&nbsp</button>
        <button name="action" class="float-right ml-1 mr-1" type="submit" value="3"><i class="fa fa-file-pdf-o"></i>&nbsp Cetak PDF&nbsp</button> 
    </form>
    <br/><br/>
    <table class="table-bordered" style="min-width:100%">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Barang</th>
                <th colspan="2">Saldo @{{ months[month-2] }}</th>
                <th colspan="2">Tambah  @{{ months[month-1] }}</th>
                <th colspan="2">Kurang  @{{ months[month-1] }}</th>
                <th colspan="2">Saldo  @{{ months[month-1] }}</th>
                <th>Harga Satuan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>@{{ index+1 }}</td>
                <td>@{{ data.nama_barang }}</td>
                
                <td>@{{ data.op_awal }}</td>
                <td>@{{ data.satuan }}</td>
                
                <td>
                    @{{ data.op_tambah }}
                    &nbsp <a href="#" role="button" @click="detailTambah" data-toggle="modal" 
                        :data-idbarang="data.id" :data-namabarang="data.nama_barang" data-jenis="1" 
                        data-target="#detail_tambah"> <i class="fa fa-search"></i></a>
                </td>
                <td>@{{ data.satuan }}</td>
                
                <td>
                    @{{ data.op_kurang }}
                    &nbsp <a href="#" role="button" @click="detailTambah" data-toggle="modal" 
                        :data-idbarang="data.id" :data-namabarang="data.nama_barang" data-jenis="2" 
                        data-target="#detail_tambah"> <i class="fa fa-search"></i></a>
                </td>
                <td>@{{ data.satuan }}</td>
                
                <td>@{{ parseInt(data.op_awal)+parseInt(data.op_tambah)-parseInt(data.op_kurang) }}</td>
                <td>@{{ data.satuan }}</td>

                <td align="right">@{{ moneyFormat(data.harga_satuan) }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal" id="detail_tambah" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b class="title" id="defaultModalLabel">@{{ headerOnDetail }}</b>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Tgl</th>
                            <th>Tgl Dokumen</th>
                            <th v-if="form_current_jenis==1">Penyedia</th>
                            <th v-if="form_current_jenis==2">Unit Kerja</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in list_detail" :key="data.id">
                            <td class="text-center">@{{ index+1 }}</td>
                            <td class="text-center">@{{ dateOnlyFormat(data.tanggal) }}</td>
                            <td class="text-center">@{{ dateOnlyFormat(data.tanggal_dokumen) }}</td>
                            <template v-if="form_current_jenis==1">
                                <td>@{{ data.nama_penyedia }}</td>
                                <td class="text-center">@{{ data.jumlah_tambah }}</td>
                                <td>@{{ data.harga_tambah }}</td>
                                <td>
                                    <a href="#" v-on:click="updateBarangMasuk" :data-id="data.id" 
                                        :data-idbarang="data.id_barang" :data-jumlah="data.jumlah_tambah" 
                                        :data-namapenyedia="data.nama_penyedia" :data-tanggal="data.tanggal"
                                        :data-tanggal_dokumen="data.tanggal_dokumen"
                                        :data-totalharga="data.harga_tambah"
                                        data-toggle="modal" data-target="#add_pengurangan"> <i class="fa fa-pencil-square-o"></i></a>
                                </td>
                            </template>
                            <template v-if="form_current_jenis==2">
                                <td>
                                    <div class="text-danger" v-if="data.unit_kerja4==null">
                                        BARANG USANG
                                    </div>
                                    <div v-else>
                                        @{{ data.unit_kerja.nama }}
                                    </div>
                                </td>
                                <td class="text-center">@{{ data.jumlah_kurang }}</td>
                                <td>@{{ data.harga_kurang }}</td>
                                <td>
                                    <a href="#" v-on:click="updateBarangKeluar" :data-id="data.id" 
                                        :data-idbarang="data.id_barang" :data-jumlah="data.jumlah_kurang" 
                                        :data-unitkerja="data.unit_kerja4" :data-tanggal="data.tanggal"
                                        :data-tanggal_dokumen="data.tanggal_dokumen"
                                        
                                        :data-keterangan_usang="data.keterangan_usang"
                                        data-toggle="modal" data-target="#add_pengurangan"> <i class="fa fa-pencil-square-o"></i></a>
                                </td>
                            </template>
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