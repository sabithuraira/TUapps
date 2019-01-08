<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['uraian'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['satuan'] }}</th>
                    
                    @if (type==1)
                        <th rowspan="2">Target Kuantitas</th>
                    @else  
                        <th colspan="3">Kuantitas</th>
                        <th rowspan="2">Tingkat Kualitas</th>
                    @endif     
                    <th rowspan="2">{{ $datas[0]->attributes()['kode_butir'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['angka_kredit'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['keterangan'] }}</th>
                </tr>


                @if (type==1)
                <tr>
                    <th>Target</th>
                    <th>Realisasi</th>
                    <th>%</th>
                </tr>
                @endif 


            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach($datas as $data)
                    @php
                        $i++;
                    @endphp
                    <tr>
                        <td>{{$data['uraian']}}</td>
                        <td>{{$data['satuan']}}</td>
                        
                        @if (type==1)
                            <td>{{$data['target_kuantitas']}}</td>
                        @else
                            <td>{{$data['target_kuantitas']}}</td>
                            <td>{{$data['realisasi_kuantitas']}}</td>
                            <td>{{ $data['realisasi_kuantitas']/$data['target_kuantitas']*100 }} %</td>
                            <td>{{$data['kualitas']}}</td>
                        @endif 
                        <td>{{$data['kode_butir']}}</td>
                        <td>{{$data['angka_kredit']}}</td>
                        <td>{{$data['keterangan']}}</td>
                    </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
</div>