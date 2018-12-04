<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
            <th>Uraian</th>
            <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{$data['uraian']}}</td>
                
                <td><a href="{{action('TypeKreditController@edit', $data['id'])}}" class="btn btn-warning">Edit</a></td>
                <td>
                <form action="{{action('TypeKreditController@destroy', $data['id'])}}" method="post">
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