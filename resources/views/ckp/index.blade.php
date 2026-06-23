@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">CKP</li>
</ul>
@endsection

@section('content')
<div id="app_vue">
    <div class="container">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div><br />
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-danger">
                <p>{{ \Session::get('error') }}</p>
            </div><br />
        @endif

        <div class="card">
            <div class="body">
                @if ($can_create)
                <a href="{{action('CkpController@create')}}" class="btn btn-info">Buat CKP</a>
                @endif
                <button type="button" class="btn btn-success" id="btn_import_ckp">Import Excel</button>
                <br/>
                @if ($can_create)
                <p class="text-small text-muted font-italic float-left">*Klik "Buat CKP" untuk merubah, menambah atau menghapus rincian CKP.</p>
                @endif
                <br/><br/>
                <div class="row clearfix">
                    <div class="col-lg-6 col-md-12 left-box">
                        <div class="form-group">
                            <label>Bulan:</label>
                            <div class="input-group">
                                <select class="form-control form-control-sm" v-model="month" name="month">
                                    @foreach ( config('app.months') as $key=>$value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 right-box">
                        <div class="form-group">
                            <label>Tahun:</label>
                            <div class="input-group">
                                <select class="form-control form-control-sm" v-model="year" name="year">
                                    @for ($i=2019;$i<=date('Y');$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="datas">
                    @include('ckp.list')
                </section>
            </div>
        </div>
    </div>
</div>

<div id="wait_progres" class="ckp-loading-overlay" style="display:none;">
    <div class="ckp-loading-box text-center">
        <img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="120" height="120" alt="Loading...">
        <h4 class="m-t-10">Please wait...</h4>
    </div>
</div>

<div id="modal_import_ckp" class="ckp-import-overlay" style="display:none;">
    <div class="ckp-import-dialog">
        <div class="ckp-import-header">
            <h4 class="title m-b-0">Import Data CKP dari Excel</h4>
            <button type="button" class="close ckp-import-close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="ckp-import-body">
            <form id="form_import_ckp" action="{{ url('ckp/import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="month" id="import_month" value="{{ $month }}">
                <input type="hidden" name="year" id="import_year" value="{{ $year }}">
                <div class="form-group">
                    <label>File Excel (.xlsx / .xls)</label>
                    <input type="file" class="form-control" name="excel_file" accept=".xlsx,.xls" required>
                </div>
                <p class="text-muted text-small m-b-0">
                    Data diimport untuk periode bulan dan tahun yang dipilih di halaman ini.
                    Kolom yang diimport: Uraian Kegiatan, Satuan, Target, Realisasi, dan Tingkat Kualitas (mulai baris 11).
                </p>
            </form>
        </div>
        <div class="ckp-import-footer">
            <button type="button" class="btn btn-default ckp-import-close">Batal</button>
            <button type="submit" class="btn btn-primary" form="form_import_ckp">Import</button>
        </div>
    </div>
</div>
@endsection

@section('css')
<meta name="_token" content="{{ csrf_token() }}">
<style type="text/css">
    * {font-family: Segoe UI, Arial, sans-serif;}
    table{font-size: small;border-collapse: collapse;}
    tfoot tr td{font-weight: bold;font-size: small;}
    .ckp-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.35);
        z-index: 99999998;
    }
    .ckp-loading-box {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        padding: 24px 32px;
        border-radius: 6px;
    }
    .ckp-import-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 100000000;
        overflow-y: auto;
        padding: 40px 16px;
    }
    .ckp-import-dialog {
        position: relative;
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
        background: #fff;
        border-radius: 6px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }
    .ckp-import-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #e9ecef;
    }
    .ckp-import-body {
        padding: 20px;
    }
    .ckp-import-footer {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        padding: 12px 20px 16px;
        border-top: 1px solid #e9ecef;
    }
