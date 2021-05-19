@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>                     
    <li class="breadcrumb-item">Dashboard</li>
</ul>
@endsection

@section('content')
    <div class="container"  id="app_vue">
        <div class="card">
            Halo semuanya
            @{{ label }}

            <button v-on:click="tambahHewan">Tambah</button>
            <ul>
                <li v-for="(data, index) in daftar_hewan">
                    @{{ data }}
                </li>
            </ul>
        </div>
    </div>
@endsection


@section('scripts')
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script>
var vm = new Vue({  
    el: "#app_vue",
    data:  {
      label: "hai bro",
      daftar_hewan: ['Kucing', "Bebek", 'Jerapah'],
    },
    methods: {
        tambahHewan: function(){
            var self = this;
            self.daftar_hewan.push("Ayam");
        },
    }
});

</script>

@endsection
