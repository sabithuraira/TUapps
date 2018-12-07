<div id="load" class="table-responsive">
    <table class="table m-b-0">
        <thead>
            <tr>
            <th>Peruntukan</th>
            <th>Kode</th>
            <th>Butir Kegiatan</th>
            <th>Satuan Hasil</th>
            <th>Angka Kredit</th>
            <th>Batas Penilaian</th>
            <th>Pelaksana</th>
            <th>Bukti Fisik</th>
            <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datas as $data)
            <tr>
                <td>{{$data['Jenis']['uraian']}}</td>
                <td>{{$data['kode']}}</td>
                <td>{{$data['butir_kegiatan']}}</td>
                <td>{{$data['satuan_hasil']}}</td>
                <td>{{$data['angka_kredit']}}</td>
                <td>{{$data['batas_penilaian']}}</td>
                <td>{{$data['pelaksana']}}</td>
                <td>{{$data['bukti_fisik']}}</td>
                
                <td><a href="{{action('AngkaKreditController@edit', $data['id'])}}" class="btn btn-warning">Edit</a></td>
                <td>
                <form action="{{action('AngkaKreditController@destroy', $data['id'])}}" method="post">
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