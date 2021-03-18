@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Permission</li>
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
          <section class="datas">
            <div id="load" class="table-responsive">
              <table class="table m-b-0">
                  @if (count($datas)==0)
                      <thead>
                          <tr><th>Tidak ditemukan data</th></tr>
                      </thead>
                  @else
                      <thead>
                          <tr>
                              <th>Permission</th>
                              <th></th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach($datas as $data)
                          <tr>
                              <td>{{ $data['name'] }}</td>
                              <td class="text-center"><a href="#" data-id="{{ $data['id'] }}" data-name="{{ $data['name'] }}" id="btn-edit"><i class="icon-pencil text-info"></i></a></td>
                          </tr>
                          @endforeach
                      </tbody>
                  @endif
              </table>
            </div>
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
                    <span id="myModalLabel">Permission</span>
                </div>
                
                <div class="modal-body">
                    <table class="table table-hover table-condensed">
                        <tbody>
                            <tr>
                                <td><input type="text" class="form-control" placeholder="Nama permission..." name="permission_name" v-model="permission_name"></td>  
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
            permission_name : '',
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
                    url : "{{ url('/permission/') }}",
                    method : 'post',
                    dataType: 'json',
                    data:{
                        id: self.id,
                        permission_name: self.permission_name,
                    },
                }).done(function (data) {
                    self.id = 0;
                    self.permission_name = '';
                    window.location.reload(false);
                }).fail(function (msg) {
                    console.log(JSON.stringify(msg));
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
        vm.permission_name = $(this).data("name");
    });

    $('#btn-submit').click(function() {
        vm.saveDatas();
    });
</script>
@endsection
