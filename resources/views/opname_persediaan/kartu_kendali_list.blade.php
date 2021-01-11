<div id="load">
    <form action="{{action('OpnamePersediaanController@print_kartukendali')}}" method="post">
        @csrf 
        <input type="hidden"  v-model="month" name="p_month">
        <input type="hidden"  v-model="year" name="p_year">
        <input type="hidden"  v-model="barang" name="p_barang">
        <button name="action" class="float-right" type="submit" value="2"><i class="icon-printer"></i>&nbsp Cetak &nbsp</button>
    </form>
    <br/><br/>
    <div class="table-responsive-sm">
        <table class="table-bordered" style="min-width:100%">
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
                    <th>JUMLAH (Rp.)</th>
                    <th>HARGA SATUAN (Rp.)</th>
                </tr>
                
                <tr class="text-center">
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    <td>E = (CxD)</td>
                    <td>F</td>
                    <td>G</td>
                    <td>H = (FxG)</td>
                    <td>I = (SA+C-F)</td>
                    <td>J = (SA+E-H)</td>
                    <td>K = (J/I)</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">SALDO AWAL</td>
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                    <td align="right">@{{ persediaan.saldo_awal }}</td>
                    <td align="right">@{{ moneyFormat(persediaan.harga_awal) }}</td>
                    <td align="right">@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                </tr>
                <tr align="right" v-for="(data, index) in datas" :key="data.id">
                    <td align="center">@{{ dateFormat(data.tanggal) }}</td>
                    <td align="left" style ="word-break:break-all;">@{{ data.label }}</td>
                    <template v-if="data.jenis==2">
                        <td></td><td></td><td></td>
                        
                        <td>@{{ data.jumlah }}</td>
                        <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                        <td>@{{ moneyFormat(data.harga) }}</td>
                    </template>
                    
                    <template v-if="data.jenis==1">
                        <td>@{{ data.jumlah }}</td>
                        <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                        <td>@{{ moneyFormat(data.harga) }}</td>

                        <td></td><td></td><td></td>    
                    </template>

                    <td>@{{ data.saldo_jumlah }}</td>
                    <td>@{{ moneyFormat(data.saldo_harga) }}</td>
                    <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                    
                </tr>
                
                <tr align="right">
                    <td align="center" colspan="2">JUMLAH</td>
                    <td>@{{ persediaan.saldo_tambah }}</td>
                    <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                    <td>@{{ moneyFormat(persediaan.harga_tambah) }}</td>
                    
                    <td>@{{ persediaan.saldo_kurang }}</td>
                    <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                    <td>@{{ moneyFormat(persediaan.harga_kurang) }}</td>
                    
                    <td>@{{ persediaan.saldo_tambah+persediaan.saldo_awal-persediaan.saldo_kurang }}</td>
                    <td>
                        @{{ moneyFormat(parseFloat(persediaan.harga_tambah)+parseFloat(persediaan.harga_awal)-parseFloat(persediaan.harga_kurang))  }}
                    </td>
                    <td>@{{ moneyFormat(detail_barang.harga_satuan) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>