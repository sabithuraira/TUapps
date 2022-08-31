<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Pimpinan</th>
            <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{ $data['name'] }}</td>
                <td>{{ $data['email'] }}</td>
                <td>
                    {{ $data->pimpinan->name }}
                </td>
                
                <td class="text-center"><a href="{{action('UserController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
            </tr>
            @endforeach
            
        </tbody>
    </table><br/>
    {{ $datas->links() }} 
</div>