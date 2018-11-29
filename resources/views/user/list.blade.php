<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{$data['name']}}</td>
                <td>{{$data['email']}}</td>
                
                <td><a href="{{action('UserController@edit', $data['id'])}}" class="btn btn-warning">Edit</a></td>
                <td>
                <form action="{{action('UserController@destroy', $data['id'])}}" method="post">
                    @csrf
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
    {{ $datas->links() }} 
</div>