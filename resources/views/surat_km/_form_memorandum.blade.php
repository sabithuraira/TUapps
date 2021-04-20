<div class="row clearfix">
    <div class="col-md-12 left">
        <div class="form-group">
            <label>{{ $model->attributes()['perihal'] }}:</label>
            <input type="text" class="form-control {{($errors->first('perihal') ? ' parsley-error' : '')}}" name="perihal" value="{{ old('perihal', $model->perihal) }}">
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
                <input type="text" class="form-control {{($errors->first('tanggal') ? ' parsley-error' : '')}}" name="tanggal" id="tanggal" v-model="tanggal">
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
            <div class="form-group">
                <label>Dari:</label>
                <input type="text" class="form-control" name="dari">
            </div>
        </div>
    </div>
</div>

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
            <input type="text" class="form-control" name="kode_klasifikasi_arsip" v-model="kode_klasifikasi_arsip">
        </div>
    </div>
</div>

Nomor Surat: @{{ nomor_urut }}/@{{ kode_unit_kerja }}/@{{ kode_klasifikasi_arsip }}/@{{ bulan }}/@{{ tahun }} <small class="text-mute"><i>(Keterangan Format Nomor Surat: Nomor Urut/Kode Satuan Organisasi/Kode Klasifikasi Arsip/Bulan/Tahun)</i></small>
<input type="hidden" name="nomor" :value="nomor_urut+'/'+kode_unit_kerja+'/'+kode_klasifikasi_arsip+'/'+bulan+'/'+tahun">
<br/><br/>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kepada:</label>
            <input type="text" class="form-control" name="kepada">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            <label>Lampiran:</label>
            <input type="text" class="form-control" name="lampiran">
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
    <div class="col-md-6">
        <div class="form-group">
            Jabatan:<br/>
            <input type="text" class="form-control" name="ditetapkan_oleh">
        </div>
    </div>
    
    <div class="col-md-6 left">
        <div class="form-group">
            Nama:<br/>
            <input type="text" class="form-control" name="ditetapkan_nama">
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
