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
                    @foreach ($errors->get('kode_anggaran') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nilai (Rp)</label>
                    <input type="number" class="form-control" name="nilai" id="nilai"
                        value="{{ old('nilai', $model->nilai) }}" required>
                    @foreach ($errors->get('nilai') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Waktu Pemakaian</label>
                    <div class="form-line">
                        <div class="input-group">
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
            <div class="col-md-4">
                <div class="form-group">
                    {{-- <label>Nota Dinas</label> --}}
                    <label><span style="color: red; display:block; float:right">*</span>Nota Dinas
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
            <div class="col-md-4">
                <div class="form-group">
                    <label><span style="color: red; display:block; float:right">*</span>KAK
                        <small>(pdf)</small>:</label>
                    <input type="file" class="form-control" id="kak_skf" name="kak_skf" accept="application/pdf">
                </div>
                @foreach ($errors->get('kak_skf') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
                @if (strlen($model['kak_skf']) > 1)
                    <a href="{{ url('pengadaan/unduh/' . $model->kak_skf) }}" target="_blank"><i
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
        <div class="col-md-4">
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
        <div class="row  mx-0">
            <div class="col-md-6 border" id="field_hps" style="background-color: #e9ecef">
                <div class="row clearfix">
                    <div class="col-md-6 ">
                        {{-- <div class="form-group "> --}}
                        {{-- <label>LK HPS </label> --}}
                        <label><span style="color: red; display:block; float:right">*</span>LK HPS
                            <small>(pdf)</small>:</label>
                        <input type="file" class="form-control" id="lk_hps" name="lk_hps" required
                            accept="application/pdf">
                        {{-- </div> --}}
                        @foreach ($errors->get('lk_hps') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                        @if (strlen($model['lk_hps']) > 1)
                            <a href="{{ url('pengadaan/unduh/' . $model->lk_hps) }}" target="_blank"><i
                                    class=" icon-arrow-down"></i> Unduh File</a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label><span style="color: red; display:block; float:right">*</span>HPS
                            <small>(pdf)</small>:</label>
                        <input type="file" class="form-control" id="hps" name="hps"
                            accept="application/pdf" required>
                        @foreach ($errors->get('hps') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                        @if (strlen($model['hps']) > 1)
                            <a href="{{ url('pengadaan/unduh/' . $model->hps) }}" target="_blank"><i
                                    class=" icon-arrow-down"></i> Unduh File</a>
                        @endif
                    </div>

                </div>
                <div class="row clearfix"id="field_hps2">
                    <div class="col-12 text-center">
                        <label class="mb-0"><span style="color: red; display:block; float:left">*</span>
                            <small>Untuk Nilai Diatas 10jt</small></label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 border">
                <div class="row clearfix">
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label><span style="color: red; display:block; float:right">*</span>Nota Dinas PPK
                                <small>(pdf)</small>:</label>
                            <input type="file" class="form-control" id="nota_dinas_ppk" name="nota_dinas_ppk"
                                accept="application/pdf" required>
                        </div>
                        @foreach ($errors->get('nota_dinas_ppk') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                        @if (strlen($model['nota_dinas_ppk']) > 1)
                            <a href="{{ url('pengadaan/unduh/' . $model->nota_dinas_ppk) }}" target="_blank"><i
                                    class=" icon-arrow-down"></i> Unduh File</a>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><span style="color: red; display:block; float:right">*</span>KAK PPK
                                <small>(pdf)</small>:</label>
                            <input type="file" class="form-control" id="kak_ppk" name="kak_ppk"
                                accept="application/pdf" required>
                        </div>
                        @foreach ($errors->get('kak_ppk') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                        @if (strlen($model['kak_ppk']) > 1)
                            <a href="{{ url('pengadaan/unduh/' . $model->kak_ppk) }}" target="_blank"><i
                                    class=" icon-arrow-down"></i> Unduh File</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-md-12 pt-2">
                <label>SPEK</label>
                {{-- <textarea name="spek" id="" rows="5" class="form-control"></textarea> --}}
                <textarea name="spek" id="spek" rows="5" class="form-control" placeholder="Masukkan SPEK" required>{{ old('spek', $model->spek) }}</textarea>
                @foreach ($errors->get('spek') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </fieldset>

    <fieldset id="field_penolakan_ppk" disabled hidden>
        <div class="row clearfix">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Penolakan</label>
                    {{-- <input type="text" class="form-control" name="tgl_penolakan"
                        value="{{ old('tgl_penolakan', $model->tgl_penolakan) }}"> --}}
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
                    {{-- <option value="Menunggu Konfirmasi PBJ">Menunggu Konfimasi PBJ</option> --}}
                    {{-- <option value="3">Anggaran Tidak Tersedia</option> --}}
                    <option value="Sedang diproses">Sedang diproses</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Ditolak">Ditolak</option>
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
                <label for="">Nilai Terevisi</label>
                <input type="text" class="form-control" id="revisi_nilai" name="revisi_nilai"
                    value="{{ old('revisi_nilai', $model->revisi_nilai) }}">
            </div>
            <div class="col-md-8">
                <div class="row d-flex justify-content-center">
                    <label for="">Tanggal Pelaksanaan</label>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-5">
                        <input type="text" class="datepicker form-control" id="tgl_mulai_pelaksanaan"
                            name="tgl_mulai_pelaksanaan" autocomplete="off"
                            value="{{ old('tgl_mulai_pelaksanaan', $model->tgl_mulai_pelaksanaan) }}" required>
                        @foreach ($errors->get('tgl_mulai_pelaksanaan') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                    s.d
                    <div class="col-5">

                        <input type="text" class="datepicker form-control" id="tgl_akhir_pelaksanaan"
                            name="tgl_akhir_pelaksanaan" autocomplete="off"
                            value="{{ old('tgl_akhir_pelaksanaan', $model->tgl_akhir_pelaksanaan) }}" required>
                        @foreach ($errors->get('tgl_akhir_pelaksanaan') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-3">
                <div class="form-group">
                    <label><span style="color: red; display:block; float:right"></span>FOTO
                        <small>(jpg, png, jpeg, img)</small>:</label>
                    <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                </div>
                @foreach ($errors->get('foto') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
            <div class="col-md-3">
                <label><span style="color: red; display:block; float:right"></span>BAST
                    <small>(pdf)</small>:</label>
                <input type="file" class="form-control" id="bast" name="bast" accept="application/pdf">
                @foreach ($errors->get('bast') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
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

    {{-- <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                <label>Judul Pengadaan</label>
                <input type="text" class="form-control" name="judul" value="{{ old('judul', $model->judul) }}">
                @foreach ($errors->get('judul') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Nilai</label>
                <input type="number" class="form-control" name="nilai" value="{{ old('nilai', $model->nilai) }}">
                @foreach ($errors->get('nilai') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div> --}}


</div>
