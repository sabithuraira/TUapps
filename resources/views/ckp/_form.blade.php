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
                          <select class="form-control  form-control-sm"  v-model="type" name="type">
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
                          <select class="form-control  form-control-sm"  v-model="month" name="month">
                                @foreach ( config('app.months') as $key=>$value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 right-box">
                    <div class="form-group">
                        <label>Tahun:</label>

                        <div class="input-group">
                          <select class="form-control  form-control-sm"  v-model="year" name="year">
                              @for ($i=2018;$i<=date('Y');$i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                              @endfor
                          </select>
                        </div>
                    </div>
                </div>

            </div>
            <input type="hidden" name="total_tambahan" :v-model="total_tambahan">
            <input type="hidden" name="total_utama" :v-model="total_utama">
    <hr/>
    <button type="submit" class="btn btn-primary float-right">Simpan</button>
    <br/><br/>
    <section class="datas">

      <div class="table-responsive">
        <table class="table m-b-0">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th class="text-center" rowspan="2">{{ $model->attributes()['uraian'] }}</th>
                    <th class="text-center" rowspan="2">{{ $model->attributes()['satuan'] }}</th>
                    
                    <th v-if="type==1" class="text-center" rowspan="2">Target Kuantitas</th>
                    <template v-else>
                        <th class="text-center" colspan="3">Kuantitas</th>
                        <th class="text-center" rowspan="2">Tingkat Kualitas</th>
                    </template>

                    <th class="text-center" rowspan="2">{{ $model->attributes()['kode_butir'] }}</th>
                    <th class="text-center" rowspan="2">{{ $model->attributes()['angka_kredit'] }}</th>
                    <th class="text-center" rowspan="2">{{ $model->attributes()['keterangan'] }}</th>
                </tr>

                <tr v-show="type!=1">
                    <th class="text-center" >Target</th>
                    <th class="text-center" >Realisasi</th>
                    <th class="text-center" >%</th>
                </tr>
            </thead>

            <tbody>
                <tr><td :colspan="total_column">UTAMA &nbsp &nbsp<a id="add-utama" v-on:click="addData"><i class="icon-plus text-info"></i></a></td></tr>
                <tr v-for="(data, index) in kegiatan_utama" :key="data.id">
                    <td>@{{ index+1 }}</td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'uraian'+data.id" :value="data.uraian"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'satuan'+data.id" :value="data.satuan"></td>
                    
                    <td v-if="type==1">
                        <input class="form-control  form-control-sm" type="text" :id="'target_kuantitas'+data.id" :value="data.target_kuantitas">
                    </td>
                    <template v-else>
                        <td><input class="form-control  form-control-sm" type="text" :id="'target_kuantitas'+data.id" :value="data.target_kuantitas"></td>
                        <td><input class="form-control  form-control-sm" type="text":id="'realisasi_kuantitas'+data.id" :value="data.realisasi_kuantitas"></td>
                        <td>%</td>
                        <td><input class="form-control  form-control-sm" type="text" :id="'kualitas'+data.id" :value="data.kualitas"></td>
                    </template>

                    <td><input class="form-control  form-control-sm" type="text" :id="'kode_butir'+data.id" :value="data.kode_butir"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'angka_kredit'+data.id" :value="data.angka_kredit"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'keterangan'+data.id" :value="data.keterangan"></td>
                </tr>
                
                <tr><td :colspan="total_column">TAMBAHAN &nbsp &nbsp<a id="add-tambahan" v-on:click="addData"><i class="icon-plus text-info"></i></a></td></tr>
                <tr v-for="(data, index) in kegiatan_tambahan" :key="data.id" >
                    <td>@{{ index+1 }}</td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'uraian'+data.id" :value="data.uraian"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'satuan'+data.id" :value="data.satuan"></td>
                    
                    <td v-if="type==1">
                        <input class="form-control  form-control-sm" type="text" :id="'target_kuantitas'+data.id" :value="data.target_kuantitas">
                    </td>
                    <template v-else>
                        <td><input class="form-control  form-control-sm" type="text" :id="'target_kuantitas'+data.id" :value="data.target_kuantitas"></td>
                        <td><input class="form-control  form-control-sm" type="text":id="'realisasi_kuantitas'+data.id" :value="data.realisasi_kuantitas"></td>
                        <td>%</td>
                        <td><input class="form-control  form-control-sm" type="text" :id="'kualitas'+data.id" :value="data.kualitas"></td>
                    </template>

                    <td><input class="form-control  form-control-sm" type="text" :id="'kode_butir'+data.id" :value="data.kode_butir"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'angka_kredit'+data.id" :value="data.angka_kredit"></td>
                    <td><input class="form-control  form-control-sm" type="text" :id="'keterangan'+data.id" :value="data.keterangan"></td>
                
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
      kegiatan_utama: [],
      kegiatan_tambahan: [],
      type: 1,
      month: parseInt({!! json_encode($month) !!}),
      year: {!! json_encode($year) !!},
      total_utama: 1,
      total_tambahan: 1,
    },
    computed: {
        total_column: function () {
            if(this.type==1)
                return 7;
            eles
                return 10;
        }
    },
    methods: {
        setDatas: function(){
            var self = this;
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
                    month: self.month, 
                    year: self.year, 
                    type: self.type,
                },
            }).done(function (data) {
                self.kegiatan_utama = data.datas.utama;
                self.kegiatan_tambahan = data.datas.tambahan;

                self.kegiatan_utama.push({
                    'id': 'au'+self.kegiatan_utama.length,
                });
                
                self.kegiatan_tambahan.push({
                    'id': 'au'+this.kegiatan_tambahan.length,
                });

                $('#wait_progres').modal('hide');
            }).fail(function (msg) {
                console.log(JSON.stringify(msg));
                $('#wait_progres').modal('hide');
            });
        },
        addData: function (event) {
            var self = this;
            if (event) {
                // alert(event.currentTarget.id)
                if(event.currentTarget.id=='add-utama')
                {
                    this.kegiatan_utama.push({
                        'id': 'au'+this.kegiatan_utama.length,
                    });
                    self.total_utama++;
                }
                else{
                    this.kegiatan_tambahan.push({
                        'id': 'at'+this.kegiatan_tambahan.length,
                    });
                    self.total_tambahan++;
                }

            }
        }
    }
});

    $(document).ready(function() {
        vm.setDatas();
    });


    $('#month').change(function() {
        vm.setDatas();
    });

    $('#year').change(function() {
        vm.setDatas();
    });
  
    $('#type').change(function() {
        vm.setDatas();
    });
</script>
@endsection