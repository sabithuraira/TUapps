<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Atasan Langsung</th>
                <th>Status Aktif</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td> <a href="{{ action('DashboardController@profile', Crypt::encrypt($data['nip_baru'])) }}">
                            {{ $data['name'] }}
                        </a>
                    </td>
                    <td>{{ $data['pimpinan_nama'] }}</td>
                    <td>{{  $data->statusAktif[$data['is_active']] }}</td>
                    <td class="text-center"><a href="{{ action('UserController@edit', $data['id']) }}"><i
                                class="icon-pencil text-info"></i></a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    {{ $datas->links() }}
</div>
