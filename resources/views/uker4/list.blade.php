<div id="load" class="table-responsive">
    <table class="table m-b-0">
        @if (count($datas)==0)
            <thead>
                <tr><th>Tidak ditemukan data</th></tr>
            </thead>
        @else
            <thead>
                <tr>
                <th>Unit Kerja Kabupaten?</th>
                <th>Nama</th>
                <th>Tampilkan pada persediaan?</th>
                <th class="text-center" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{ ($data['is_kabupaten']==1) ? "Ya" : "Tidak" }}</td>
                    <td>{{$data['nama']}}</td>
                    <td>{{ ($data['is_persediaan']==1) ? "Ya" : "Tidak" }}</td>
                    
                    <td class="text-center"><a href="{{action('Uker4Controller@edit', $data['id'])}}"><i class="icon-pencil text-info"></i></a></td>
                    <td class="text-center">
                    <form action="{{action('Uker4Controller@destroy', $data['id'])}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button type="submit"><i class="icon-trash text-danger"></i></button>
                    </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
        @endif
    </table>
    {{ $datas->links() }} 
</div>