<div class="card weather2">
    <div class="body city-selected">
        <div class="row">
            <div class="col-12">
                <div class="city">Jumlah DL Pegawai Hari Ini</div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <tbody>
            @foreach($dl_per_uk as $value)
                <tr>
                    <td>{{ $value->nama }}</td>
                    <td class="font-medium">{{ $value->total }} Pegawai</td>
                </tr>
            @endforeach
    </table>
</div>