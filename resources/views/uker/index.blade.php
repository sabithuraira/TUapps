@extends('main')

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <a href="{{action('UkerController@create')}}" class="btn btn-info">Tambah</a>
          <br/><br/>
          <section class="datas">
            @include('uker.list')
          </section>
      </div>
    </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript" src="{!! asset('js/pagination.js') !!}"></script>
@endsection
