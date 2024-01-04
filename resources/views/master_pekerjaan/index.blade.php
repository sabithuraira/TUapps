@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Master Pekerjaan</li>
    </ul>
@endsection

@section('content')
    <div id="app_vue">
        <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div><br />
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div><br />
            @endif

            <div class="card">
                <div class="body">
                    @if ($auth->hasanyrole('kepegawaian|superadmin'))
                        <a href="#modal_tambah" class="btn btn-info" data-toggle="modal" data-target="#modal_tambah">
                            Tambah
                        </a>
                        <a href="#modal_import" class="btn btn-primary" data-toggle="modal" data-target="#modal_import">
                            Import
                        </a>
                    @endif
                    <br>
                    <form action="{{ url('master_pekerjaan') }}" method="get">
                        <div class="row px-2">
                            <div class="col-2">
                                <label for="" class="label">Tahun</label>
                                <select name="tahun" id="tahun_filter" class="form-control show-tick ms search-select"
                                    onchange="this.form.submit()">
                                    <option value="">Semua</option>
                                    <option value="2024" @if ($request->tahun == '2024') selected @endif>2024</option>
                                    <option value="2025" @if ($request->tahun == '2025') selected @endif>2025</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label for="" class="label">Cari</label>
                                <input type="text" name="keyword" id="keyword_filter" class="form-control"
                                    value="{{ $request->keyword }}" placeholder="cari pekerjaan">

                            </div>
                            <div class="col-2">
                                <label for="" class="label text-white">a</label>
                                <br>
                                <button class="btn btn-info" type="submit">Cari <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <br>
                    <table class="table-sm table-bordered table-striped" style = "width: -webkit-fill-available">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Subkegiatan</th>
                                <th>Uraian Pekerjaan</th>
                                @if ($auth->hasanyrole('superadmin'))
                                    <th>Aksi</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas) > 0)
                                @foreach ($datas as $i => $dt)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td class="text-center">{{ $dt->tahun }}</td>
                                        <td style="max-width: 500px; word-wrap: break-word; white-space:normal">
                                            {{ $dt->subkegiatan }}</td>
                                        <td style="max-width: 500px; word-wrap: break-word; white-space:normal">
                                            {{ $dt->uraian_pekerjaan }}</td>
                                        @if ($auth->hasanyrole('superadmin'))
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-warning" href="#modal_edit" data-toggle="modal"
                                                    data-target="#modal_edit" data-id_pek="{{ $dt->id }}"
                                                    data-tahun="{{ $dt->tahun }}"
                                                    data-subkegiatan="{{ $dt->subkegiatan }}"
                                                    data-uraian_pekerjaan="{{ $dt->uraian_pekerjaan }}"
                                                    @click="btn_edit($event)">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <a class="btn btn-sm btn-danger" href="#modal_hapus" data-toggle="modal"
                                                    data-target="#modal_hapus" data-id_pek="{{ $dt->id }}"
                                                    data-tahun="{{ $dt->tahun }}"
                                                    data-subkegiatan="{{ $dt->subkegiatan }}"
                                                    data-uraian_pekerjaan="{{ $dt->uraian_pekerjaan }}"
                                                    @click="btn_hapus($event)"><i class="fa fa-trash"></i></a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">Belum Ada Data</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <br>
                    {{ $datas->links() }}
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_import" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Import Data</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_import" action="{{ url('master_pekerjaan_import') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>File Import XLSX</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file_import" name="file_import"
                                            required
                                            accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <label class="custom-file-label" for="file_import">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_tambah_iki"
                                    class="form-control show-tick ms search-select" required>
                                    {{-- <option value="">Semua</option> --}}
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_import">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_tambah" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Tambah</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_tambah" action="{{ url('master_pekerjaan') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_tambah" class="form-control show-tick ms search-select"
                                    required>
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="subkegiatan_tambah">Subkegiatan</label>
                                <textarea name="subkegiatan" id="subkegiatan_tambah"rows="5" class="form-control" required></textarea>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="uraian_pekerjaan_tambah">Subkegiatan</label>
                                <textarea name="uraian_pekerjaan" id="uraian_pekerjaan_tambah"rows="5" class="form-control" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_tambah">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Edit</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_edit"method="POST">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_edit" class="form-control show-tick ms search-select"
                                    required>
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="subkegiatan_edit">Subkegiatan</label>
                                <textarea name="subkegiatan" id="subkegiatan_edit"rows="5" class="form-control" required></textarea>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="uraian_pekerjaan_edit">Subkegiatan</label>
                                <textarea name="uraian_pekerjaan" id="uraian_pekerjaan_edit"rows="5" class="form-control" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_edit">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_hapus" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="title" id="largeModalLabel">Hapus</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form_hapus"method="POST">
                            @csrf
                            @method('delete')
                            <div class="form-group">
                                <label>Tahun</label>
                                <select name="tahun" id="tahun_hapus" class="form-control show-tick ms search-select"
                                    disabled>
                                    <option value="2024" selected>2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="subkegiatan_hapus">Subkegiatan</label>
                                <textarea name="subkegiatan" id="subkegiatan_hapus"rows="5" class="form-control" disabled></textarea>
                            </div>
                            <div aria-colcount="form-group">
                                <label for="uraian_pekerjaan_hapus">Subkegiatan</label>
                                <textarea name="uraian_pekerjaan" id="uraian_pekerjaan_hapus"rows="5" class="form-control" disabled></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" form="form_hapus">Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    {{-- <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script> --}}
    <script>
        var vm = new Vue({
            el: "#app_vue",
            data: {},
            methods: {
                btn_edit: function(event) {
                    document.getElementById('tahun_edit').value = event.currentTarget
                        .getAttribute('data-tahun');
                    document.getElementById('subkegiatan_edit').value = event.currentTarget
                        .getAttribute('data-subkegiatan');
                    document.getElementById('uraian_pekerjaan_edit').value = event.currentTarget
                        .getAttribute('data-uraian_pekerjaan');
                    document.getElementById('form_edit').action = window.location.origin +
                        window.location.pathname + '/' + event.currentTarget.getAttribute('data-id_pek');
                },
                btn_hapus: function(event) {
                    document.getElementById('tahun_hapus').value = event.currentTarget
                        .getAttribute('data-tahun');
                    document.getElementById('subkegiatan_hapus').value = event.currentTarget
                        .getAttribute('data-subkegiatan');
                    document.getElementById('uraian_pekerjaan_hapus').value = event.currentTarget
                        .getAttribute('data-uraian_pekerjaan');
                    document.getElementById('form_hapus').action = window.location.origin +
                        window.location.pathname + '/' + event.currentTarget.getAttribute('data-id_pek');
                },
            }
        });
    </script>
@endsection
