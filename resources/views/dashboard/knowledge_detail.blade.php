@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item"><a href="{{ route('faq') }}">FAQ</a></li>
    <li class="breadcrumb-item">Detail</li>
</ul>
@endsection

@section('content')
<div class="container">
    {{-- Card 1: Title, meta, tags --}}
    <div class="card border-0 shadow-sm mb-3">
        <article class="knowledge-article p-4">
            <header class="m-b-0">
                <h1 class="article-title font-weight-bold mb-3" style="font-size: 1.75rem; line-height: 1.4;">
                    {{ $model->title }}
                </h1>
            </header>
        </article>
    </div>

    {{-- Card 2: Konten --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($model->content)
                <div class="article-content knowledge-content" style="line-height: 1.8;">
                    {!! $model->content !!}
                </div>
            @else
                <p class="text-muted m-0">Tidak ada konten.</p>
            @endif
        </div>
        <hr/>

        <div class="article-meta d-flex flex-wrap align-items-center mb-2">
            @if($model->category)
            <span class="badge badge-primary mr-2 mb-1">{{ $model->category }}</span>
            @endif
            @if($model->created_at)
            <span class="text-muted small mr-3">{{ $model->created_at->format('d F Y') }}</span>
            @endif
        </div>
        @if($model->tag)
        <div class="article-tags mt-2">
            @foreach(array_filter(array_map('trim', explode(',', $model->tag))) as $tag)
            <span class="badge badge-secondary mr-1 mb-1">{{ $tag }}</span>
            @endforeach
        </div>
        @endif
    </div>


        <a href="{{ route('faq') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Kembali ke FAQ</a>
    
</div>

<style>
.article-content img { max-width: 100%; height: auto; }
.article-content table { border-collapse: collapse; width: 100%; }
.article-content table td, .article-content table th { border: 1px solid #dee2e6; padding: 8px 12px; }
.article-content pre, .article-content code { background: #f8f9fa; padding: 2px 6px; border-radius: 4px; }
</style>
@endsection
