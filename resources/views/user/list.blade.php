<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th class="text-center" colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{$data['name']}}</td>
                <td>{{$data['email']}}</td>
                
                <td class="text-center"><a href="{{action('UserController@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                <td class="text-center">
                <form action="{{action('UserController@destroy', $data['id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                        <button type="submit"><i class="icon-trash text-danger"></i></button>
                </form>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    {{ $datas->links() }} 
</div>