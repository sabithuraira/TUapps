<div id="left-sidebar" class="sidebar">
    <div class="sidebar-scroll">
        <div class="user-account">
            <img src="{!! Auth::user()->fotoUrl !!}" class="rounded-circle user-photo" alt="User Profile Picture">
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name"
                    data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account">
                    <!-- <li><a href="#"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="#"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="#"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li> -->
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </div>
            <hr>
            <ul class="row list-unstyled">
                <li class="col-12">
                    <h6>#KaloBukanKitaSiapaLagi</h6>
                </li>
            </ul>
        </div>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu">Menu</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panduan"><i class="icon-book-open"></i>
                    Panduan</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content p-l-0 p-r-0">
            <div class="tab-pane active" id="menu">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul id="main-menu" class="metismenu">
                        <li class="{{ (request()->is('dashboard*')) ? 'active' : '' }}">
                            <a href="#Dashboard" class="has-arrow"><i class="icon-speedometer"></i>
                                <span>Dashboard</span></a>
                            <ul>
                                <li class="{{ request()->is('dashboard/index*') ? 'active' : '' }}"><a
                                        href="{{ url('dashboard/index') }}">Overview</a></li>
                                <li class="{{ request()->is('dashboard/rekap_dl*') ? 'active' : '' }}"><a
                                        href="{{ url('dashboard/rekap_dl') }}">Kalender DL</a></li>
                            </ul>
                        </li>


                        <li
                            class="{{ (request()->is('log_book*') || request()->is('ckp*') || request()->is('iki*')) ? 'active' : '' }}">
                            <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Aktivitas</span></a>
                            <ul>
                                <li class="{{ request()->is('ckp*') ? 'active' : '' }}"><a href="{{url('ckp')}}">CKP</a>
                                </li>
                                <li class="{{ request()->is('log_book') ? 'active' : '' }}"><a
                                        href="{{ url('log_book') }}">Log Book</a></li>
                                <li class="{{ request()->is('log_book/laporan_wfh*') ? 'active' : '' }}"><a
                                        href="{{ url('log_book/laporan_wfh') }}">Laporan WFH</a></li>

                                @if(strlen(auth()->user()->kdesl)>0 || auth()->user()->hasRole('superadmin') ||
                                auth()->user()->hasRole('binagram'))
                                <li class="{{ request()->is('log_book/rekap_pegawai*') ? 'active' : '' }}"><a
                                        href="{{ url('log_book/rekap_pegawai') }}">Rekap Kerja Seluruh Pegawai</a></li>
                                @endif

                                @if(auth()->user()->hasRole('superadmin') || auth()->user()->hasRole('kepegawaian'))
                                <li class="{{ request()->is('ckp/rekap_ckp*') ? 'active' : '' }}"><a
                                        href="{{ url('ckp/rekap_ckp') }}">Rinciap CKP Pegawai</a></li>
                                @endif
                                <li class="{{ request()->is('iki*') ? 'active' : '' }}"><a
                                        href="{{ url('iki') }}">Kelola IKI</a></li>
                            </ul>
                        </li>

                        <li class="{{ (request()->is('pegawai_anda*')) ? 'active' : '' }}">
                            <a href="{{ url('pegawai_anda') }}"> <i class="icon-users"></i><span>Pegawai Anda</span></a>
                        </li>

                        @hasanyrole('superadmin|tatausaha|subbag-keuangan')
                        <li class="{{ (request()->is('surat_tugas*') || request()->is('cuti*')) ? 'active' : '' }}">
                            <a href="#Jadwal" class="has-arrow"><i class="icon-doc"></i> <span>Surat Tugas & Cuti</span></a>
                            <ul>
                                <li class="{{ request()->is('surat_tugas*') ? 'active' : '' }}"><a
                                        href="{{url('surat_tugas')}}">Daftar Surat Tugas</a></li>
                                <li class="{{ request()->is('cuti*') ? 'active' : '' }}"><a
                                        href="{{url('cuti')}}">Daftar Cuti</a></li>
                                <li class="{{ request()->is('surat_tugas*') ? 'active' : '' }}"><a
                                        href="{{url('surat_tugas')}}">Calender</a></li>
                                <li class="{{ request()->is('surat_tugas/edit_unit_kerja*') ? 'active' : '' }}"><a
                                        href="{{url('surat_tugas/edit_unit_kerja')}}">Informasi Unit Kerja</a></li>
                                <li class="{{ request()->is('mata_anggaran/index*') ? 'active' : '' }}"><a
                                        href="{{url('mata_anggaran/index')}}">MAK</a></li>
                            </ul>
                        </li>
                        @endhasanyrole

                        @hasanyrole('superadmin|subbag-umum')
                        <li
                            class="{{ (request()->is('master_barang*') || request()->is('opname_persediaan*')) ? 'active' : '' }}">
                            <a href="#Dashboard" class="has-arrow"><i class="icon-basket-loaded"></i> <span>Barang
                                    Persediaan</span></a>
                            <ul>
                                <li class="{{ request()->is('master_barang*') ? 'active' : '' }}"><a
                                        href="{{url('master_barang')}}">Master Barang</a></li>
                                <li
                                    class="{{ (request()->is('opname_persediaan') || request()->is('opname_persediaan/create')) ? 'active' : '' }}">
                                    <a href="{{url('opname_persediaan')}}">Opname Persediaan</a></li>
                                <li class="{{ request()->is('opname_persediaan/kartu_kendali') ? 'active' : '' }}"><a
                                        href="{{url('opname_persediaan/kartu_kendali')}}">Kartu Kendali</a></li>
                            </ul>
                        </li>
                        @endhasanyrole

                        @hasanyrole('superadmin|subbag-umum|subbag-keuangan')
                        <li class="{{ (request()->is('pemegang_bmn*')) ? 'active' : '' }}">
                            <a href="{{ url('pemegang_bmn') }}"> <i class="icon-basket-loaded"></i><span>Pemegang
                                    BMN</span></a>
                        </li>
                        @endhasanyrole

                        <li class="{{ (request()->is('meeting*')) ? 'active' : '' }}">
                            <a href="#Dashboard" class="has-arrow"><i class="icon-basket-loaded"></i>
                                <span>Rapat/Pertemuan</span></a>
                            <ul>
                                <li class="{{ request()->is('meeting') ? 'active' : '' }}"><a
                                        href="{{url('meeting')}}">Daftar</a></li>
                                <li class="{{ request()->is('meeting/kalender') ? 'active' : '' }}"><a
                                        href="{{url('meeting/kalender')}}">Kalender</a></li>
                            </ul>
                        </li>

                        <li class="{{ (request()->is('surat_km*')) ? 'active' : '' }}">
                            <a href="{{ url('surat_km') }}"> <i class="icon-users"></i><span>Surat Menyurat</span></a>
                        </li>

                        @role('superadmin')
                        <li
                            class="{{ (request()->is('uker*') || request()->is('uker4*') || request()->is('angka_kredit*') || request()->is('type_kredit*') || request()->is('rincian_kredit*') || request()->is('user*')) ? 'active' : '' }}">
                            <a href="#Dashboard" class="has-arrow"><i class="icon-layers"></i> <span>Master
                                    Data</span></a>
                            <ul>
                                <li class="{{ request()->is('uker*') ? 'active' : '' }}"><a href="{{url('uker')}}">Unit
                                        Kerja</a></li>
                                <li class="{{ request()->is('uker4*') ? 'active' : '' }}"><a
                                        href="{{url('uker4')}}">Unit
                                        Kerja 4</a></li>
                                <li class="{{ request()->is('angka_kredit*') ? 'active' : '' }}"><a
                                        href="{{url('angka_kredit')}}">Angka Kredit</a></li>
                                <li class="{{ request()->is('type_kredit*') ? 'active' : '' }}"><a
                                        href="{{url('type_kredit')}}">Peruntukan Angka Kredit</a></li>
                                <li class="{{ request()->is('rincian_kredit*') ? 'active' : '' }}"><a
                                        href="{{url('rincian_kredit')}}">Rincian Angka Kredit</a></li>
                                <li class="{{ request()->is('user*') ? 'active' : '' }}"><a
                                        href="{{url('user')}}">User</a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="{{ (request()->is('role*') || request()->is('permission*') || request()->is('user_role*')) ? 'active' : '' }}">
                            <a href="#User" class="has-arrow"><i class="icon-user-following"></i> <span>Manajemen
                                    User</span></a>
                            <ul>
                                <li class="{{ request()->is('role*') ? 'active' : '' }}"><a
                                        href="{{url('role')}}">Roles</a>
                                </li>
                                <li class="{{ request()->is('permission*') ? 'active' : '' }}"><a
                                        href="{{url('permission')}}">Permission</a></li>
                                <li class="{{ request()->is('user_role*') ? 'active' : '' }}"><a
                                        href="{{url('user_role')}}">User Role</a></li>
                            </ul>
                        </li>
                        @endrole

                    </ul>
                </nav>
            </div>

            <div class="tab-pane p-l-15 p-r-15" id="panduan">
                <nav id="left-sidebar-nav" class="sidebar-nav">
                    <ul class="metismenu">
                        <li><a href="https://laci.bps.go.id/s/r7q7pFlopuAY80t"> <i class="icon-doc"></i><span>Panduan
                                    Modul CKP, Penilaian & WFH</span></a></li>
                        <li><a href="https://laci.bps.go.id/s/7q6CAaFDjTDk4nB"> <i class="icon-doc"></i><span>Panduan
                                    Modul Barang Persediaan</span></a></li>
                        <li><a href="https://laci.bps.go.id/s/njTCSRMqiFm4IHV"> <i class="icon-doc"></i><span>Panduan
                                    Modul Surat Menyurat</span></a></li>
                        <li><a href="https://laci.bps.go.id/s/WimneDzApQTyq0V"> <i class="icon-doc"></i><span>Panduan
                                    Modul Surat Tugas</span></a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
