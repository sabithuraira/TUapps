<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr class="text-center">
                    <th>Nama</th>
                    <th>Badge No</th>
                    <th>Role</th>
                    <th>Permission</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['email'] }}</td>
                    <td>
                        <ul>
                        @foreach($data->getRoleNames() as $role)
                            <li>{{ $role }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <ul>
                        @foreach($data->permissions as $permission)
                            <li>{{ $permission['name'] }}</li>
                        @endforeach
                        </ul>
                    </td>
                    <td><a href="{{action('PenugasanController@user_role_edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        @endif
    </table>
    
    {{ $datas->links() }} 
</div>