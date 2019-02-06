@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Role</li>
</ul>
@endsection

@section('content')
    <div class="container" id="app">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <a href="#" id="btn-tambah" class="btn btn-info">Tambah</a>
          <br/><br/>

          <form action="{{url('prosedur')}}" method="get">
            <div class="input-group mb-3">
                    
                    @csrf
                    <input type="text" class="form-control" name="search" id="search" value="{{ $keyword }}" placeholder="Search..">

                    <div class="input-group-append">
                        <button class="btn btn-info" type="submit"><i class="fa fa-search"></i></button>
                    </div>
            </div>
          </form>

          <section class="datas">
            @include('user_role.list')
            
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


    <div id="form_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span id="myModalLabel">Role</span>
                </div>
                
                <div class="modal-body">
                    <table class="table table-hover table-condensed">
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="Nama role..." name="role_name" v-model="role_name"></td>  
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                    <button class="btn btn-primary" data-dismiss="modal" id="btn-submit">Save changes</button>
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
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    var vm = new Vue({  
        el: "#app",
        data:  {
            role_name : '',
            id: 0,
        },
        methods: {
            saveDatas: function () {
                var self = this;
                $('#wait_progres').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                })
                $.ajax({
                    url : "{{ url('/role/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id,
                        role_name: self.role_name,
                    },
                }).done(function (data) {
                    self.id = 0;
                    self.role_name = '';
                    $('#wait_progres').modal('hide');
                    window.location.reload(false);
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
                    $('#wait_progres').modal('hide');
                });
            },
        }
    });

    $(document).ready(function() {
    });

    $('#btn-tambah').click(function(e) {
        e.preventDefault();
        $('#form_modal').modal('show');
        vm.id = 0;
    });
    
    $('#btn-edit').click(function(e) {
        e.preventDefault();
        $('#form_modal').modal('show');
        vm.id = $(this).data("id");
        vm.role_name = $(this).data("name");
    });

    $('#btn-submit').click(function() {
        vm.saveDatas();
    });
</script>
@endsection
