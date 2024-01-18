<div id="load">
    <form action="{{action('OpnamePersediaanController@print_kartukendali_q')}}" method="post">
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
                    <th>TGL</th>
                    <th>URAIAN</th>
                    <th>JUMLAH BARANG MASUK (DEBET)</th>
                    <th>JUMLAH BARANG KELUAR (DEBET)</th>
                    <th>JUMLAH BARANG SALDO</th>
                </tr>
                
                <tr class="text-center">
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    <td>E</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">SALDO AWAL</td>
                    <td></td><td></td>
                    <td align="right">@{{ persediaan.saldo_awal }}</td>
                </tr>
                <tr align="right" v-for="(data, index) in datas" :key="data.id">
                    <td align="center">@{{ dateFormat(data.tanggal) }}</td>
                    <td align="left" style ="word-break:break-all;">
                        <template v-if="data.label==null"><span class="text-danger"><b>BARANG USANG </b></span></template>
                        <template v-else>@{{ data.label }}</template>
                    </td>
                    <template v-if="data.jenis==2">
                        <td></td>
                        <td>@{{ data.jumlah }}</td>
                    </template>
                    
                    <template v-if="data.jenis==1">
                        <td>@{{ data.jumlah }}</td>
                        <td></td>  
                    </template>

                    <td>@{{ data.saldo_jumlah }}</td>
                </tr>
                
                <tr align="right">
                    <td align="center" colspan="2">JUMLAH</td>
                    <td>@{{ persediaan.saldo_tambah }}</td>
                    <td>@{{ persediaan.saldo_kurang }}</td>
                    <td>@{{ persediaan.saldo_tambah+persediaan.saldo_awal-persediaan.saldo_kurang }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>