<div id="load">
    <table class="table table-bordered">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th colspan="2">Saldo {{ config('app.months')[$month-1] }}</th>
                    <th colspan="2">Tambah {{ config('app.months')[$month] }}</th>
                    <th colspan="2">Saldo {{ config('app.months')[$month] }}</th>
                    <th>Harga Satuan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in datas" :key="data.id">
                    <td>@{{ index+1 }}</td>
                    <td>@{{ data.nama_barang }}</td>
                    
                    <td>@{{ data[label_op_awal] }}</td>
                    <td>@{{ data.satuan }}</td>
                    
                    <td>
                        <input class="form-control  form-control-sm" type="text" :name="'tambah_'+data.id" v-model="data[label_op_tambah]">
                    </td>
                    <td>@{{ data.satuan }}</td>
                    
                    
                    <td>@{{ parseInt(data[label_op_awal])+parseInt(data[label_op_tambah]) }}</td>
                    <td>@{{ data.satuan }}</td>

                    <td>@{{ data.harga_satuan }}</td>
                </tr>
            </tbody>
        @endif
    </table>
</div>