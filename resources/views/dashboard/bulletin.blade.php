@foreach ($bulletin as $val)
    <div class="col-lg-12 col-md-12">
        <div class="card member-card">
            {{-- <div class="header bg-success">
            <h5 class="m-t-10 text-light">{{ $val->judul }}</h5>
        </div> --}}
            {!! $bulletin_header->bulletinCardHeader[$val->judul] !!}
            <div class="member-img">
                <a href="javascript:void(0);">
                    <img src="{{ $val->user->fotoUrl }}" class="rounded-circle" alt="profile-image">
                </a>
            </div>
            <div class="body">
                <div class="col-12">
                    <p class="text-muted"><b>{{ $val->user->name }}</b><br> {{ $val->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
