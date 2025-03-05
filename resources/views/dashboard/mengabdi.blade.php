
@foreach($mengabdi as $val)
<div class="col-lg-4 col-md-12">

    <div class="card">
        <div class="body w_user">
            <img class="rounded-circle" src="{{ $val->fotoUrl }}" alt="">
            <div class="wid-u-info">
                <h5>{{ $val->name }}</h5>
                <p class="text-muted m-b-0">{{ $val->nip_baru }}</p>                            
            </div>
            <hr>
            <div class="row">
                <h7 class="m-t-10 text-light">
                    @php 
                        $total_tahun = date('Y') - (int)substr($val->nip_baru,8,4);
                    @endphp
                    Genap <b>{{ $total_tahun }} Tahun</b> Mengabdi,<br/>
                    Terima kasih atas pengabdian dan dedikasi Anda
                </h7>
            </div>
        </div>
    </div>
</div>
@endforeach