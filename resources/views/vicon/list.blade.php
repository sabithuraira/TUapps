<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>{{ $datas[0]->attributes()['tanggal'] }}</th>
                <th>{{ $datas[0]->attributes()['keperluan'] }}</th>
                <th>{{ $datas[0]->attributes()['ketua'] }}</th>
                <th>{{ $datas[0]->attributes()['jamawalguna'] }}</th>
                <th>{{ $datas[0]->attributes()['jamakhirguna'] }}</th>
                <th>{{ $datas[0]->attributes()['status'] }}</th>

                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['tanggal']}}</td>
                    <td>{{$data['keperluan']}}</td>
                    <td>{{$data['ketua']}}</td>
                    <td type='time'>{{$data['jamawalguna']}}</td>
                    <td type='time'>{{$data['jamakhirguna']}}</td>
                    <td>@if($data->status=='1') Booked
                        @elseif($data->status=='2') Sedang Berlangsung
                        @else Selesai 
                        @endif
                    </td>
                    
                    
                    <td class="text-center"><a href="{{action('ViconController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('ViconController@destroy', $data['id'])}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit"><i class="icon-trash text-danger"></i></button>
                    </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>