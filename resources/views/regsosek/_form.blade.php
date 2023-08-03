<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Provinsi :</label>
            <input type="text" class="form-control" disabled value="{{ $model->kode_prov }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kabupaten/Kota :</label>
            <input type="text" class="form-control" disabled value="{{ $model->kode_kab }}">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kecamatan :</label>
            <input type="text" class="form-control" disabled value="{{ $model->kode_kec }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Desa/Kelurahan :</label>
            <input type="text" class="form-control" disabled value="{{ $model->kode_desa }}">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode SLS/Non SLS :</label>
            <input type="text" class="form-control" name="id_sls" value="{{ $model->id_sls }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kode Sub SLS/Non SLS :</label>
            <input type="text" class="form-control" name="id_sub_sls" value="{{ $model->id_sub_sls }}">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nama SLS/Non SLS :</label>
            <input type="text" class="form-control" name="nama_sls" value="{{ $model->nama_sls }}">
        </div>
    </div>

    
    <div class="col-md-4">
        <div class="form-group">
            <label>Apakah mengalami perubahan batas :</label>
            <select class="form-control" name="is_berubah_batas">
                <option> - </option>
                <option value="0" @if($model->is_berubah_batas==0) selected @endif>Tidak</option>
                <option value="1" @if($model->is_berubah_batas==1) selected @endif>Ya</option>
            </select>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Keluarga Verifikasi :</label>
            <input type="text" class="form-control" name="j_keluarga_pengakuan" value="{{ $model->j_keluarga_pengakuan }}">
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Sangat Miskin :</label>
            <input type="number" class="form-control" name="j_sangat_miskin" value="{{ $model->j_sangat_miskin }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Miskin :</label>
            <input type="number" class="form-control" name="j_miskin" value="{{ $model->j_miskin }}">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label>Jumlah Tidak Miskin :</label>
            <input type="number" class="form-control" name="j_tidak_miskin" value="{{ $model->j_tidak_miskin }}">
        </div>
    </div>
</div>


<br>
<button type="submit" class="btn btn-primary">Simpan</button>

