@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="icon-home"></i></a></li>
    <li class="breadcrumb-item">FAQ</li>
</ul>
@endsection

@section('content')
<div class="container">
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="header">
            <h2><i class="fa fa-question-circle"></i> FAQ</h2>
        </div>
        <div class="body">
            <form method="GET" action="{{ url('faq') }}" class="row m-b-20">
                <div class="col-md-6">
                    <label class="sr-only">Pencarian</label>
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" value="{{ $keyword }}" placeholder="Cari judul atau kata kunci...">
                        <input type="hidden" name="per_page" value="{{ $perPage }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-hover m-b-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Judul</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr>
                            <td class="text-center">{{ $items->firstItem() + $index }}</td>
                            <td>
                                <a href="{{ url('faq/knowledge/' . $item->id) }}" class="text-primary font-weight-medium">
                                    {{ $item->title }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
            <div class="m-t-15">
                {{ $items->appends(request()->except('page'))->links() }}
            </div>
            @endif
            @if($items->total() > 0)
            <div class="text-muted m-t-10">
                Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
