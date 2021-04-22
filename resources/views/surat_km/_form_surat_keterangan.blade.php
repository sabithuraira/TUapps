<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" class="form-control" name="nomor_urut" v-model="nomor_urut">
            <small class="text-info">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            <label>Kode Satuan Organisasi:</label>
            <input type="text" class="form-control" name="kode_unit_kerja" v-model="kode_unit_kerja">
        </div>
    </div>

    <div class="col-md-4 left">
        <div class="form-group">
            <label>Kode Klasifikasi:</label>
            <input type="text" class="form-control" name="klasifikasi_arsip" v-model="klasifikasi_arsip">
        </div>
    </div>
</div>

Nomor Surat: @{{ tingkat_keamanan }}-@{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} <small class="text-mute"><i>(Keterangan Format Nomor Surat: Nomor Urut/Kode Satuan Organisasi/Kode Klasifikasi Arsip/Bulan/Tahun)</i></small>
<input type="hidden" name="nomor" :value="tingkat_keamanan+'-'+nomor_urut+'/'+kode_unit_kerja+'/'+klasifikasi_arsip+'/'+bulan+'/'+tahun">
<br/><br/>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Isi Surat:</label>
            <textarea id="isi" class="summernote form-control" name="isi" rows="10"></textarea>
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