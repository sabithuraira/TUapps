@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
        <li class="breadcrumb-item">Fungsional Definitif & Existing</li>
    </ul>
@endsection

@section('content')
    <div class="container">
        <br />
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
                <div class="mb-2 text-right">
                    <a href="{{ url('fungsional_definitif/create') }}" class=" btn btn-info">Tambah</a>
                    <button class="btn btn-info btn-export">export</button>
                </div>
                <div class="row">
                    <form action="{{ url('fungsional_definitif') }}" method="get" class="col-12" id="form_filter">
                        <div class="row  px-3">
                            <div class="col-12 col-md-4">
                                <label for="kab_filter" class="label">Unit Kerja :</label>
                                <select name="kab_filter" id="kab_filter" class="form-control form-control-sm ">
                                    @foreach ($uker as $uk)
                                        <option value="{{ $uk->kode }}"
                                            @if ($request->kab_filter == $uk->kode) selected @endif>{{ $uk->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-md-1 d-flex align-items-end">
                                <button class="btn btn-info " type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-1">

            <div class="card-body pt-1">
                {{-- <div class="text-right mb-2">
                    <button class="btn btn-warning text-white"> <i class="fa fa-pencil"> Edit</i></button>
                </div> --}}
                <section class="datas">
                    @include('fungsional_definitif.list')
                </section>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
    <script>
        $('.btn-export').click(function() {
            var form = $('#form_filter').serialize()
            window.open("{{ url('fungsional_definitif_export') }}" + "?" + form, "_blank")

        })
    </script>
@endsection
