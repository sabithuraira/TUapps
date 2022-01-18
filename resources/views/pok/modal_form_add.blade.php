<div class="modal" id="modal_form_add" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"><b>Tambah POK</b></div>
            <div class="modal-body">
                <div class="form-group">
                    Jenis yang ditambahkan: 
                    <div class="form-line">
                        <select class="form form-control" @change="getListPok(1)" v-model="form_add.jenis_form">
                            <option value="1">Program</option>
                            <option value="2">Aktivitas</option>
                            <option value="3">KRO</option>
                            <option value="4">RO</option>
                            <option value="5">Komponen</option>
                            <option value="6">Sub Komponen</option>
                            <option value="7">Mata Anggaran</option>
                            <option value="8">Rincian Anggaran</option>
                        </select>
                        
                        <small class="muted">
                            Revisi "rincian anggaran" akan berubah dan tampil setelah melakukan proses "SIMPAN REVISI"
                        </small>
                    </div>
                </div>
                
                <div v-show="form_add.jenis_form>=2">
                    <div class="form-group">
                        Program: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(2)" v-model="form_add.program">
                                <option v-for="(data, index) in form_add.list_program" :value="data.id" :key="'program_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <template v-if="form_add.jenis_form>=3">
                    <div class="form-group">
                        Aktivitas: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(3)" v-model="form_add.aktivitas">
                                <option v-for="(data, index) in form_add.list_aktivitas" :value="data.id" :key="'aktivitas_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <template v-if="form_add.jenis_form>=4">
                    <div class="form-group">
                        KRO: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(4)" v-model="form_add.kro">
                                <option v-for="(data, index) in form_add.list_kro" :value="data.id" :key="'kro_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <template v-if="form_add.jenis_form>=5">
                    <div class="form-group">
                        RO: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(5)" v-model="form_add.ro">
                                <option v-for="(data, index) in form_add.list_ro" :value="data.id" :key="'ro_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <template v-if="form_add.jenis_form>=6">
                    <div class="form-group">
                        Komponen: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(6)" v-model="form_add.komponen">
                                <option v-for="(data, index) in form_add.list_komponen" :value="data.id" :key="'komponen_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <template v-if="form_add.jenis_form>=7">
                    <div class="form-group">
                        Sub Komponen: 
                        <div class="form-line">
                            <select class="form form-control" @change="getListPok(7)"  v-model="form_add.sub_komponen">
                                <option v-for="(data, index) in form_add.list_sub_komponen" :value="data.id" :key="'sub_komponen_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <template v-if="form_add.jenis_form>=8">
                    <div class="form-group">
                        Mata Anggaran: 
                        <div class="form-line">
                            <select class="form form-control" v-model="form_add.mata_anggaran">
                                <option v-for="(data, index) in form_add.list_mata_anggaran" :value="data.id" :key="'mata_anggaran_'+data.id">
                                    @{{ data.kode }} - @{{ data.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </template>
                
                <div v-show="form_add.jenis_form!=''">
                    <template v-if="form_add.jenis_form<8">
                        <div class="form-group">
                            Kode yang ditambahkan: 
                            <div class="form-line">
                                <input type="text" class="form form-control" v-model="form_add.rincian_kode" >
                            </div>
                        </div>
                    </template>
                    
                    <div class="form-group">
                        Rincian yang ditambahkan: 
                        <div class="form-line">
                            <input type="text" class="form form-control" v-model="form_add.rincian_label" >
                        </div>
                    </div>
                </div>

                <template v-if="form_add.jenis_form==8 || form_add.jenis_form==3 || form_add.jenis_form==4">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            Volume:
                            <div class="form-line">
                                <input type="number" v-model="form_add.rincian_volume" class="form-control">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            Satuan:
                            <div class="form-line">
                                <input type="text" v-model="form_add.rincian_satuan" class="form-control">
                            </div>
                        </div>
                        <template v-if="form_add.jenis_form==8">
                            <div class="col-md-4">
                                Harga Satuan:
                                <div class="form-line">
                                    <input type="number" v-model="form_add.rincian_harga_satuan" class="form-control">
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" v-on:click="savePokBaru">SAVE</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>