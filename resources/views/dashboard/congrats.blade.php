@foreach($birthday as $val)
<div class="col-lg-4 col-md-12">
    <div class="card member-card">
        <div class="header bg-success">
            <h5 class="m-t-10 text-light">Selamat Ulang Tahun</h5>
        </div>
        <div class="member-img">
            <a href="javascript:void(0);"><img src="{{ $val->fotoUrl }}" class="rounded-circle" alt="profile-image"></a>
        </div>
        <div class="body">
            <div class="col-12">
                <p class="text-muted"><b>{{ $val->name }}</b><br> {{ $val->nip_baru }}</p>
            </div>
        </div>
    </div>
</div>
@endforeach