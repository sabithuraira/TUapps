@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    <style>
        .c3-axis-x text {
            font-size: 10px;
        }
    </style>
    <div class="container" id="app_vue">
        <div class="">
            <div class="card">
                <div class="body profilepage_2 blog-page pb-0">
                    <b>User/Petugas ST 2023 </b>
                    <div class="alert alert-info mt-1" role="alert">
                        Import daftar petugas dengan menggunakan file excel dari hasil export petugas pada aplikasi
                        manajemen mitra
                    </div>
                    <button class="btn btn-info float-right" data-toggle="modal" data-target="#modal_import">Import
                        Petugas</button>
                </div>
                <div class="">

                </div>
                <br>
                <div>
                    <form action="">
                        <div class="row">
                            <div class="col-2">
                                <label for="" class="label">Kab/Kot</label>
                                <select name="kab_filter" id="kab_filter" class="form-control" @change="select_kabs()">
                                    <option value="">Semua</option>
                                    @foreach ($kabs as $kab)
                                        <option value="{{ $kab['id_kab'] }}">[{{ $kab['id_kab'] }}] {{ $kab['alias'] }}
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="label">Kec</label>
                                <select name="kec_filter" id="kec_filter" class="form-control" @change="select_kecs()">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="label">Desa</label>
                                <select name="desa_filter" id="desa_filter" class="form-control">
                                    <option value="">Semua</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label for="" class="label">Nama/Email</label>
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    value="{{ $request->keyword }}">

                            </div>
                            <div class="col-1 ">
                                <label for="" class="label text-white">cari</label>
                                <button type="submit" class="btn btn-info">cari</button>
                            </div>
                        </div>
                    </form>
                </div>
                <br>
                <div class="m-1">
                    <table class="table table-bordered table-sm ">
                        <thead>
                            <tr class="text-center table-secondary">
                                <th>No</th>
                                <th>Kab</th>
                                <th>Kec</th>
                                <th>Desa</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @if ($data)
                            @foreach ($data as $index => $dt)
                                <tbody>
                                    <tr class="text-center">
                                        <td>{{ ++$index }}</td>
                                        <td>{{ $dt['kode_kab'] }}</td>
                                        <td>{{ $dt['kode_kec'] }}</td>
                                        <td>{{ $dt['kode_desa'] }}</td>
                                        <td class="text-left">{{ $dt['name'] }}</td>
                                        <td class="text-left">{{ $dt['email'] }}</td>
                                        <td>
                                            @if ($dt['roles'])
                                                {{ $dt['roles'][0]['name'] }}
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-warning"
                                                href="{{ url('dashboard/petugas/' . $dt['encId']) }}"> <i
                                                    class="icon-pencil"></i></a>

                                            <button class="btn btn-danger hapus_btn" data-id="{{ $dt['encId'] }}"
                                                data-nama="{{ $dt['name'] }}" data-toggle="modal"
                                                data-target="#modal_hapus" @click="hapus( {{ $dt['id'], $dt['name'] }} )">
                                                <i class="icon-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        @else
                            <tbody>
                                <tr>
                                    <td colspan="8">Belum Ada Data</td>
                                </tr>
                            </tbody>
                        @endif
                    </table>
                    <ul class="pagination pagination-primary">
                        @foreach ($links as $lk)
                            <li class="page-item @if ($lk['active']) active @endif">
                                <a class="page-link" href="{{ $lk['url'] }}"> {{ $lk['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    {{-- <div class="pagination">
                        {!! $links !!}
                    </div> --}}

                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_import" tabindex="-1" aria-labelledby="modal_importLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_importLabel">Modal Import</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info mt-1" role="alert">
                            Ingat!! File yang diimport adalah file excel hasil penerimaan petugas yang berasal dari
                            manajemen mitra
                        </div>
                        <form @submit="submit_import" enctype="multipart/form-data" id="form_import">
                            <label for="import_file" class="label">Masukkan File</label>
                            <input type="file" class="form-control" name="import_file" id="import_file"
                                accept=".xlsx, .xls" required>
                        </form>
                        <div v-if="!loading">
                        </div>
                        <div v-else>
                            <p>Loading...</p>
                        </div>
                        <div v-if="showSuccessMessage">
                            <p>Data Berhasil Dikirim</p>
                            <p>Merefresh dalam @{{ countdown }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" form="form_import" class="btn btn-primary" @click="submit_import()">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_hapus" tabindex="-1" aria-labelledby="modal_hapusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_hapusLabel">Modal Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Yakin Akan Menghapus
                            {{-- <b> <i id="nama_hapus"> Nama User </i></b> --}}
                        </p>
                        <div v-if="!loading">
                        </div>
                        <div v-else>
                            <p>Loading...</p>
                        </div>
                        <div v-if="showSuccessMessage">
                            <p>Berhasil Dihapus</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" @click="hapus_confirm()" class="btn btn-primary">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>

    <script>
        var vm = new Vue({
            el: "#app_vue",
            data() {
                return {
                    $dt: {
                        id: '',
                        name: ''
                    },
                    loading: false,
                    showSuccessMessage: false,
                    countdown: 3, // Waktu dalam detik
                    id_edit: null,
                    nama_edit: null,
                    id_hapus: null,
                    nama_hapus: null,
                    csrf: null,
                    encId: '',
                    api_token: {!! json_encode($api_token) !!},
                    csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                };
            },
            mounted() {
                const self = this;
                const auth = {!! json_encode($auth) !!}
                // this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const kab_value = {!! json_encode($request->kab_filter) !!}
                const kec_value = {!! json_encode($request->kec_filter) !!}
                const desa_value = {!! json_encode($request->desa_filter) !!}
                if (kab_value) {
                    this.set_kab(kab_value)
                        .then(function() {
                            self.select_kabs()
                        }).then(function() {
                            if (kec_value) {
                                self.set_kec(kec_value)
                            }
                        }).then(function() {
                            self.select_kecs()
                        }).then(function() {
                            if (desa_value) {
                                self.set_desa(desa_value)
                            }
                        }).catch(function(error) {
                            console.log(error);
                        });
                }
                fetch('https://st23.bpssumsel.com/api/getcsrf', {
                        method: 'GET',
                    })
                    .then(response => response.json())
                    .then(data => {
                        this.csrf = data.csrf_token
                    })
                    .catch(error => {
                        console.log(error);
                    });

            },
            methods: {
                select_kabs() {
                    return new Promise((resolve, reject) => {
                        const kab_filter = document.getElementById('kab_filter').value;
                        var request = new XMLHttpRequest();
                        request.open('GET', 'https://st23.bpssumsel.com/api/list_kecs?kab_filter=' +
                            kab_filter,
                            false
                        ); // Set argumen ketiga menjadi false untuk menjalankan permintaan secara sinkron
                        request.send();
                        if (request.status === 200) {
                            var data = JSON.parse(request.responseText);
                            const kec_select = document.getElementById('kec_filter');
                            kec_select.innerHTML = "";
                            var option = document.createElement('option');
                            option.value = "";
                            option.textContent = "Semua";
                            kec_select.appendChild(option);
                            data.data.forEach(element => {
                                var option = document.createElement('option');
                                // option.value = element.id_kec;
                                option.textContent = '[' + element.id_kec + '] ' + element.nama_kec;
                                kec_select.appendChild(option);
                            });
                        } else {
                            console.error('Error:', request.status);
                        }
                        resolve();
                    })
                },
                select_kecs() {
                    return new Promise((resolve, reject) => {
                        const kec_filter = document.getElementById('kec_filter').value;
                        const kab_filter = document.getElementById('kab_filter').value;
                        var request = new XMLHttpRequest();
                        request.open('GET', 'https://st23.bpssumsel.com/api/list_desas?kab_filter=' +
                            kab_filter +
                            '&kec_filter=' + kec_filter,
                            false
                        ); // Set argumen ketiga menjadi false untuk menjalankan permintaan secara sinkron
                        request.send();
                        if (request.status === 200) {
                            var data = JSON.parse(request.responseText);
                            const desa_select = document.getElementById('desa_filter');
                            desa_select.innerHTML = "";
                            var option = document.createElement('option');
                            option.value = "";
                            option.textContent = "Semua";
                            desa_select.appendChild(option);
                            data.data.forEach(element => {
                                var option = document.createElement('option');
                                option.value = element.id_desa;
                                // option.textContent = element.nama_desa;
                                option.textContent = '[' + element.id_desa + '] ' + element
                                    .nama_desa;
                                desa_select.appendChild(option);
                            });
                        } else {
                            console.error('Error:', request.status);
                        }
                        resolve();
                    })
                },
                set_kab(kab_value) {
                    return new Promise((resolve, reject) => {
                        const kab_select = document.getElementById('kab_filter');
                        kab_select.value = kab_value
                        resolve();
                    });

                },
                set_kec(kec_value) {
                    return new Promise((resolve, reject) => {
                        const kec_select = document.getElementById('kec_filter');
                        kec_select.value = kec_value
                        resolve();
                    });
                },
                set_desa(desa_value) {
                    return new Promise((resolve, reject) => {
                        const desa_select = document.getElementById('desa_filter');
                        desa_select.value = desa_value
                        resolve();
                    });
                },
                submit_import(event) {
                    var self = this;
                    event.preventDefault();
                    var fileInput = document.getElementById('import_file'); // Ganti dengan ID input file Anda
                    var file = fileInput.files[0];
                    if (file) {
                        console.log('FormData memiliki isi file');
                        self.loading = true;
                        const formData = new FormData();
                        formData.append('import_file', file);
                        const headers = {
                            'Content-Type': 'multipart/form-data',
                            'X-CSRF-TOKEN': this.csrfToken,
                            'Authorization': 'Bearer ' + this.api_token
                        };

                        $.ajax({
                            url: 'https://st23.bpssumsel.com/api/import_user',
                            type: 'POST',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('X-CSRF-TOKEN', headers['X-CSRF-TOKEN']);
                                xhr.setRequestHeader('Authorization', headers['Authorization']);
                            },
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log(data);
                                self.loading = false;
                                self.showSuccessMessage = true;
                                self.startCountdown()
                            },
                            error: function(error) {
                                console.log(error);
                                self.loading = false;
                            }
                        });
                    } else {
                        console.log('FormData tidak memiliki isi file');
                    }
                },
                startCountdown() {
                    const countdownInterval = setInterval(() => {
                        this.countdown--;
                        if (this.countdown < 0) {
                            clearInterval(countdownInterval);
                            location.reload(); // Merefresh halaman setelah hitungan selesai
                        }
                    }, 1000); // Memperbarui hitungan setiap detik (1000 ms)
                },
                hapus(id, nama) {
                    this.id_hapus = id;
                    this.nama_hapus = nama;
                },
                hapus_confirm() {
                    var self = this;
                    const headers = {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Authorization': 'Bearer ' + this.api_token
                    };
                    fetch('https://st23.bpssumsel.com/api/petugas/' + this.id_hapus, {
                            method: 'DELETE',
                            headers: headers,
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log(response)
                                self.showSuccessMessage = true;
                                setTimeout(function() {
                                    location.reload(); // Merefresh halaman
                                }, 600);
                            } else {
                                console.log(response)
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        });
                },
            }

        });
    </script>
@endsection
