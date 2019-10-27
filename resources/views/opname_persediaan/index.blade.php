@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Opname Barang</li>
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

      <div class="card">
        <div class="body">
          <a href="{{action('MasterBarangController@create')}}" class="btn btn-info">Tambah</a>
          <br/><br/>
          <form action="{{url('master_barang')}}" method="get">
            <div class="input-group mb-3">
                    
                    @csrf
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis:</label>

                            <div class="input-group">
                              <select class="form-control">
                              </select>
                            </div>
                        </div>
                    </div>
                    
                    <div v-show="jenis==2" class="col-md-4 left">
                        <div class="form-group">
                            <label>Minggu ke:</label>

                            <div class="input-group">
                                <select class="form-control">
                                    @for ($i=1;$i<=5;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div v-show="jenis==1" class="col-md-4 left">
                        <div class="form-group">
                            <label>Tanggal:</label>

                            <div class="input-group">
                                <select class="form-control">
                                    @for ($i=1;$i<=31;$i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </div>
            </div>
          </form>
          <section class="datas">
          </section>
      </div>
    </div>


    <div class="modal hide" id="wait_progres" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center"><img src="{!! asset('lucid/assets/images/loading.gif') !!}" width="200" height="200" alt="Loading..."></div>
                    <h4 class="text-center">Please wait...</h4>
                </div>
            </div>
        </div>
    </div>

  </div>
@endsection

@section('css')
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/markdown/markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/to-markdown/to-markdown.js') !!}"></script>
<script src="{!! asset('lucid/assets/vendor/bootstrap-markdown/bootstrap-markdown.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
@endsection