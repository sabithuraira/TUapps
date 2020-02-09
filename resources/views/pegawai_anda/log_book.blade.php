
<div class="tab-pane" id="log_book">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 left-box">

            <div class="form-group">
                <label>Rentang Waktu:</label>
                
                <div class="input-daterange input-group" data-provide="datepicker">
                    <input type="text" class="input-sm form-control" v-model="start" id="start">
                    <span class="input-group-addon">&nbsp sampai dengan &nbsp</span>
                    
                    <input type="text" class="input-sm form-control" v-model="end" id="end">
                </div>
            </div>
        </div>
    </div>

    <section class="datas">
        <div class="table-responsive">
            <table class="table m-b-0">
                <tbody v-for="(data, index) in all_dates" :key="data.val">
                    <tr >
                        <th colspan="3">
                            @{{ data.label }}
                        </th>
                    </tr>

                    <tr v-for="(data2, index2) in list_times" :key="data2.id">
                        <td>
                            <template v-if="getId(data.val, data2.id)!=0">
                                <i v-on:click="komentar" data-toggle="modal" data-target="#form_modal" class="btn_comment text-success icon-bubbles" :data-id="getId(data.val, data2.id)"></i>
                            </template>
                            
                            <template v-if="getId(data.val, data2.id)==0">
                                &nbsp &nbsp &nbsp
                            </template>

                            &nbsp &nbsp &nbsp
                            @{{ data2.waktu }}
                        </td>
                        <td v-html="showIsi(data.val, data2.id)"></td>
                        <td v-html="showKomentar(data.val, data2.id)"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</div>