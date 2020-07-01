<div id="load" class="table-responsive">
    <table class="table m-b-0">
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
                    
                    <td class="text-center"><a href="{{action('IkiController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('IkiController@destroy', $data['id'])}}" method="post">
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