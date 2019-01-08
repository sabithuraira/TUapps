@if (\Session::has('success'))
  <div class="alert alert-success">
    <p>{{ \Session::get('success') }}</p>
  </div><br />
@endif

<div class="card">
  <div class="body">

             <div class="row clearfix">
                <div class="col-lg-4 col-md-12 left-box">

                    <div class="form-group">
                        <label>Tipe:</label>

                        <div class="input-group">
                          <select class="form-control"  v-model="type" id="type">
                              @foreach ($model->listType as $key=>$value)
                                  <option value="{{ $key }}">{{ $value }}</option>
                              @endforeach
                          </select>

                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4 col-md-12 left-box">
                    <div class="form-group">
                        <label>Bulan:</label>

                        <div class="input-group">
                          <select class="form-control"  name="month" id="month">
                                @foreach ( config('app.months') as $key=>$value)
                                    <option value="{{ $key }}" 
                                      @if ($month == $key)
                                            selected="selected"
                                        @endif >{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 right-box">
                    <div class="form-group">
                        <label>Tahun:</label>

                        <div class="input-group">
                          <select class="form-control"  name="year" id="year">
                              @for ($i=2018;$i<=date('Y');$i++)
                                  <option value="{{ $i }}" 
                                    @if ($year == $i)
                                          selected="selected"
                                      @endif >{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>

    <button type="submit" class="btn btn-primary float-right">Simpan</button>
    <br/><br/>
    <section class="datas">

      <div class="table-responsive">
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">{{ $model->attributes()['uraian'] }}</th>
                    <th rowspan="2">{{ $model->attributes()['satuan'] }}</th>
                    
                    <th v-if="type==1" rowspan="2">Target Kuantitas</th>
                    <template v-else>
                        <th colspan="3">Kuantitas</th>
                        <th rowspan="2">Tingkat Kualitas</th>
                    </template>

                    <th rowspan="2">{{ $model->attributes()['kode_butir'] }}</th>
                    <th rowspan="2">{{ $model->attributes()['angka_kredit'] }}</th>
                    <th rowspan="2">{{ $model->attributes()['keterangan'] }}</th>
                </tr>

                <tr v-show="type!=1">
                    <th>Target</th>
                    <th>Realisasi</th>
                    <th>%</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="data in datas" :key="data.id" >
                    <td>@{{ data.uraian }}</td>
                    <td>@{{ data.satuan }}</td>
                    
                    <td v-if="type==1">@{{ data.target_kuantitas }}</td>
                    <template v-else>
                        <td>@{{ data.target_kuantitas }}</td>
                        <td>@{{ data.realisasi_kuantitas }}</td>
                        <td>%</td>
                        <td>@{{ data.kualitas }}</td>
                    </template>

                    <td>@{{ data.kode_butir }}</td>
                    <td>@{{ data.angka_kredit }}</td>
                    <td>@{{ data.keterangan }}</td>

                </tr>
            </tbody>
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

@section('css')
  <meta name="_token" content="{{csrf_token()}}" />
  <meta name="csrf-token" content="@csrf">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      datas: [],
      type: 1,
    }
});

  $(document).ready(function() {
      setDatas();
  });


  $('#month').change(function() {
      setDatas();
  });

  $('#year').change(function() {
      setDatas();
  });
  
  $('#type').change(function() {
      setDatas();
  });

  function setDatas(){
    $('#wait_progres').modal('show');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $.ajax({
        url : "{{ url('/ckp/data_ckp/') }}",
        method : 'post',
        dataType: 'json',
        data:{
            month: $('#month').val(), 
            year: $('#year').val(), 
            type: $('#type').val(),
        },
    }).done(function (data) {
        console.log(data);
        vm.datas = data.datas;

        $('#wait_progres').modal('hide');
    }).fail(function (msg) {
        console.log(JSON.stringify(msg));
        $('#wait_progres').modal('hide');
    });
  }
</script>
@endsection