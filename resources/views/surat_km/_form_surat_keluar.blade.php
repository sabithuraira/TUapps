<div class="row clearfix">
    <div class="col-md-12 left">
        <div class="form-group">
            <label>{{ $model->attributes()['perihal'] }}:</label>
            <input type="text" required class="form-control {{($errors->first('perihal') ? ' parsley-error' : '')}}" name="perihal" v-model="form.perihal">
            @foreach ($errors->get('perihal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ $model->attributes()['tanggal'] }}:</label>
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" required class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" id="tanggal" v-model="form.tanggal">
                <div class="input-group-append">                                            
                    <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                </div>
            </div>
            @foreach ($errors->get('tanggal') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 left">
        <div class="form-group">
            <label>Tingkat Keamanan:</label>
            <select class="form-control" required v-model="form.tingkat_keamanan" name="tingkat_keamanan">
                <option value="">- Pilih Tingkat Keamanan -</option>
                @foreach ($model->listTingkatKeamanan as $key=>$value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nomor Urut:</label>
            <input type="text" required class="form-control" name="nomor_urut" v-model="form.nomor_urut">
            <small class="text-info font-italic">Nomor urut dibuat otomatis, kecuali karena keadaan khusus harap tidak merubah isian ini.</small>
        </div>
    </div>
    
    <div class="col-md-4 left">
        <div class="form-group">
            <label>Kode Satuan Organisasi:</label>
            <input type="text" required class="form-control" name="kode_unit_kerja" v-model="form.kode_unit_kerja">
            <small class="text-info font-italic">adalah kode unit kerja penerbit surat, misal: 16000</small>
        </div>
    </div>

    <div class="col-md-4 left">
        <div class="form-group">
            <label>Kode Klasifikasi:</label>
            <input type="text" required class="form-control" name="klasifikasi_arsip" v-model="form.klasifikasi_arsip">
            <small class="text-info font-italic">adalah kode klasifikasi arsip sesuai aturan arsiparis, misal: KU.010. Daftar kode klasifikasi dapat dilihat <a href="https://drive.google.com/file/d/1lQ-GLOJcSDwa_s6eCPV4H3GIGuQKH1xS/view?usp=sharing" target="_blank">disini</a></small>
        </div>
    </div>
</div>

Nomor Surat: @{{ form.tingkat_keamanan }}-@{{ form.nomor_urut }}/@{{ form.kode_unit_kerja }}/@{{ form.klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} <small class="text-mute"><i>(Keterangan Format Nomor Surat: Nomor Urut/Kode Satuan Organisasi/Kode Klasifikasi Arsip/Bulan/Tahun)</i></small>
<input type="hidden" name="nomor" :value="form.tingkat_keamanan+'-'+form.nomor_urut+'/'+form.kode_unit_kerja+'/'+form.klasifikasi_arsip+'/'+bulan+'/'+tahun">
<br/><br/>

<span class="text-info font-italic font-weight-bold"><u>Isian ISI SURAT dibawah tidak wajib diisi, jika diisi anda dapat mencetak surat langsung dari MUSI</u></span>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Dibuat di:</label>
            <input type="text" class="form-control" name="dibuat_di" v-model="form_surat_keluar.dibuat_di">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Lampiran:</label>
            <input type="text" class="form-control" name="lampiran" v-model="form_surat_keluar.lampiran">
        </div>
    </div>
</div>

<label>Kepada:</label>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="kepada"  v-model="form_surat_keluar.kepada">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Tempat:<br/>
            <input type="text" class="form-control" name="kepada_di"  v-model="form_surat_keluar.kepada_di">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-12">
        <div class="form-group">
            <label>Isi Surat:</label>
            <textarea id="isi" class="summernote form-control" name="isi" rows="10" v-model="form_surat_keluar.isi"></textarea>
        </div>
    </div>
</div>

<label>Ditetapkan Oleh:</label>
<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="ditetapkan_oleh" v-model="form.ditetapkan_oleh">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="ditetapkan_nama" v-model="form.ditetapkan_nama">
        </div>
    </div>
</div>

