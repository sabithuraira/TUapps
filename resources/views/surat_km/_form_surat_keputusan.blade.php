<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" class="form-control" name="nomor_urut" v-model="form.nomor_urut">
            <small class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>Nomor:</label>
            <input type="text" class="form-control" name="nomor" v-model="form.nomor">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Tentang:</label>
            <textarea id="tentang" class="summernote form-control" name="tentang" rows="3"></textarea>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Menimbang:</label>
            <textarea id="menimbang" class="summernote form-control" name="menimbang" rows="10"></textarea>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Mengingat:</label>
            <textarea id="mengingat" class="summernote form-control" name="mengingat" rows="10"></textarea>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Menetapkan:</label>
            <textarea id="menetapkan" class="summernote form-control" name="menetapkan" rows="10"></textarea>
        </div>
    </div>
</div>


<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>KEPUTUSAN:</label>
            <button type="button" class="btn btn-info" @click="addKeputusan">&nbsp; Tambah</button><br/><br/>                   
            <table class="table-bordered m-b-0" style="min-width:100%">
                
                <tr v-for="(data, index) in keputusan" :key="'keputusan'+index">
                    <td class="text-center">@{{ list_angka_keputusan[index] }}</td>
                    <td><textarea class="form-control" rows="3" v-model="data.isi"></textarea></td>
                    <input type="hidden" v-model="data.isi" :name="'keputusan'+data.id">
                </tr>
                <input type="hidden" :value="keputusan.length" name="jumlah_keputusan">
            </table>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Tembusan:</label>
            <textarea id="tembusan" class="summernote form-control" name="tembusan" rows="10"></textarea>
        </div>
    </div>
</div>

<label>Ditetapkan:</label>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Tempat:<br/>
            <input type="text" class="form-control" name="ditetapkan_di" v-model="form.ditetapkan_di">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Tanggal:<br/>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" name="ditetapkan_tanggal" id="ditetapkan_tanggal" v-model="form.ditetapkan_tanggal">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="ditetapkan_nama"  v-model="form.ditetapkan_nama">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="ditetapkan_oleh"  v-model="form.ditetapkan_oleh">
        </div>
    </div>
</div>