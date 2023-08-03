<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr class="text-center">
                <th></th>
                <th>Jabatan</th>
                <th>ABK</th>
                <th>Exsisting</th>
                <th>User</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $dt)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $dt->nama_jabatan }}</td>
                    <td class="text-center">{{ $dt->abk }}</td>
                    <td class="text-center">
                        {{ count($dt->user($request->kab_filter)) }}
                    </td>
                    <td>
                        <ul class="m-0 ">
                            @foreach ($dt->user($request->kab_filter) as $usr)
                                <li>
                                    {{ $usr->name }}
                                </li>
                            @endforeach
                        </ul>
                    </td>

                    <td class="text-center">
                        <a href="{{ action('FungsionalDefinitifController@edit', $dt['id']) }}">
                            <i class="icon-pencil text-info"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <form action="{{ action('FungsionalDefinitifController@destroy', $dt->id) }}" method="post">
                            @csrf
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit"><i class="icon-trash text-danger"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
