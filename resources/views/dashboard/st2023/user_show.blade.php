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
                    <h4>Petugas ST 2023 </h4>
                </div>
                <div class="container">
                    <form id="form_edit">
                        <div class="form-group" hidden>
                            <label for="" class="label">id</label>
                            <input type="text" value="{{ $data['id'] }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Email</label>
                            <input type="text" value="{{ $data['email'] }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="" class="label">Nama</label>
                            <input type="text" value="{{ $data['name'] }}" class="form-control" name="name"
                                id="name">
                        </div>

                        <div class="form-group">
                            <label for="" class="label">Roles</label>
                            <select name="roles" id="roles" class="form-control">
                                <option value="">Pilih Roles</option>
                                @foreach ($list_roles as $roles)
                                    <option value="{{ $roles['name'] }}" @if ($roles['name'] == $data['roles'][0]['name']) selected @endif>
                                        {{ $roles['name'] }}</option>
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
                        // console.log(this.csrf)
                        // console.log(this.csrfToken)
                    })
                    .catch(error => {
                        console.log(error);
                    });
                console.log(this.api_token)

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
                    formData.append('name', document.getElementById('name').value);
                    formData.append('roles', document.getElementById('roles').value);
                    fetch('https://st23.bpssumsel.com/api/petugas/' + this.encId, {
                            method: 'PUT',
                            headers: headers,
                            body: JSON.stringify(Object.fromEntries(formData))
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log(response)
                                localStorage.setItem('successMessage', 'Data berhasil disimpan');
                                location.reload();
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
