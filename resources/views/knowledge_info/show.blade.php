@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('knowledge_info') }}">Knowledge Info</a></li>
    <li class="breadcrumb-item">Detail</li>
</ul>
@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="header d-flex justify-content-between align-items-center">
            <h2><i class="fa fa-file-text-o"></i> Detail Knowledge Info</h2>
            <div>
                <a href="{{ url('knowledge_info/' . $model->id . '/edit') }}" class="btn btn-primary btn-sm"><i class="icon-pencil"></i> Ubah</a>
                <a href="{{ url('knowledge_info') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
        </div>
        <div class="body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 180px;">Judul</th>
                    <td>{{ $model->title }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $model->category ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Tag</th>
                    <td>{{ $model->tag ?: '-' }}</td>
                </tr>
                <tr>
                    <th>Konten</th>
                    <td>
                        @if($model->content)
                            <div class="knowledge-content border rounded p-3 bg-light">
                                {!! $model->content !!}
                            </div>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
                @if($model->createdBy)
                <tr>
                    <th>Dibuat oleh</th>
                    <td>{{ $model->createdBy->name ?? '-' }} <span class="text-muted">({{ $model->created_at ? $model->created_at->format('d/m/Y H:i') : '-' }})</span></td>
                </tr>
                @endif
                @if($model->updatedBy)
                <tr>
                    <th>Diubah oleh</th>
                    <td>{{ $model->updatedBy->name ?? '-' }} <span class="text-muted">({{ $model->updated_at ? $model->updated_at->format('d/m/Y H:i') : '-' }})</span></td>
                </tr>
                @endif
            </table>
            <div class="m-t-15">
                <a href="{{ url('knowledge_info/' . $model->id . '/edit') }}" class="btn btn-primary"><i class="icon-pencil"></i> Ubah</a>
                <a href="{{ url('knowledge_info') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection
