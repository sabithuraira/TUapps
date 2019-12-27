<div id="load">

    <form action="{{action('OpnamePersediaanController@print_kartukendali')}}" method="post">
        @csrf 
        <input type="hidden"  v-model="month" name="p_month">
        <input type="hidden"  v-model="year" name="p_year">
        <input type="hidden"  v-model="barang" name="p_barang">
        <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak &nbsp</button>
    </form>
    <br/><br/>
    <table class="table table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th rowspan="2">TGL</th>
                <th rowspan="2">URAIAN</th>
                <th colspan="3">MASUK (DEBET)</th>
                <th colspan="3">KELUAR (DEBET)</th>
                <th colspan="3">SALDO</th>
            </tr>
            
            <tr class="text-center">
                <th>JUMLAH BARANG</th>
                <th>HARGA SATUAN (Rp.)</th>
                <th>JUMLAH (Rp.)</th>
                <th>JUMLAH BARANG</th>
                <th>HARGA SATUAN (Rp.)</th>
                <th>JUMLAH (Rp.)</th>
                <th>JUMLAH BARANG</th>
                <th>HARGA SATUAN (Rp.)</th>
                <th>JUMLAH (Rp.)</th>
            </tr>
            
            <tr class="text-center">
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>E = (CxD)</th>
                <th>F</th>
                <th>G</th>
                <th>H = (FxG)</th>
                <th>I = (SA+C-F)</th>
                <th>J = (SA+E-H)</th>
                <th>K = (J/I)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">SALDO AWAL</td>
                <td></td><td></td><td></td><td></td><td></td><td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr v-for="(data, index) in datas" :key="data.id">
                <td>@{{ dateFormat(data.tanggal) }}</td>
                <td>@{{ data.nama }}</td>
                <td></td><td></td><td></td>
                
                <td>@{{ data.jumlah_kurang }}</td>
                <td align="right">@{{ moneyFormat(data.harga_satuan) }}</td>
                <td align="right">@{{ moneyFormat(data.harga_kurang) }}</td>
                
                <td></td>
                <td></td>
                <td></td>
                
            </tr>
        </tbody>
    </table>
</div>