<div id="load" class="table-responsive">
    <table style="min-width:100%" class="table-bordered m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>{{ $datas[0]->attributes()['user_id'] }}</th>
                <th>{{ $datas[0]->attributes()['iki_label'] }}</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data['User']['name'] }}</td>
                    <td>{{ $data['iki_label'] }} </td>
                    
                    <td class="text-center"><a href="{{action('IkiController@edit', Crypt::encrypt($data['id']))}}"><i class="icon-pencil text-info"></i></a></td>
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    <br/>
    {{ $datas->links() }} 
</div>