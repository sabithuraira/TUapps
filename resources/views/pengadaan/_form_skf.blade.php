<fieldset id="skffield">
    <div class="hrdivider">
        <hr />
        <span>SKF</span>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="form-group">
                <label>Judul Pengadaan<span style="color: red; display:block; float:right">*</span></label>
                <input type="text" class="form-control" name="judul" value="{{ old('judul', $model->judul) }}"
                    required>
                @foreach ($errors->get('judul') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Kode Anggaran<span style="color: red; display:block; float:right">*</span></label>

                <input type="text" class="form-control" name="kode_anggaran"
                    value="{{ old('kode_anggaran', $model->kode_anggaran) }}" required>
                <small id="kode_anggaran_help" class="form-text text-muted">Penulisan : 'Kode.Komponen.Akun',
                    contoh:
                    2905.QMA.006.524.C.521211</small>
                @foreach ($errors->get('kode_anggaran') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nilai Anggaran(Rp)<span style="color: red; display:block; float:right">*</span></label>
                <input type="text" class="form-control uang" name="nilai_anggaran" id="nilai_anggaran"
                    value="{{ old('nilai_anggaran', $model->nilai_anggaran) }}" required>
                @foreach ($errors->get('nilai_anggaran') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Waktu Pemakaian<span style="color: red; display:block; float:right">*</span></label>
                <div class="form-line">
                    <div class="input-group ">
                        <input type="text" class="datepicker form-control" id="waktu_pemakaian"
                            name="waktu_pemakaian" autocomplete="off"
                            value="{{ old('waktu_pemakaian', $model->waktu_pemakaian) }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i
                                    class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                </div>
                @foreach ($errors->get('waktu_pemakaian') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nota Dinas + Draft KAK + SPEK +
                    Volume
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control mb-1" id="nota_dinas_skf" name="nota_dinas_skf"
                    accept="application/pdf">
                <label class="mb-1">
                    <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file (google
                        drive)</small></label>
                <input class="form-control" id="link_nota_dinas_skf" name="link_nota_dinas_skf" value="{{ old('link_nota_dinas_skf', $model->link_nota_dinas_skf) }}">
            </div>
            @foreach ($errors->get('nota_dinas_skf') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
            @if (strlen($model['nota_dinas_skf']) > 1)
                <a href="{{ url('pengadaan/unduh/' . $model->nota_dinas_skf) }}" target="_blank"><i
                        class=" icon-arrow-down"></i> Unduh File</a>
            @endif
        </div>
    </div>
    <button type="submit" class="btn btn-primary"> Simpan</button>
</fieldset>
