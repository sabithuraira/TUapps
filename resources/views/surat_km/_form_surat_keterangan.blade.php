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
            <label>Kode Satuan Organisasi:</label>
            <input type="text" class="form-control" name="kode_unit_kerja" v-model="kode_unit_kerja">
            <small class="text-info font-italic">adalah kode unit kerja penerbit surat, misal: 16000</small>
        </div>
    </div>

</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode Klasifikasi:</label>
            <input type="text" class="form-control" name="klasifikasi_arsip" v-model="klasifikasi_arsip">
            <small class="text-info font-italic">adalah kode klasifikasi arsip sesuai aturan arsiparis, misal: KU.010. Daftar kode klasifikasi dapat dilihat <a href="https://drive.google.com/file/d/1lQ-GLOJcSDwa_s6eCPV4H3GIGuQKH1xS/view?usp=sharing" target="_blank">disini</a></small>
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

Nomor Surat: @{{ tingkat_keamanan }}-@{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} <small class="text-mute"><i>(Keterangan Format Nomor Surat: Nomor Urut/Kode Satuan Organisasi/Kode Klasifikasi Arsip/Bulan/Tahun)</i></small>
<input type="hidden" name="nomor" :value="tingkat_keamanan+'-'+nomor_urut+'/'+kode_unit_kerja+'/'+klasifikasi_arsip+'/'+bulan+'/'+tahun">
<br/><br/>

<span class="text-info font-italic font-weight-bold"><u>Isian ISI SURAT dibawah tidak wajib diisi, jika diisi anda dapat mencetak surat langsung dari MUSI</u></span>
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
            <div class="input-group date" id="date_id" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" name="ditetapkan_tanggal" id="ditetapkan_tanggal" v-model="ditetapkan_tanggal">
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