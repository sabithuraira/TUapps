<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" class="form-control" name="nomor_urut" v-model="nomor_urut">
            <small class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>Nomor:</label>
            <input type="text" class="form-control" name="nomor">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Tentang:</label>
            <textarea id="tentang" class="summernote form-control" name="tentang" rows="10"></textarea>
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
            <button href="" class="btn btn-info" @click="addKeputusan">&nbsp; Tambah</button><br/><br/>                   
            <table class="table-bordered m-b-0" style="min-width:100%">
                
                <tr v-for="(data, index) in keputusan" :key="'keputusan'+index">
                    <td><input class="form form-control" type="text" v-model="data.isi"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Tembusan:</label>
            <button href="" class="btn btn-info" @click="addTembusan">&nbsp; Tambah</button><br/><br/>                   
            <table class="table-bordered m-b-0" style="min-width:100%">
                
                <tr v-for="(data, index) in tembusan" :key="'tembusan'+index">
                    <td><input class="form form-control" type="text" v-model="data.isi"></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<label>Ditetapkan:</label>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Tempat:<br/>
            <input type="text" class="form-control" name="ditetapkan_di">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Tanggal:<br/>
            <input type="text" class="form-control" name="ditetapkan_tanggal">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="ditetapkan_nama">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="ditetapkan_oleh">
        </div>
    </div>
</div>