<div id="app_vue">
    <fieldset id="skffield">
        <div class="hrdivider">
            <hr />
            <span>SKF</span>
        </div>

        <div class="row clearfix">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Judul Pengadaan</label>
                    <input type="text" class="form-control" name="judul" value="{{ old('judul', $model->judul) }}"
                        required>
                    @foreach ($errors->get('judul') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Anggaran</label>

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
                    <label>Nilai Anggaran(Rp)</label>
                    <input type="text" class="form-control uang" name="nilai_anggaran" id="nilai_anggaran"
                        value="{{ old('nilai_anggaran', $model->nilai_anggaran) }}" required>
                    @foreach ($errors->get('nilai_anggaran') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Waktu Pemakaian</label>
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
                    {{-- <label>Nota Dinas</label> --}}
                    <label><span style="color: red; display:block; float:right">*</span>Nota Dinas + Draft KAK + SPEK + Volume
                        <small>(pdf)</small>:</label>
                    <input type="file" class="form-control" id="nota_dinas_skf" name="nota_dinas_skf"
                        accept="application/pdf" required>

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
    </fieldset>
    <br>
    <div class="hrdivider">
        <hr />
        <span>PPK</span>
    </div>
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
            <div class="col-md-9">
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
                <label><span style="color: red; display:block; float:right">*</span>LK HPS + HPS
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="hps" name="hps" accept="application/pdf"
                    @if (!$model['hps']) required @endif disabled>
                @foreach ($errors->get('hps') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if (strlen($model['hps']) > 1)
                    <a href="{{ url('pengadaan/unduh/' . $model->hps) }}" target="_blank"><i
                            class=" icon-arrow-down"></i> Unduh File</a>
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
                    <label><span style="color: red; display:block; float:right">*</span>Nota Dinas + KAK + SPEK PPK
                        <small>(pdf)</small>:</label>
                    <input type="file" class="form-control" id="nota_dinas_ppk" name="nota_dinas_ppk"
                        accept="application/pdf" @if (!$model['nota_dinas_ppk']) required @endif>
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
    <br>
    <br>
    <div class="hrdivider">
        <hr />
        <span>PBJ</span>
    </div>
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
            <input type="checkbox" class="form-check-input" id="status_pengadaan" name="status_pengadaan"
                value="1" @if ($model->status_pengadaan == 1) checked @endif>
            <label class="form-check-label" for="status_pengadaan">Pengadaan Telah Selesai</label><br>
            <small>PBJ telah melakukan pengadaan, menerima produk, dan menyertakan bukti</small>
        </div>

        <br>
        <div class="row clearfix">
            <div class="col-md-3">
                <div class="form-group">
                    <label><span style="color: red; display:block; float:right">
                            @if (!$model->foto)
                                *
                            @endif
                        </span>FOTO
                        <small>(jpg, png, jpeg, img)</small>:</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                        @if (!$model->foto) required @endif disabled value="">
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
                        <span style="color: red; display:block; float:right">
                            @if (!$model->bast)
                                *
                            @endif
                        </span>Kwitansi / BAST
                        <small>(pdf)</small>:
                    </label>
                    <input type="file" class="form-control" id="bast" name="bast"
                        accept="application/pdf" disabled @if (!$model->bast) required @endif>
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
                    <input type="file" class="form-control" id="kontrak" name="kontrak"
                        accept="application/pdf" disabled>
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

    <br>
    <div class="row clearfix text-end">
        <div class="col d-flex justify-content-end">
            <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
    </div>
</div>
<script></script>