</style>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({
    el: "#app_vue",
    data: {
        kegiatan_utama: [],
        kegiatan_tambahan: [],
        type: 1,
        month: parseInt({!! json_encode($month) !!}),
        year: {!! json_encode($year) !!},
        total_utama: 1,
        total_tambahan: 1,
        pathname: window.location.pathname,
    },
    computed: {
        total_kuantitas: function(){
            var result = 0;
            var jumlah_kegiatan = 0;

            for (i = 0; i < this.kegiatan_utama.length; ++i) {
                if (typeof this.kegiatan_utama[i].target_kuantitas !== 'undefined') {
                    if ((this.kegiatan_utama[i].realisasi_kuantitas / this.kegiatan_utama[i].target_kuantitas * 100) > 100) {
                        result += 100;
                    } else {
                        result += (this.kegiatan_utama[i].realisasi_kuantitas / this.kegiatan_utama[i].target_kuantitas * 100);
                    }
                    jumlah_kegiatan++;
                }
            }

            for (i = 0; i < this.kegiatan_tambahan.length; ++i) {
                if (typeof this.kegiatan_tambahan[i].target_kuantitas !== 'undefined') {
                    if ((this.kegiatan_tambahan[i].realisasi_kuantitas / this.kegiatan_tambahan[i].target_kuantitas * 100) > 100) {
                        result += 100;
                    } else {
                        result += (this.kegiatan_tambahan[i].realisasi_kuantitas / this.kegiatan_tambahan[i].target_kuantitas * 100);
                    }
                    jumlah_kegiatan++;
                }
            }

            return jumlah_kegiatan ? parseFloat(result / jumlah_kegiatan).toFixed(2) : 0;
        },
        total_kualitas: function(){
            var result = 0;

            for (i = 0; i < this.kegiatan_utama.length; ++i) {
                if (typeof this.kegiatan_utama[i].kualitas !== 'undefined' && this.kegiatan_utama[i].kualitas != null && this.kegiatan_utama[i].kualitas != '') {
                    result += parseInt(this.kegiatan_utama[i].kualitas);
                }
            }

            for (i = 0; i < this.kegiatan_tambahan.length; ++i) {
                if (typeof this.kegiatan_tambahan[i].kualitas !== 'undefined' && this.kegiatan_tambahan[i].kualitas != null && this.kegiatan_tambahan[i].kualitas != '') {
                    result += parseInt(this.kegiatan_tambahan[i].kualitas);
                }
            }

            var total = this.kegiatan_utama.length + this.kegiatan_tambahan.length;
            return total ? parseFloat(result / total).toFixed(2) : 0;
        }
    },
    watch: {
        type: function () {
            this.setDatas();
        },
        month: function (val) {
            $('#import_month').val(val);
            this.setDatas();
        },
        year: function (val) {
            $('#import_year').val(val);
            this.setDatas();
        },
    },
    methods: {
        nilaiRata2: function(val1, val2, val3){
            if (typeof val1 == 'undefined' || val1 == '' || val1 == null) val1 = 0;
            if (typeof val2 == 'undefined' || val2 == '' || val2 == null) val2 = 0;
            if (typeof val3 == 'undefined' || val3 == '' || val3 == null) val3 = 0;

            return ((parseInt(val1) + parseInt(val2) + parseInt(val3)) / 3).toFixed(2);
        },
        setDatas: function(){
            var self = this;
            $('#wait_progres').show();
            $.ajax({
                url: "{{ url('ckp/data_ckp') }}",
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                data: {
                    month: self.month,
                    year: self.year,
                    type: self.type,
                },
            }).done(function (data) {
                self.kegiatan_utama = data.datas.utama;
                self.kegiatan_tambahan = data.datas.tambahan;
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
            }).always(function () {
                $('#wait_progres').hide();
            });
        },
    }
});

$(document).ready(function() {
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();

    $('#import_month').val(vm.month);
    $('#import_year').val(vm.year);
    vm.setDatas();

    $('#btn_import_ckp').on('click', function() {
        $('#import_month').val(vm.month);
        $('#import_year').val(vm.year);
        $('#modal_import_ckp').show();
    });

    $('.ckp-import-close').on('click', function() {
        $('#modal_import_ckp').hide();
    });

    $('#modal_import_ckp').on('click', function(e) {
        if (e.target === this) {
            $('#modal_import_ckp').hide();
        }
    });
});
</script>
@endsection
