<div id="app_vue">
    <div class="row clearfix">
        <div class="col-md-6">
            <div class="form-group">
                {{ $model->attributes()['nama'] }}
                <select class="form-control {{($errors->first('id_user') ? ' parsley-error' : '')}}" name="id_user"
                    id="id_user" @change="setPegawai($event)">
                    @foreach ($list_pegawai as $key=>$value)
                    <option value="{{$value['id']}}" @if($value['id']==old('id_user', $model->id_user))
                        selected="selected"
                        @endif>
                        {{$value['name']}} - {{ $value['nip_baru'] }}
                    </option>
                    @endforeach
                </select>
                @foreach ($errors->get('nama') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <input class=" col-md-6 form-control form-control-sm" hidden name="nama" id="nama" v-model="nama"
                readonly="readonly">
        </div>
        <div class="form-group">
            <input class=" col-md-6 form-control form-control-sm" hidden name="nip" id="nip" v-model="nip"
                readonly="readonly">
        </div>
        <div class="col-md-6">
            <div class="form-group">{{ $model->attributes()['jabatan'] }}
                <div class="form-line">
                    <input class="form-control form-control-sm" type="text" name="jabatan" id="jabatan"
                        value="{{ old('jabatan', $model->jabatan) }}" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">{{ $model->attributes()['masa_kerja'] }}
                <div class="form-line">
                    <input class="form-control form-control-sm" type="text" name="masa_kerja" id="masa_kerja"
                        readonly="readonly" value="{{ old('jabatan', $model->masa_kerja) }}">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label style="margin-bottom: 0">{{ $model->attributes()['jenis_cuti'] }}:</label>
                <select class="form-control {{($errors->first('jenis_cuti') ? ' parsley-error' : '')}}"
                    name="jenis_cuti">
                    @foreach ($model->listJenisCuti as $key=>$value)
                    <option value="{{ $key }}" @if ($key==old('jenis_cuti', $model->jenis_cuti))
                        selected="selected"
                        @endif>
                        {{ $value }}
                    </option>
                    @endforeach
                </select>
                @foreach ($errors->get('jenis_cuti') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label> {{ $model->attributes()['alasan_cuti'] }}</label>
                <textarea name="alasan_cuti"
                    class="form-control form-control-sm {{($errors->first('alasan_cuti') ? ' parsley-error' : '')}}"
                    rows="3">{{ old('alasan_cuti', $model->alasan) }}</textarea>
                @foreach ($errors->get('alasan_cuti') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {{ $model->attributes()['lama_cuti'] }}
                <input name="lama_cuti"
                    class="form-control form-control-sm {{($errors->first('lama_cuti') ? ' parsley-error' : '')}}"
                    value="{{ old('lama_cuti', $model->lama_cuti) }}">
                @foreach ($errors->get('lama_cuti') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">{{ $model->attributes()['tanggal_mulai'] }}
                <div class="input-group">
                    <input type="text"
                        class="form-control datepicker form-control-sm {{($errors->first('tanggal_mulai') ? ' parsley-error' : '')}}"
                        name="tanggal_mulai" id="tanggal_mulai" autocomplete="off"
                        value="{{ old('tanggal_mulai', $model->tanggal_mulai) }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="fa fa-calendar"></i></button>
                    </div>
                    @foreach ($errors->get('tangga_mulai') as $msg)
                    <p class="text-danger">{{ $msg }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">{{ $model->attributes()['tanggal_selesai'] }}
                <div class="form-line">
                    <div class="input-group">
                        <input type="text"
                            class="form-control datepicker form-control-sm {{($errors->first('tanggal_selesai') ? ' parsley-error' : '')}}"
                            name="tanggal_selesai" autocomplete="off" id="tanggal_selesai"
                            value="{{ old('tanggal_selesai', $model->tanggal_selesai) }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button"><i
                                    class="fa fa-calendar"></i></button>
                        </div>
                        @foreach ($errors->get('tanggal_selesai') as $msg)
                        <p class="text-danger">{{ $msg }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <label for="">Catatan Cuti Pegawai : </label>
        </div>
        {{-- {!! json_decode($model->catatan_cuti_pegawai) !!} --}}
        <div class="col-md-12 form-group">
            <table class="table table-bordered m-b-0 text-center" style="">
                <thead>
                    <tr>
                        <th colspan="2" style="width: 16.66%">Jenis Cuti</th>
                        <th style="width: 16.66%">Sisa(Hari)</th>
                        <th>Keterangan</th>
                    </tr>

                </thead>
                <tbody>
                    {{-- {{  $catatan_cuti = json_encode($catatan_cuti) }} --}}
                    <tr>
                        <td rowspan="2" class="text-left">Cuti Tahunan</td>
                        <td>{{ date('Y')-1 }}</td>
                        <td><input name="cuti_tahunan_sebelum" style="width: 100%"
                                value="{{ old('cuti_tahunan_sebelum', $catatan_cuti->cuti_tahunan_sebelum) }}">
                            @foreach ($errors->get('cuti_tahunan_sebelum') as $msg)
                            <p class="text-danger">{{ $msg }}</p>
                            @endforeach
                        </td>
                        <td><input name="keterangan_cuti_tahunan_sebelum" style=" width: 100%"
                                value="{{ old('keterangan_cuti_tahunan_sebelum', $catatan_cuti->keterangan_cuti_tahunan_sebelum) }}">
                        </td>
                    </tr>
                    <tr>
                        <td>{{ date('Y') }}</td>
                        <td><input name="cuti_tahunan" style="width: 100%"
                                value="{{ old('cuti_tahunan', $catatan_cuti->cuti_tahunan) }}">
                        </td>
                        <td><input name="keterangan_cuti_tahunan" style=" width: 100%"
                                value="{{ old('keterangan_cuti_tahunan', $catatan_cuti->keterangan_cuti_tahunan) }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-left">Cuti Besar</td>
                        <td><input name="cuti_besar" style="width: 100%"
                                value="{{ old('cuti_besar', $catatan_cuti->cuti_besar) }}">
                        </td>
                        <td><input name="keterangan_cuti_besar" style=" width: 100%"
                                value="{{ old('keterangan_cuti_besar', $catatan_cuti->keterangan_cuti_besar) }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-left">Cuti Sakit</td>
                        <td><input name="cuti_sakit" style="width: 100%"
                                value="{{ old('cuti_sakit', $catatan_cuti->cuti_sakit) }}">
                        </td>
                        <td><input name="keterangan_cuti_sakit" style=" width: 100%"
                                value="{{ old('keterangan_cuti_sakit', $catatan_cuti->keterangan_cuti_sakit) }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-left">Cuti Melahirkan</td>
                        <td><input name="cuti_melahirkan" style="width: 100%"
                                value="{{ old('cuti_melahirkan', $catatan_cuti->cuti_melahirkan) }}">
                        </td>
                        <td><input name="keterangan_cuti_melahirkan" style=" width: 100%"
                                value="{{ old('keterangan_cuti_melahirkan', $catatan_cuti->keterangan_cuti_melahirkan) }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-left">Cuti Karena Alasan Penting</td>
                        <td><input name="cuti_penting" style="width: 100%"
                                value="{{ old('cuti_penting', $catatan_cuti->cuti_penting) }}">
                        </td>
                        <td><input name="keterangan_cuti_penting" style=" width: 100%"
                                value="{{ old('keterangan_cuti_penting', $catatan_cuti->keterangan_cuti_penting) }}">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class=" text-left">Cuti di Luar Tanggunan Negara</td>
                        <td><input name="cuti_luar_tanggungan" style="width: 100%"
                                value="{{ old('cuti_luar_tanggungan', $catatan_cuti->cuti_luar_tanggungan) }}">
                        </td>
                        <td><input name="keterangan_luar_tanggunan" style=" width: 100%"
                                value="{{ old('keterangan_luar_tanggunan', $catatan_cuti->keterangan_luar_tanggunan) }}">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                {{ $model->attributes()['alamat_cuti'] }}
                <textarea name="alamat_cuti"
                    class="form-control form-control-sm {{($errors->first('alamat_cuti') ? ' parsley-error' : '')}}"
                    rows="2">{{ old('alamat_cuti', $model->alamat_cuti) }} </textarea>
                @foreach ($errors->get('alamat_cuti') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ $model->attributes()['no_telp'] }}
                <input name="no_telp"
                    class="form-control form-control-sm {{($errors->first('no_telp') ? ' parsley-error' : '')}}"
                    value="{{ old('no_telp', $model->no_telp) }}">
                @foreach ($errors->get('no_telp') as $msg)
                <p class="text-danger">{{ $msg }}</p>
                @endforeach
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Simpan</button>
</div>