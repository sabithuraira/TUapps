<div id="load">

    <form action="{{action('OpnamePersediaanController@print_persediaan')}}" method="post">
        @csrf 
        <input type="hidden"  v-model="month" name="p_month">
        <input type="hidden"  v-model="year" name="p_year">
        <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak &nbsp</button>
    </form>
    <br/><br/>
    <table class="table table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Barang</th>
                <th colspan="2">Saldo @{{ months[month-2] }}</th>
                <th colspan="2">Tambah  @{{ months[month-1] }}</th>
                <th>Kurang  @{{ months[month-1] }}</th>
                <th colspan="2">Saldo  @{{ months[month-1] }}</th>
                <th>Harga Satuan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>@{{ index+1 }}</td>
                <td>@{{ data.nama_barang }}</td>
                
                <td>@{{ data[label_op_awal] }}</td>
                <td>@{{ data.satuan }}</td>
                
                <td>@{{ data[label_op_tambah] }}</td>
                <td>@{{ data.satuan }}</td>
                
                <td class="text-center">
                    <u>@{{ data.pengeluaran }} @{{ data.satuan }}</u>
                    
                    <ul v-if="parseInt(data.pengeluaran)>0">
                        <li v-for="item in data.list_keluar" class="text-left">
                            <small>
                                <a href="#" v-on:click="updateBarangKeluar" :data-id="item.id" 
                                    :data-idbarang="item.id_barang" :data-jumlah="item.jumlah_kurang" 
                                    :data-unitkerja="item.unit_kerja.id" :data-tanggal="item.tanggal"
                                    data-toggle="modal" data-target="#add_pengurangan"> (@{{ item.jumlah_kurang }}) @{{ item.unit_kerja.nama }}</a>
                            </small>
                        </li>
                    </ul>
                </td>
                
                <td>@{{ parseInt(data[label_op_awal])+parseInt(data[label_op_tambah])-parseInt(data.pengeluaran) }}</td>
                <td>@{{ data.satuan }}</td>

                <td>@{{ data.harga_satuan }}</td>
            </tr>
        </tbody>
    </table>
</div>