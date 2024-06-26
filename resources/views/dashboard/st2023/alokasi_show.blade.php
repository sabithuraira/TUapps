@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Dashboard</li>
    </ul>
@endsection

@section('content')
    {{-- <link rel="stylesheet" href="../assets/vendor/select2/select2.css" /> --}}
    <style>
        .c3-axis-x text {
            font-size: 10px;
        }
    </style>
    <div class="container" id="app_vue">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="body profilepage_2 blog-page pb-0">
                    <h4>Alokasi SLS-Petugas ST 2023 </h4>

                </div>
                <div class="container">
                    <form id="form_edit">
                        <div class="form-group" hidden>
                            <label for="" class="label">id</label>
                            <input type="text" value="{{ $data['id'] }}" readonly>
                        </div>
                        <div class="row">
                            <div class="form-group col-2">
                                <label for="" class="label">Kab</label>
                                <input type="text" value="{{ $data['kode_kab'] }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label for="" class="label">Kec</label>
                                <input type="text" value="{{ $data['kode_kec'] }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label for="" class="label">Desa</label>
                                <input type="text" value="{{ $data['kode_desa'] }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label for="" class="label">ID SLS</label>
                                <input type="text" value="{{ $data['id_sls'] }}" class="form-control" readonly>
                            </div>
                            <div class="form-group col-2">
                                <label for="" class="label">SLS</label>
                                <input type="text" value="{{ $data['nama_sls'] }}" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="label">Kode PCL</label>
                            <select name="kode_pcl" id="kode_pcl" class="form-control show-tick ms select2"
                                data-placeholder="Pilih PCL">
                                <option value="">Pilih PCL</option>
                                @foreach ($list_pcl as $pcl)
                                    <option value="{{ $pcl['email'] }}" @if ($pcl['email'] == $data['kode_pcl']) selected @endif>
                                        {{ $pcl['name'] . ' - ' . $pcl['email'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Kode PML</label>
                            <select name="kode_pml" id="kode_pml" class="form-control">
                                <option value="">Pilih PML</option>
                                @foreach ($list_pml as $pml)
                                    <option value="{{ $pml['email'] }}" @if ($pml['email'] == $data['kode_pml']) selected @endif>
                                        {{ $pml['name'] . ' - ' . $pml['email'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Kode Koseka</label>
                            <select name="kode_koseka" id="kode_koseka" class="form-control">
                                <option value="">Pilih Koseka</option>
                                @foreach ($list_koseka as $koseka)
                                    <option value="{{ $koseka['email'] }}"
                                        @if ($koseka['email'] == $data['kode_koseka']) selected @endif>
                                        {{ $koseka['name'] . ' - ' . $koseka['email'] }}</option>
                                @endforeach
                            </select>
                        </div>

                    </form>
                    <button class="btn btn-primary mb-3 float-right" @click="simpan()">Simpan</button>
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
                    csrf: null,
                    encId: {!! json_encode($data['encId']) !!},
                    api_token: {!! json_encode($api_token) !!},
                    csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                };
            },
            mounted() {
                const self = this;
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


                toastr.options.timeOut = "false";
                toastr.options.closeButton = true;
                toastr.options.positionClass = 'toast-bottom-right';

                window.onload = () => {
                    const successMessage = localStorage.getItem('successMessage');
                    if (successMessage) {
                        console.log(successMessage);
                        $context = "success";
                        $message = "Berhasil Disimpan";
                        $position = "toast-bottom-right";
                        toastr.remove();
                        toastr[$context]($message, '', {
                            positionClass: $position
                        });
                        // Hapus pesan dari localStorage agar tidak ditampilkan kembali setelah refresh
                        localStorage.removeItem('successMessage');
                    }
                };

            },
            methods: {
                simpan(event) {
                    const headers = {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Authorization': 'Bearer ' + this.api_token
                    };

                    const formData = new FormData();
                    formData.append('kode_pcl', document.getElementById('kode_pcl').value);
                    formData.append('kode_pml', document.getElementById('kode_pml').value);
                    formData.append('kode_koseka', document.getElementById('kode_koseka').value);


                    fetch('https://st23.bpssumsel.com/api/alokasi/' + this.encId, {
                            method: 'PUT',
                            headers: headers,
                            body: JSON.stringify(Object.fromEntries(formData))
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log(response)
                                localStorage.setItem('successMessage', 'Data berhasil disimpan');
                                location.reload();
                                // self.showSuccessMessage = true;
                                // setTimeout(function() {
                                //     location.reload(); // Merefresh halaman
                                // }, 600);
                            } else {
                                console.log(response)
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        });
                }
            }

        });
    </script>
@endsection
