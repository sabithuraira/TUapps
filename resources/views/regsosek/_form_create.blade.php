<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Provinsi :</label>
            <input type="text" class="form-control" disabled value="16">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kabupaten/Kota :</label>
            <input type="text" class="form-control" name="kode_kab" value="{{ $model->kode_kab }}">
            @foreach ($errors->get('kode_kab') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kecamatan :</label>
            <input type="text" class="form-control" name="kode_kec" value="{{ $model->kode_kec }}">
            @foreach ($errors->get('kode_kec') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Desa/Kelurahan :</label>
            <input type="text" class="form-control" name="kode_desa" value="{{ $model->kode_desa }}">
            @foreach ($errors->get('kode_desa') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode SLS/Non SLS :</label>
            <input type="text" class="form-control" name="id_sls" value="{{ $model->id_sls }}">
            @foreach ($errors->get('id_sls') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Kode Sub SLS/Non SLS :</label>
            <input type="text" class="form-control" name="id_sub_sls" value="{{ $model->id_sub_sls }}">
            @foreach ($errors->get('id_sub_sls') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama SLS/Non SLS :</label>
            <input type="text" class="form-control" name="nama_sls" value="{{ $model->nama_sls }}">
        </div>
    </div>
</div>

<br>
<button type="submit" class="btn btn-primary">Simpan</button>

