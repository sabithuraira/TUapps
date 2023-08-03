<div class="mb-3">
    <label for="nama_jabatan" class="form-label">Nama jabatan</label>
    <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" required
        value="{{ old('nama_jabatan', $data->nama_jabatan) }}">
</div>

<div class="mb-3">
    <label for="uker">Unit Kerja</label>
    <select name="kd_wilayah" id="kd_wilayah" class="form-control" required>
        @foreach ($uker as $uk)
            <option value="{{ $uk->kode }}" @if ($uk->kode == $data->kode_wilayah) selected @endif>[{{ $uk->kode }}]
                {{ $uk->nama }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="abk" class="form-label">ABK</label>
    <input type="number" class="form-control" id="abk" value="{{ old('abk', $data->abk) }}" name="abk"
        required>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
