<div id="load" class="table-responsive">
    <table class="table table-sm m-b-0 table-bordered">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                    <th></th>
                    <th class="text-center" colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td class="text-center">
                        
                        @if($data->is_secret==1)
                            <span v-if="e_is_secret==1" class="badge badge-danger mb-2">RAHASIA</span>
                        @endif
                        <h6 class="margin-0" style="wrap-text: true">{{ $data['judul'] }}</h6>
                        <p class="badge badge-info">{{ date('d F Y H:i', strtotime($data['waktu_mulai'])) }} - {{ date('d F Y H:i', strtotime($data['waktu_selesai'])) }}</p>
                        <br/>
                        <span>Jumlah Peserta: {{ $data['totalPeserta'] }}</span>
                    </td>

                    <td class="text-center">
                        @if($data->is_secret==1)
                            @if($data->isPeserta)
                            <a href="{{ action('MeetingController@detail', $data['id']) }}"><i class="icon-magnifier text-info"></i></a>
                            @endif
                        @else
                            <a href="{{ action('MeetingController@detail', $data['id']) }}"><i class="icon-magnifier text-info"></i></a>
                        @endif
                    </td>
                    
                    <td class="text-center">
                        @if (auth()->user()->id==$data->created_by || auth()->user()->hasRole('superadmin'))
                        <a href="{{action('MeetingController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a>
                        @endif
                    </td>
                    <td class="text-center">
                        
                        @if (auth()->user()->id==$data->created_by || auth()->user()->hasRole('superadmin'))
                        <form action="{{action('MeetingController@destroy', $data['id'])}}" method="post">
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