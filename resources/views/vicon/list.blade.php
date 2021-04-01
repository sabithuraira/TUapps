<div id="load" class="table-responsive">
    <table class="table-sm table-bordered m-b-0" style="width:100%">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr class="text-center">
                    <th rowspan="2">{{ $datas[0]->attributes()['tanggal'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['keperluan'] }}</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['ketua'] }}</th>
                    <th colspan="2">Waktu</th>
                    <th rowspan="2">{{ $datas[0]->attributes()['status'] }}</th>
                    <th rowspan="2" class="text-center" colspan="2">Action</th>
                </tr>
                
                <tr class="text-center">
                    <th>{{ $datas[0]->attributes()['jamawalguna'] }}</th>
                    <th>{{ $datas[0]->attributes()['jamakhirguna'] }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td class="text-center">{{ date("d M Y", strtotime($data['tanggal'])) }}</td>
                    <td>{{ $data['keperluan'] }}</td>
                    <td class="text-center">{{ $data['ketua'] }}</td>
                    <td class="text-center">{{ date('H:i', strtotime($data['jamawalguna'])) }}</td>
                    <td class="text-center">{{ date('H:i', strtotime($data['jamakhirguna'])) }}</td>
                    <td class="text-center">
                        @if($data->status=='1') 
                            @if($data->tanggal>=date("Y-m-d")) Booked
                            @else Selesai 
                            @endif
                        @else Dibatalkan 
                        @endif
                    </td>
                    
                    <td class="text-center">
                        @if($data->status==1)
                        <a href="{{action('ViconController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($data->status==1)
                        <form action="{{action('ViconController@destroy', $data['id'])}}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit"><i class="icon-trash text-danger"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>