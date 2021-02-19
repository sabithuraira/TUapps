<div class="card member-card">
    <div class="header bg-info">
        <h4 class="m-t-10 text-light">{{ $random_user->name }}</h4>
    </div>
    <div class="member-img">
        <a href="javascript:void(0);"><img src="{{ $random_user->fotoUrl }}" class="rounded-circle" alt="profile-image"></a>
    </div>
    <div class="body">
        <div class="row">
            <div class="col-5 text-left">NIP</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">{{ $random_user->nip_baru }}</div>
        </div>
        
        <div class="row">
            <div class="col-5 text-left">NIP Lama</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">{{ $random_user->email }}</div>
        </div>
        
        <div class="row">
            <div class="col-5 text-left">Unit Kerja</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">BPS {{ $unit_kerja->nama }}</div>
        </div>

        <div class="row">
            <div class="col-5 text-left">Organisasi Unit Kerja</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">{{ $random_user->nmorg }}</div>
        </div>
        
        <div class="row">
            <div class="col-5 text-left">Jabatan / Gol</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">{{ $random_user->nmjab }} / {{ $random_user->nmgol }}</div>
        </div>
        
        <div class="row">
            <div class="col-5 text-left">Wilayah</div>
            <div class="col-1">:</div>
            <div class="col-6 text-left">{{ $random_user->nmwil }}</div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5>Tahun {{ date('Y') }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <h5>{{ $random_user->getJumlahDl() }}</h5>
                <small>Hari DL</small>
            </div>
            <div class="col-4">
                <h5>---</h5>
                <small>Hari Cuti</small>
            </div>
            <div class="col-4">
                <h5>---</h5>
                <small>Hari Lembur</small>
            </div>
        </div>
    </div>
</div>