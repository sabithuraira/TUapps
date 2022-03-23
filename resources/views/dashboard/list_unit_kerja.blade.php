<div class="card weather2">
    <table class="table table-sm table-striped">
        <thead>
            <tr class="text-center">
                <th colspan="2">Jumlah DL Pegawai Hari Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dl_per_uk as $value)
                <tr>
                    <td>{{ $value->nama }}</td>
                    <td class="font-medium">{{ $value->total }} Pegawai</td>
                </tr>
            @endforeach
    </table>
</div>