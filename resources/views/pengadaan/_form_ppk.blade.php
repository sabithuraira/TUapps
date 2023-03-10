<div class="row clearfix">
    <div class="col-md-3">
        <div class="form-group">
            <label>Konfirmasi PPK</label>
            <select name="konfirmasi_ppk" id="konfirmasi_ppk" class="form-control" required disabled>
                <option @if ($model->konfirmasi_ppk == '') selected @endif value=""> Menunggu Konfirmasi
                    PPK</option>
                <option value="Sedang diproses" @if ($model->konfirmasi_ppk == 'Sedang diproses') selected @endif>Sedang
                    diproses</option>
                <option value="Diterima" @if ($model->konfirmasi_ppk == 'Diterima') selected @endif>Diterima</option>
                <option value="Ditolak" @if ($model->konfirmasi_ppk == 'Ditolak') selected @endif>Ditolak</option>
            </select>
            @foreach ($errors->get('judul') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>
<fieldset id="ppkfield" disabled>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="form-group">
                <label>SPEK</label>
                <textarea name="spek" id="spek" rows="5" class="form-control" placeholder="Masukkan spesifikasi" required>{{ old('spek', $model->spek) }}</textarea>
                @foreach ($errors->get('spek') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>SPEK
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="spek_file" name="spek_file" accept="application/pdf"
                    @if (!$model['spek_file']) required @endif>
                @foreach ($errors->get('spek_file') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if (strlen($model['spek_file']) > 1)
                    <a href="{{ url('pengadaan/unduh/' . $model->spek_file) }}" target="_blank"><i
                            class=" icon-arrow-down"></i> Unduh File</a>
                @endif
            </div>
        </div> --}}
    </div>
    <div class="row clearfix">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Perkiraan Nilai Pengadaan(Rp)</label>
                <input type="text" class="form-control uang" name="perkiraan_nilai" id="perkiraan_nilai"
                    value="{{ old('perkiraan_nilai', $model->perkiraan_nilai) }}" required>
                @foreach ($errors->get('perkiraan_nilai') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-2">
            <br>
            <label class="mb-0"><span style="color: red; display:block; float:left">*</span>
                <small>Untuk Nilai Diatas 10jt <i class="icon-arrow-right"></i></small></label>
        </div>
        {{-- <div class="col-md-3">
            <label><span style="color: red; display:block; float:right">*</span>LK HPS
                <small>(pdf)</small>:</label>
            <input type="file" class="form-control" id="lk_hps" name="lk_hps"
                @if (!$model['lk_hps']) required @endif accept="application/pdf" disabled>
            @foreach ($errors->get('lk_hps') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
            @if (strlen($model['lk_hps']) > 1)
                <a href="{{ url('pengadaan/unduh/' . $model->lk_hps) }}" target="_blank"><i
                        class=" icon-arrow-down"></i> Unduh File</a>
            @endif
        </div> --}}

        <div class="col-md-6">
            <label>LK HPS + HPS
                <small>(pdf)</small>:</label>
            <input type="file" class="form-control" id="hps" name="hps" accept="application/pdf"
                @if (!$model['hps'])  @endif disabled>
            <label class="mb-1">
                <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file (google
                    drive)</small></label>
            <input class="form-control" id="link_hps" name="link_hps" value="{{ old('link_hps', $model->link_hps) }}">
            @foreach ($errors->get('hps') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
            @if (strlen($model['hps']) > 1)
                <a href="{{ url('pengadaan/unduh/' . $model->hps) }}" target="_blank"><i class=" icon-arrow-down"></i>
                    Unduh File</a>
            @endif
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Alokasi Anggaran</label>
                <input type="text" class="form-control" name="alokasi_anggaran" id="alokasi_anggaran"
                    value="{{ old('alokasi_anggaran', $model->alokasi_anggaran) }}" required>
                @foreach ($errors->get('alokasi_anggaran') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nota Dinas + KAK + SPEK PPK
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="nota_dinas_ppk" name="nota_dinas_ppk"
                    accept="application/pdf" @if (!$model['nota_dinas_ppk'])  @endif>
                <label class="mb-1">
                    <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file
                        (google drive)
                    </small>
                </label>
                <input class="form-control" id="link_nota_dinas_ppk" name="link_nota_dinas_ppk"
                    value="{{ old('link_nota_dinas_ppk', $model->link_nota_dinas_ppk) }}">
            </div>

            @foreach ($errors->get('nota_dinas_ppk') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
            @if (strlen($model['nota_dinas_ppk']) > 1)
                <a href="{{ url('pengadaan/unduh/' . $model->nota_dinas_ppk) }}" target="_blank"><i
                        class=" icon-arrow-down"></i> Unduh File</a>
            @endif
        </div>
        {{-- <div class="col-md-3 ">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right">*</span>KAK PPK
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="kak_ppk" name="kak_ppk"
                    accept="application/pdf" @if (!$model['kak_ppk']) required @endif>
            </div>
            @foreach ($errors->get('kak_ppk') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
            @if (strlen($model['kak_ppk']) > 1)
                <a href="{{ url('pengadaan/unduh/' . $model->kak_ppk) }}" target="_blank"><i
                        class=" icon-arrow-down"></i> Unduh File</a>
            @endif
        </div> --}}
    </div>
</fieldset>

<fieldset id="field_penolakan_ppk" disabled hidden>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Penolakan</label>
                <div class="form-line">
                    <div class="input-group">
                        <input type="text" class="datepicker form-control" id="tgl_penolakan_ppk"
                            name="tgl_penolakan_ppk" autocomplete="off"
                            value="{{ old('tgl_penolakan_ppk', $model->tgl_penolakan_ppk) }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i
                                    class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                </div>
                @foreach ($errors->get('tgl_penolakan_ppk') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Alasan Penolakan</label>
                <textarea name="alasan_penolakan_ppk" id="alasan_penolakan_ppk" rows="5" class="form-control"
                    placeholder="Alasan Ditolak" required>{{ old('alasan_penolakan_ppk', $model->alasan_penolakan_ppk) }}</textarea>
                @foreach ($errors->get('alasan_penolakan_ppk') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>
</fieldset>

<button type="submit" class="btn btn-primary"> Simpan</button>
