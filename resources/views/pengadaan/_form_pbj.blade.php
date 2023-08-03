<div class="row clearfix">
    <div class="col-md-4">
        <div class="form-group">
            <label>Konfirmasi PBJ</label>
            <select name="konfirmasi_pbj" id="konfirmasi_pbj" class="form-control" required disabled>
                <option value="">Menunggu Konfimasi</option>
                <option value="Sedang diproses" @if ($model->konfirmasi_pbj == 'Sedang diproses') selected @endif>Sedang diproses
                </option>
                {{-- <option value="Selesai" @if ($model->konfirmasi_pbj == 'Selesai') selected @endif>Selesai</option> --}}
                <option value="Ditolak" @if ($model->konfirmasi_pbj == 'Ditolak') selected @endif>Ditolak</option>
            </select>
            @foreach ($errors->get('konfirmasi_pbj') as $msg)
                <p class="text-danger">{{ $msg }}</p>
            @endforeach
        </div>
    </div>
</div>
<fieldset id="pbjfield" disabled>
    <div class="row clearfix mb-2">
        <div class="col-md-4">
            <label for="">Nilai Kwitansi/Kontrak</label>
            <input type="text" class="form-control uang" id="nilai_kwitansi" name="nilai_kwitansi"
                value="{{ old('nilai_kwitansi', $model->nilai_kwitansi) }}" required>
        </div>
        <div class="col-md-8">
            <div class="row d-flex justify-content-center">
                <label for="">Tanggal Pelaksanaan</label>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-5">
                    <input type="text" class="datepicker form-control" id="tgl_mulai_pelaksanaan"
                        name="tgl_mulai_pelaksanaan" autocomplete="off" placeholder="waktu mulai"
                        value="{{ old('tgl_mulai_pelaksanaan', $model->tgl_mulai_pelaksanaan) }}" required>
                    @foreach ($errors->get('tgl_mulai_pelaksanaan') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
                s.d
                <div class="col-5">
                    <input type="text" class="datepicker form-control" id="tgl_akhir_pelaksanaan"
                        name="tgl_akhir_pelaksanaan" autocomplete="off" placeholder="waktu akhir"
                        value="{{ old('tgl_akhir_pelaksanaan', $model->tgl_akhir_pelaksanaan) }}" required>
                    @foreach ($errors->get('tgl_akhir_pelaksanaan') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="status_pengadaan" name="status_pengadaan" value="1"
            @if ($model->status_pengadaan == 1) checked @endif>
        <label class="form-check-label" for="status_pengadaan">Pengadaan Telah Selesai</label><br>
        <small>PBJ telah melakukan pengadaan, menerima produk, dan menyertakan bukti</small>
    </div>

    <br>
    <div class="row clearfix">
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    {{-- <span style="color: red; display:block; float:right">
                        @if (!$model->foto)
                            *
                        @endif
                    </span> --}}
                    FOTO
                    <small>(jpg, png, jpeg, img)</small>:
                </label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                    @if (!$model->foto)  @endif disabled value="">
                <label class="mb-1">
                    <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file
                        (google drive)
                    </small>
                </label>
                <input class="form-control" id="link_foto" name="link_foto"
                    value="{{ old('link_foto', $model->link_foto) }}">
                @foreach ($errors->get('foto') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if ($model['foto'])
                    <a href="{{ url('pengadaan/unduh/' . $model->foto) }}" target="_blank"><i
                            class=" icon-arrow-down"></i> Unduh File</a>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label>
                    {{-- <span style="color: red; display:block; float:right">
                        @if (!$model->bast)
                            *
                        @endif
                    </span> --}}
                    Kwitansi / BAST
                    <small>(pdf)</small>:
                </label>
                <input type="file" class="form-control" id="bast" name="bast" accept="application/pdf"
                    disabled @if (!$model->bast)  @endif>
                <label class="mb-1">
                    <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file
                        (google drive)
                    </small>
                </label>
                <input class="form-control" id="link_bast" name="link_bast"
                    value="{{ old('link_bast', $model->link_bast) }}">
                @foreach ($errors->get('bast') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if ($model['bast'])
                    <a href="{{ url('pengadaan/unduh/' . $model->bast) }}" target="_blank"><i
                            class=" icon-arrow-down"></i> Unduh File</a>
                @endif
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label><span style="color: red; display:block; float:right"></span>Kontrak
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="kontrak" name="kontrak" accept="application/pdf"
                    disabled>
                <label class="mb-1">
                    <small>Apabila Gagal akibat file terlalu besar silahkan masukkan link file
                        (google drive)
                    </small>
                </label>
                <input class="form-control" id="link_kontrak" name="link_kontrak"
                    value="{{ old('link_kontrak', $model->link_kontrak) }}">
                @foreach ($errors->get('kontrak') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if ($model['kontrak'])
                    <a href="{{ url('pengadaan/unduh/' . $model->kontrak) }}" target="_blank"><i
                            class=" icon-arrow-down"></i> Unduh File</a>
                @endif
            </div>
        </div>
    </div>
</fieldset>

<fieldset id="field_penolakan_pbj" disabled hidden>
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>Tanggal Penolakan</label>
                <div class="form-line">
                    <div class="input-group">
                        <input type="text" class="datepicker form-control" id="tgl_penolakan_pbj"
                            name="tgl_penolakan_pbj" autocomplete="off"
                            value="{{ old('tgl_penolakan_pbj', $model->tgl_penolakan_pbj) }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i
                                    class="fa fa-calendar"></i></button>
                        </div>
                    </div>
                </div>
                @foreach ($errors->get('tgl_penolakan_pbj') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Alasan Penolakan</label>
                <textarea name="alasan_penolakan_pbj" id="alasan_penolakan_pbj" rows="5" class="form-control" required
                    placeholder="Alasan Ditolak">{{ old('alasan_penolakan_pbj', $model->alasan_penolakan_pbj) }}</textarea>
                @foreach ($errors->get('alasan_penolakan_pbj') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>
</fieldset>

<button type="submit" class="btn btn-primary"> Simpan</button>
