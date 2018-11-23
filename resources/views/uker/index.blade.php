@extends('main')

@section('content')
    <div class="container">
      <br />
      @if (\Session::has('success'))
        <div class="alert alert-success">
          <p>{{ \Session::get('success') }}</p>
        </div><br />
      @endif

      <div class="card">
        <div class="body">
          <a href="{{action('UkerController@create')}}" class="btn btn-info">Tambah</a>
          <br/><br/>

          <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th colspan="2">Action</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($datas as $data)
                    <tr>
                      <td>{{$data['kode']}}</td>
                      <td>{{$data['nama']}}</td>
                      
                      <td><a href="{{action('UkerController@edit', $data['id'])}}" class="btn btn-warning">Edit</a></td>
                      <td>
                        <form action="{{action('UkerController@destroy', $data['id'])}}" method="post">
                          @csrf
                          <input name="_method" type="hidden" value="DELETE">
                          <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
            @php echo $datas->links(); @endphp
        </div>
      </div>
    </div>
  </div>
@endsection