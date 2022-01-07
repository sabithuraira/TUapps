@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{url('log_book')}}">Log Book</a></li>                            
    <li class="breadcrumb-item">{{ $model->tanggal }}</li>
</ul>
@endsection

@section('content')
<div class="row clearfix">
    <div class="col-lg-8 col-md-12 left-box">
        <div class="card">

            <div class="header">
                <div class="float-left">
                    <form action="{{action('LogBookController@destroy', $id)}}" method="post">
                        @csrf
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Delete</button>
                    </form>
                </div>

                <div class="text-right">
                    <a href="{{action('LogBookController@print', $id)}}" class="btn btn-info"><i class="fa fa-print"></i> Print</a>
                    <a href="{{action('LogBookController@edit', $id)}}" class="btn btn-warning"><i class="icon-pencil"></i> Edit</a>
                </div>
            </div>

            <div class="body">
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12">
                        <p class="mb-0">Status Approval :<b> {{ $model->listApprove[$model->is_approve] }}</b></p>
                        <p class="mb-0">Catatan :<b> {!! $model->catatan_approve !!}</b></p>
        
                    </div>
                    <div class="col-lg-4 col-md-12">
                    </div>
                </div>

                <br/>
                <br/>
                
                <div class="row clearfix">                                
                    <div class="col-lg-12 col-md-12">
                        {!! $model->isi !!}
                    </div>
                </div>
                <br/>         
                
            </div>
        </div>
    </div>

</div>


<div class="modal fade" id="add_progres" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="defaultModalLabel">Approval Data</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="form-line">

                        <select class="form-control"  id="form_status" autofocus>
                            <option value="">- Pilih Status -</option>
                            @foreach ($model->listApprove as $key=>$value)
                                <option value="{{ $key }}" 
                                    @if ($key == 1)
                                        selected="selected"
                                    @endif >{{ $value }}
                                </option>
                            @endforeach
                        </select>

                    </div>
                </div>

                <div class="form-group">
                    <div class="form-line">
                        <input type="text" id="form_keterangan" class="form-control" placeholder="Keterangan">
                    </div>
                </div>   
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add-btn">Add</button>
                <button type="button" class="btn btn-simple" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
        <meta name="_token" content="{{csrf_token()}}" />
@endsection

@section('scripts')

@endsection