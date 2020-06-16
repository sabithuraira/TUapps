<div id="load" class="table-responsive social_media_table">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <th>
                        <img src="{!! $data->fotoUrl !!}" class="rounded-circle user-photo" width="30">
                    </th>
                    <td>
                        <span class="list-name">{{ $data['name'] }}</span>
                        <span class="text-muted">{{ $data['nip_baru'] }}</span>
                    </td>
                    <td>
                        <span class="list-name">{{ $data['nmwil'] }}</span>
                        <span class="text-muted">{{ $data['nmorg'] }}</span>
                    </td>
                    <!-- <td>
                        <div class="text-success">
                            23 <i class="fa fa-long-arrow-up"></i>
                        </div>
                        <div class="text-muted">up</div>
                    </td> -->
                    
                    <td class="text-center">
                        <a href="{{action('PegawaiAndaController@profile', Crypt::encrypt($data['id']))}}"><i class="fa fa-search text-info"></i></a>
                    </td>
                    
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>