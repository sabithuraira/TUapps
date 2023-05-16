<style>
    .c3-axis-x text {
        font-size: 10px;
    }
</style>

<div class="card">
    <div class="body profilepage_2 blog-page">
        <b>MONITORING ST 2023 :</b>
        <u><a href="{{ url('dashboard/index') }}">SUMATERA SELATAN</a></u>
        @if ($request->kab_filter)
            -<u>
                <a href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter) }}">
                    {{ $label_kab }}
                </a>
            </u>
        @endif
        @if ($request->kec_filter)
            -<u><a
                    href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter) }}">
                    {{ $label_kec }}
                </a>
            </u>
        @endif
        @if ($request->desa_filter)
            -<u><a
                    href="{{ url('dashboard/index?kab_filter=' . $request->kab_filter . '&kec_filter=' . $request->kec_filter . '&desa_filter=' . $request->desa_filter) }}">
                    {{ $label_desa }}
                </a>
            </u>
        @endif
        @if ($request->sls_filter)
            -<u><a
                    href="{{ url(
                        'dashboard/index?kab_filter=' .
                            $request->kab_filter .
                            '&kec_filter=' .
                            $request->kec_filter .
                            '&desa_filter=' .
                            $request->desa_filter .
                            '&sls_filter=' .
                            $request->sls_filter,
                    ) }}">
                    {{ $label_sls }}
                </a>
            </u>
        @endif
        <br>
        <div class=" d-flex flex-row-reverse">
            <a class="btn btn-info" href="{{ url('dashboard/petugas') }}">Halaman Petugas</a>
        </div>
    </div>
    <br>
    <div class="m-1">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#st_wilayah">Wilayah</a>
            </li>
            {{-- <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_kk">KK</a></li> --}}
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#st_dokumen">Dokumen</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane show active" id="st_wilayah">
                <h6>Menunjukkan progress sls yang selesai dan filter wilayah</h6>
                @include('dashboard.st2023.wilayah')
            </div>
            {{-- <div class="tab-pane  " id="st_kk">
                <h6>Menunjukkan perbandingan data art yang berusaha di sektor pertanian antara st2023 lapangan
                    dengan regsosek2022</h6>
                @include('dashboard.st2023.kk')
            </div> --}}
            <div class="tab-pane  " id="st_dokumen">
                <h6>Menunjukkan progress/alur dokumen telah sampai dimana </h6>
                @include('dashboard.st2023.dokumen')
            </div>
        </div>

    </div>
</div>
