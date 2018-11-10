<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
  </head>
  <body>
    <div class="container">
    <br />
    @if (\Session::has('success'))
      <div class="alert alert-success">
        <p>{{ \Session::get('success') }}</p>
      </div><br />
     @endif

    <a href="{{action('UkerController@create')}}" class="btn btn-info">Create</a>
    <br/>
    <table class="table table-striped">
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      
      @foreach($datas as $data)
      @php
        @endphp
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
  </div>
  </body>
</html>