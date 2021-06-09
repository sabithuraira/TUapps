@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('prosedur')}}">User Management</a></li>                            
    <li class="breadcrumb-item">{{ $model->name }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix" id="app">
  <div class="col-md-12">
      <div class="card">
            <div class="header">
                <h2>User Detail Role & Permission</h2>
            </div>
            <div class="body">
                <form method="post" action="{{action('PenugasanController@user_role_update', $id)}}" enctype="multipart/form-data">
                @csrf
                <input name="_method" type="hidden" value="PATCH">
                
                <fieldset disabled>
                    <div class="form-group">
                        <label>Nama :</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $model->name) }}">
                    </div>

                    <div class="form-group">
                        <label>Badge No :</label>
                        <input type="text" class="form-control" name="email" value="{{ old('email', $model->email) }}">
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Roles:</label>

                    <select id="optrole" name="optrole[]" class="ms" multiple="multiple">
                        @foreach($all_roles as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                        @endforeach
                    </select>
                </div>

                <br>
                <button type="submit" class="btn btn-primary">Simpan</button>

              </form>
          </div>
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
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/multi-select/css/multi-select.css') !!}">
@endsection

@section('scripts')
<script src="{!! asset('lucid/assets/vendor/multi-select/js/jquery.multi-select.js') !!}"></script>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
    var vm = new Vue({  
        el: "#app",
        data:  {
            list_roles: {!! json_encode($model->roles) !!},
            list_permissions: {!! json_encode($model->permissions) !!},
        },
        methods: {
            getDatas: function(){
                var self = this;
                $('#wait_progres').modal('show');

                var roles_val =[];
                var permissions_val =[];

                for(i=0;i<self.list_roles.length;++i){
                    roles_val.push(self.list_roles[i].id);
                }

                for(i=0;i<self.list_permissions.length;++i){
                    permissions_val.push(self.list_permissions[i].id);
                }

                $("#optrole").val(roles_val);
                $("#optrole").multiSelect("refresh");
                
                $("#optpermission").val(permissions_val);
                $("#optpermission").multiSelect("refresh");

                $('#wait_progres').modal('hide');
            },
        }
    });

    $(document).ready(function() {
        vm.getDatas();
    });

    // // //Multi-select
    $('#optrole').multiSelect();
    $('#optpermission').multiSelect();
</script>
@endsection