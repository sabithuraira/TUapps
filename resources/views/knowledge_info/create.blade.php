@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('knowledge_info') }}">Knowledge Info</a></li>
    <li class="breadcrumb-item">Tambah</li>
</ul>
@endsection

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-b-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="header">
            <h2><i class="fa fa-plus-circle"></i> Tambah Knowledge Info</h2>
        </div>
        <div class="body">
            <form action="{{ url('knowledge_info') }}" method="POST" id="form-knowledge">
                @csrf
                <div class="form-group">
                    <label>Judul: <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Masukkan judul" required>
                </div>

                <div class="form-group">
                    <label>Konten:</label>
                    <textarea id="content" name="content" class="form-control summernote" rows="10">{{ old('content') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Kategori:</label>
                    <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="Kategori (opsional)" maxlength="255">
                </div>

                <div class="form-group">
                    <label>Tag:</label>
                    <textarea name="tag" class="form-control" rows="2" placeholder="Tag, pisahkan dengan koma (opsional)">{{ old('tag') }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> SIMPAN</button>
                    <a href="{{ url('knowledge_info') }}" class="btn btn-default">BATAL</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{!! asset('lucid/assets/vendor/summernote/dist/summernote.css') !!}">
@endsection

@section('scripts')
    <script src="{!! asset('lucid/assets/vendor/summernote/dist/summernote.js') !!}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 300,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endsection
