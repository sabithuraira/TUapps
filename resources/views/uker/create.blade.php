@extends('main')

@section('content')
    <div class="container">
      <h2>Tambah Unit Kerja</h2><br/>
      <form method="post" action="{{url('uker')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4">
            <label for="Kode">Kode:</label>
            <input type="text" class="form-control" name="kode">
          </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
              <label for="Nam">Nama:</label>
              <input type="text" class="form-control" name="nama">
            </div>
        </div>
         
        <div class="row">
          <div class="col-md-4"></div>
          <div class="form-group col-md-4" style="margin-top:60px">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
        </div>
      </form>
    </div>
    <script type="text/javascript">  
        $('#datepicker').datepicker({ 
            autoclose: true,   
            format: 'dd-mm-yyyy'  
         });  
    </script>
@endsection
