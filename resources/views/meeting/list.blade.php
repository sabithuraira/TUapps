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
                    <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td class="text-center">
                        <h6 class="margin-0" style="wrap-text: true">{{ $data['judul'] }}</h6>
                        <br/>
                        <p class="badge badge-info">{{ date('d F Y H:i', strtotime($data['waktu_mulai'])) }} - {{ date('d F Y H:i', strtotime($data['waktu_selesai'])) }}</p>
                        
                        <p style="wrap-text: true">Jumlah Peserta: {{ $data['totalPeserta'] }}</p>
                    </td>

                    <td class="text-center"><a href="{{action('MeetingController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('MeetingController@destroy', $data['id'])}}" method="post">
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