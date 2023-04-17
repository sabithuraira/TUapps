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
                <form action="{{ url('fungsional_definitif/' . $id) }}" method="post">
                    @method('PUT')
                    @csrf
                    @include('fungsional_definitif.form')
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
