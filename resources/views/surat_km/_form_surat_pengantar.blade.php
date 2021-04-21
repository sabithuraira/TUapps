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
            <label>Tingkat Keamanan:</label>
            <select class="form-control" v-model="tingkat_keamanan" name="tingkat_keamanan">
                <option value="">- Pilih Tingkat Keamanan -</option>
                @foreach ($model->listTingkatKeamanan as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Kode Satuan Organisasi:</label>
            <input type="text" class="form-control" name="kode_unit_kerja" v-model="kode_unit_kerja">
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>Kode Klasifikasi:</label>
            <input type="text" class="form-control" name="kode_klasifikasi_arsip" v-model="kode_klasifikasi_arsip">
        </div>
    </div>
</div>

Nomor Surat: @{{ tingkat_keamanan }}-@{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ kode_klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} <small class="text-mute"><i>(Keterangan Format Nomor Surat: Nomor Urut/Kode Satuan Organisasi/Kode Klasifikasi Arsip/Bulan/Tahun)</i></small>
<input type="hidden" name="nomor" :value="tingkat_keamanan+'-'+nomor_urut+'/'+kode_unit_kerja+'/'+kode_klasifikasi_arsip+'/'+bulan+'/'+tahun">
<br/><br/>

<label>Kepada:</label>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="kepada">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Tempat:<br/>
            <input type="text" class="form-control" name="kepada_di">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Isi Surat:</label>
            <textarea id="isi" class="summernote form-control" name="isi" rows="10"></textarea>
        </div>
    </div>
</div>

<label>Ditetapkan Oleh:</label>
<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="ditetapkan_oleh">
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="ditetapkan_nama">
        </div>
    </div>

    <div class="col-md-4 left">
        <div class="form-group">
            NIP:<br/>
            <input type="text" class="form-control" name="ditetapkan_nip">
        </div>
    </div>
</div>



<label>Diterima:</label>
<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            Tanggal:<br/>
            <input type="text" class="form-control" name="diterima_tanggal">
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            Nama Penerima:<br/>
            <input type="text" class="form-control" name="diterima_jabatan">
        </div>
    </div>

    <div class="col-md-4 left">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="diterima_nama">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            NIP:<br/>
            <input type="text" class="form-control" name="diterima_nip">
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            No HP:<br/>
            <input type="text" class="form-control" name="diterima_no_hp">
        </div>
    </div>
</div>
