@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="m-b-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row clearfix">
    <div class="col-md-6">
        <div class="form-group">
            <label>Kegiatan <span class="text-danger">*</span></label>
            <input type="text" name="kegiatan" class="form-control" value="{{ old('kegiatan', $model->kegiatan) }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Tanggal <span class="text-danger">*</span></label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $model->tanggal ? $model->tanggal->format('Y-m-d') : '') }}" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode satker <span class="text-danger">*</span></label>
            <input type="text" name="kode_satker" class="form-control" value="{{ old('kode_satker', $model->kode_satker) }}" placeholder="contoh: 16000" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Klasifikasi arsip <span class="text-danger">*</span></label>
            <input type="text" name="klasifikasi_arsip" class="form-control" value="{{ old('klasifikasi_arsip', $model->klasifikasi_arsip) }}" placeholder="contoh: KU.010" required>
            <small class="text-info font-italic">adalah kode klasifikasi arsip sesuai aturan arsiparis, misal: KU.010. Daftar kode klasifikasi dapat dilihat <a href="https://docs.google.com/spreadsheets/d/1gdPQhEbXWbaEX048Rp2toB_0LeqJUCRgqRNak3S_a-s/edit?usp=sharing" target="_blank">disini</a></small>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $model->deskripsi) }}</textarea>
        </div>
    </div>
</div>

<hr>
<h4>Peserta</h4>
<p class="text-muted small">Nomor urut dan nomor sertifikat dihitung otomatis saat simpan (format: B-{urut}/{kode_satker}/{klasifikasi}/{tahun dari tanggal}).</p>

<div class="form-group">
    <label>Impor dari Excel (opsional, kolom pertama = nama; baris judul boleh berisi &quot;nama&quot;)</label>
    <div class="row">
        <div class="col-md-6">
            <input type="file" name="excel_peserta" id="excel_peserta" class="form-control" accept=".xlsx,.xls,.csv">
        </div>
        <div class="col-md-6">
            <button type="button" class="btn btn-secondary" id="btn-preview-excel">Tambahkan baris dari file (pratinjau)</button>
        </div>
    </div>
    <small class="text-muted">File di formulir juga diproses saat menyimpan — baris manual di bawah digabung lalu nama dari Excel.</small>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="table-peserta">
        <thead>
            <tr>
                <th style="width:50px">#</th>
                <th>Nama peserta</th>
                <th style="width:80px"></th>
            </tr>
        </thead>
        <tbody id="peserta-rows">
            @php
                $oldNames = old('peserta_nama');
                if (is_array($oldNames)) {
                    $rows = $oldNames;
                } elseif ($model->relationLoaded('peserta') && $model->peserta->count() > 0) {
                    $rows = $model->peserta->sortBy('nomor_urut')->values()->pluck('nama_peserta')->all();
                } else {
                    $rows = [''];
                }
                if (count($rows) === 0) {
                    $rows = [''];
                }
            @endphp
            @foreach($rows as $idx => $nama)
            <tr class="peserta-row">
                <td class="text-center nomor-cell">{{ $loop->iteration }}</td>
                <td><input type="text" name="peserta_nama[]" class="form-control peserta-nama" value="{{ $nama }}"></td>
                <td class="text-center"><button type="button" class="btn btn-sm btn-danger btn-remove-row">&times;</button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<button type="button" class="btn btn-sm btn-primary" id="btn-add-peserta">+ Tambah baris</button>

<hr>
<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ url('sertifikat_induk') }}" class="btn btn-default">Batal</a>
