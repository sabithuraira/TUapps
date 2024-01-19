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
        </div>

        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">

                <li class="{{ request()->is('dashboard*') ? 'active' : '' }}">
                    <a href="#Dashboard" class="has-arrow"><i class="icon-speedometer"></i>
                        <span>Dashboard</span></a>
                    <ul>
                        <li class="{{ request()->is('dashboard/index*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/index') }}">PL-KUMKM</a></li>
                        <li class="{{ request()->is('dashboard/pes_st2023*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/pes_st2023') }}">PES ST2023</a></li>
                        <li class="{{ request()->is('dashboard/st2023*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/st2023') }}">ST 2023</a></li>
                        {{-- <li class="{{ request()->is('dashboard/waktu*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/waktu') }}">Dashboard Waktu</a></li>
                        <li class="{{ request()->is('dashboard/lokasi*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/lokasi') }}">Dashboard Lokasi</a></li>
                        <li class="{{ request()->is('dashboard/target*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/target') }}">Dashboard Target</a></li>
                        <li class="{{ request()->is('dashboard/koseka*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/koseka') }}">Dashboard Koseka</a></li>
                        <li class="{{ request()->is('dashboard/pendampingan*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/pendampingan') }}">Dashboard pendampingan</a></li>
                        <li class="{{ request()->is('dashboard/alokasi*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/alokasi') }}">Alokasi ST2023</a></li>
                        <li class="{{ request()->is('dashboard/daftar_ruta*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/daftar_ruta') }}">Pindah Ruta ST2023</a></li>
                        <li class="{{ request()->is('dashboard/petugas*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/petugas') }}">Petugas ST2023</a></li> --}}
                    </ul>
                </li>

                {{-- @hasanyrole('superadmin|pengelola_regsosek')
                    <li class="{{ request()->is('regsosek*') ? 'active' : '' }}">
                        <a href="{{ url('regsosek') }}"> <i class="icon-doc"></i><span>SLS Regsosek</span></a>
                    </li>
                @endhasanyrole --}}

                <li
                    class="{{ request()->is('rekap_dl*') || request()->is('surat_tugas*') || request()->is('cuti*') ? 'active' : '' }}">
                    <a href="#Dashboard" class="has-arrow"><i class="icon-calendar"></i>
                        <span>Operasionalisasi SDM</span></a>
                    <ul>
                        <li class="{{ request()->is('dashboard/rekap_dl*') ? 'active' : '' }}"><a
                                href="{{ url('dashboard/rekap_dl') }}">Kalender DL</a></li>

                        <li class="{{ request()->is('cuti*') ? 'active' : '' }}"><a
                                href="{{ url('cuti') }}">Cuti</a></li>

                        @hasanyrole('superadmin|tatausaha|subbag-keuangan')
                            <li class="{{ request()->is('surat_tugas*') ? 'active' : '' }}"><a
                                    href="{{ url('surat_tugas') }}">Daftar Surat Tugas</a></li>
                            {{-- <li class="{{ request()->is('surat_tugas/calendar*') ? 'active' : '' }}"><a
                                    href="{{ url('surat_tugas/calendar') }}">Calender</a></li> --}}
                            <li class="{{ request()->is('surat_tugas/edit_unit_kerja*') ? 'active' : '' }}"><a
                                    href="{{ url('surat_tugas/edit_unit_kerja') }}">Informasi Unit Kerja</a></li>
                            <li class="{{ request()->is('mata_anggaran/index*') ? 'active' : '' }}"><a
                                    href="{{ url('mata_anggaran/index') }}">MAK</a></li>
                        @endhasanyrole
                    </ul>
                </li>

                <li
                    class="{{ request()->is('log_book*') || request()->is('ckp*') || request()->is('rencana_kerja*') || request()->is('skp*') || request()->is('iki/*') ? 'active' : '' }}">
                    <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Pengukuran Kinerja</span></a>
                    <ul>
                        <li class="{{ request()->is('ckp*') ? 'active' : '' }}"><a href="{{ url('ckp') }}">CKP</a>


                        <li class="{{ request()->is('pegawai_anda*') ? 'active' : '' }}">
                            <a href="{{ url('pegawai_anda') }}"> <span>Pegawai Anda</span></a>
                        </li>

                        <li class="{{ request()->is('pegawai_anda/penilaian_anda*') ? 'active' : '' }}">
                            <a href="{{ url('pegawai_anda/penilaian_anda') }}"> <span>Penilaian Anda</span></a>
                        </li>

                        <!-- <li class="{{ request()->is('skp*') ? 'active' : '' }}"><a href="{{ url('skp') }}">SKP <span class="badge badge-warning float-right">Uji Coba</span></a></li> -->
                        <li class="{{ request()->is('log_book') ? 'active' : '' }}"><a
                                href="{{ url('log_book') }}">Log Book</a></li>
                        <li class="{{ request()->is('rencana_kerja') ? 'active' : '' }}"><a
                                href="{{ url('rencana_kerja') }}">Rencana Kerja</a></li>
                        <li class="{{ request()->is('log_book/laporan_wfh*') ? 'active' : '' }}"><a
                                href="{{ url('log_book/laporan_wfh') }}">Laporan WFH</a></li>

                        @if (strlen(auth()->user()->kdesl) > 0 ||
                                auth()->user()->hasRole('superadmin') ||
                                auth()->user()->hasRole('binagram'))
                            <li class="{{ request()->is('log_book/rekap_pegawai*') ? 'active' : '' }}"><a
                                    href="{{ url('log_book/rekap_pegawai') }}">Rekap Kerja Seluruh Pegawai</a></li>
                        @endif

                        @if (auth()->user()->hasRole('superadmin') ||
                                auth()->user()->hasRole('kepegawaian'))
                            <li class="{{ request()->is('ckp/rekap_ckp*') ? 'active' : '' }}"><a
                                    href="{{ url('ckp/rekap_ckp') }}">Rinciap CKP Pegawai</a></li>
                        @endif
                        <li class="{{ request()->is('iki/*') ? 'active' : '' }}"><a href="{{ url('iki') }}">Kelola
                                IKI</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('tim*') || request()->is('iki_pegawai*') ? 'active' : '' }}">
                    <a href="#Jadwal" class="has-arrow"><i class="icon-users"></i> <span>Manajemen Tim dan
                            Pekerjaan</span></a>
                    <ul>
                        <li class="{{ request()->is('tim') ? 'active' : '' }}"><a href="{{ url('tim') }}">Tim</a>
                        </li>
                        <li class="{{ request()->is('iki_pegawai*') ? 'active' : '' }}"><a
                                href="{{ url('iki_pegawai') }}">Pengelolaan IKI Pegawai</a></li>
                        <li class="{{ request()->is('iki_report*') ? 'active' : '' }}"><a
                                href="{{ url('iki_report') }}">Report IKI</a></li>
                        <li class="{{ request()->is('master_pekerjaan*') ? 'active' : '' }}"><a
                                href="{{ url('master_pekerjaan') }}">Master Pekerjaan</a></li>
                    </ul>
                </li>

                @if (Auth::user()->kdkab == '00')
                    <li class="{{ request()->is('pok*') ? 'active' : '' }}">
                        <a href="#Jadwal" class="has-arrow"><i class="icon-diamond"></i> <span>Anggaran</span></a>
                        <ul>
                            <li class="{{ request()->is('pok') ? 'active' : '' }}"><a
                                    href="{{ url('pok') }}">POK</a></li>

                            <li class="{{ request()->is('pok/revisi') ? 'active' : '' }}"><a
                                    href="{{ url('pok/revisi') }}">Revisi</a></li>

                            @hasanyrole('superadmin|kuasa_anggaran')
                                <li class="{{ request()->is('pok_versi*') ? 'active' : '' }}"><a
                                        href="{{ url('pok_versi') }}">Versi POK</a></li>
                            @endhasanyrole

                            @hasanyrole('superadmin')
                                <li class="{{ request()->is('pok/import_pok*') ? 'active' : '' }}"><a
                                        href="{{ url('pok/import_pok') }}">Import POK</a></li>
                            @endhasanyrole
                        </ul>
                    </li>
                @endif

                <li class="{{ request()->is('penugasan*') ? 'active' : '' }}">
                    <a href="#Jadwal" class="has-arrow"><i class="fa fa-tasks"></i> <span>Matrik Tugas</span> <span
                            class="badge badge-warning float-right">Uji Coba</span></a>
                    <ul>
                        <li class="{{ request()->is('penugasan/anda*') ? 'active' : '' }}"><a
                                href="{{ url('penugasan/anda') }}">Penugasan Anda</a></li>

                        @hasanyrole('superadmin|admin_uker|pemberi_tugas')
                            <li
                                class="{{ request()->is('penugasan*') && !request()->is('penugasan/user_role') && !request()->is('penugasan/anda') && !request()->is('penugasan/rekap') ? 'active' : '' }}">
                                <a href="{{ url('penugasan') }}">Kelola Matrik Tugas</a>
                            </li>

                            <li class="{{ request()->is('penugasan/rekap') ? 'active' : '' }}"><a
                                    href="{{ url('penugasan/rekap') }}">Rekap Matrik Tugas</a></li>
                        @endhasanyrole

                        @hasanyrole('superadmin|admin_uker')
                            <li class="{{ request()->is('penugasan/user_role') ? 'active' : '' }}"><a
                                    href="{{ url('penugasan/user_role') }}">Kelola User Penugas</a></li>
                        @endhasanyrole

                    </ul>
                </li>

                @hasanyrole('superadmin|skf|ppk|pbj')
                    <li class="{{ request()->is('pengadaan*') ? 'active' : '' }}">
                        <a href="#Jadwal" class="has-arrow"><i class="icon-social-dropbox"></i> <span>Pengajuan
                                Pengadaan</span></a>
                        <ul>
                            <li class="{{ request()->is('pengadaan') ? 'active' : '' }}"><a
                                    href="{{ url('pengadaan') }}">Pengajuan SKF</a></li>
                        </ul>
                    </li>
                @endhasanyrole

                @if (Auth::user()->kdkab == '00')
                    @hasanyrole('superadmin|subbag-umum')
                        <li
                            class="{{ request()->is('master_barang*') ||
                            request()->is('opname_persediaan*') ||
                            request()->is('pemegang_bmn*') ||
                            request()->is('vicon*')
                                ? 'active'
                                : '' }}">
                            <a href="#Dashboard" class="has-arrow"><i class="icon-basket-loaded"></i> <span>Fasilitas
                                    Perkantoran</span></a>
                            <ul>
                                <li class="{{ request()->is('master_barang*') ? 'active' : '' }}"><a
                                        href="{{ url('master_barang') }}">Master Barang</a></li>
                                <li
                                    class="{{ request()->is('opname_persediaan') || request()->is('opname_persediaan/create') ? 'active' : '' }}">
                                    <a href="{{ url('opname_persediaan') }}">Opname Persediaan</a>
                                </li>
                                <li class="{{ request()->is('opname_persediaan/kartu_kendali') ? 'active' : '' }}"><a
                                        href="{{ url('opname_persediaan/kartu_kendali') }}">Kartu Kendali</a></li>
                                <li class="{{ request()->is('opname_persediaan/kartu_kendali_q') ? 'active' : '' }}"><a
                                        href="{{ url('opname_persediaan/kartu_kendali_q') }}">Kartu Kendali Kuantitas</a></li>
                                @hasanyrole('superadmin|subbag-umum|subbag-keuangan')
                                    <li class="{{ request()->is('pemegang_bmn*') ? 'active' : '' }}">
                                        <a href="{{ url('pemegang_bmn') }}"> <span>Pemegang BMN</span></a>
                                    </li>
                                @endhasanyrole

                                <li class="{{ request()->is('vicon*') ? 'active' : '' }}">
                                    <a href="{{ url('vicon') }}"> <span>Penggunaan Ruang Vicon</span></a>
                                </li>
                            </ul>
                        </li>
                    @endhasanyrole
                @endif

                @if (Auth::user()->kdkab == '00' || Auth::user()->kdkab == '04')
                    <li class="{{ request()->is('sira*') ? 'active' : '' }}">
                        <a href="#BuktiAdministrasi" class="has-arrow"><i class="icon-basket-loaded"></i> <span>Bukti
                                Administrasi (SIRA KLASIK)</span></a>
                        <ul>
                            <li class="{{ request()->is('sira') ? 'active' : '' }}"><a
                                    href="{{ url('sira') }}">Daftar</a></li>
                            <li class="{{ request()->is('sira/crete_akun') ? 'active' : '' }}"><a
                                    href="{{ url('sira/create_akun') }}">Tambah Akun</a></li>
                            <li class="{{ request()->is('sira/crete_akun') ? 'active' : '' }}"><a
                                    href="{{ url('sira/create') }}">Tambah Bukti Administrasi</a></li>
                        </ul>
                    </li>
                @endif

                <li class="{{ request()->is('meeting*') ? 'active' : '' }}">
                    <a href="#Dashboard" class="has-arrow"><i class="icon-users"></i>
                        <span>Rapat/Pertemuan</span></a>
                    <ul>
                        <li class="{{ request()->is('meeting') ? 'active' : '' }}"><a
                                href="{{ url('meeting') }}">Daftar</a></li>
                        <li class="{{ request()->is('meeting/kalender') ? 'active' : '' }}"><a
                                href="{{ url('meeting/kalender') }}">Kalender</a></li>
                    </ul>
                </li>

                <li class="{{ request()->is('surat_km*') ? 'active' : '' }}">
                    <a href="{{ url('surat_km') }}"> <i class="icon-doc"></i><span>Surat Menyurat</span></a>
                </li>

                @hasanyrole('superadmin|tatausaha')
                    <li class="{{ request()->is('user*') ? 'active' : '' }}">
                        <a href="{{ url('user') }}"> <i class="icon-users"></i><span>Kelola User</span></a>
                    </li>
                @endhasanyrole

                @role('superadmin|tatausaha')
                    <li
                        class="{{ request()->is('uker*') || request()->is('uker4*') || request()->is('angka_kredit*') || request()->is('type_kredit*') || request()->is('rincian_kredit*') ? 'active' : '' }}">
                        <a href="#Dashboard" class="has-arrow"><i class="icon-layers"></i> <span>Master Data</span></a>
                        <ul>
                            <li class="{{ request()->is('uker*') ? 'active' : '' }}"><a
                                    href="{{ url('uker') }}">Unit
                                    Kerja</a></li>
                            <li class="{{ request()->is('uker4*') ? 'active' : '' }}"><a
                                    href="{{ url('uker4') }}">Unit
                                    Kerja 4</a></li>
                            <li class="{{ request()->is('angka_kredit*') ? 'active' : '' }}"><a
                                    href="{{ url('angka_kredit') }}">Angka Kredit</a></li>
                            <li class="{{ request()->is('type_kredit*') ? 'active' : '' }}"><a
                                    href="{{ url('type_kredit') }}">Peruntukan Angka Kredit</a></li>
                            <li class="{{ request()->is('rincian_kredit*') ? 'active' : '' }}"><a
                                    href="{{ url('rincian_kredit') }}">Rincian Angka Kredit</a></li>
                            <li class="{{ request()->is('user*') ? 'active' : '' }}"><a
                                    href="{{ url('user') }}">User</a>
                            </li>
                            <li class="{{ request()->is('fungsional_definitif*') ? 'active' : '' }}"><a
                                    href="{{ url('fungsional_definitif?kab_filter=1600') }}">Fungsional Definitif</a>
                            </li>
                            <li class="{{ request()->is('jabatan_fungsional*') ? 'active' : '' }}"><a
                                    href="{{ url('jabatan_fungsional') }}">Jabatan Fungsional</a>
                            </li>

                        </ul>
                    </li>

                    <li
                        class="{{ request()->is('role*') || request()->is('permission*') || request()->is('user_role*') ? 'active' : '' }}">
                        <a href="#User" class="has-arrow"><i class="icon-user-following"></i> <span>Manajemen
                                User</span></a>
                        <ul>
                            <li class="{{ request()->is('role*') ? 'active' : '' }}"><a
                                    href="{{ url('role') }}">Roles</a>
                            </li>
                            <li class="{{ request()->is('permission*') ? 'active' : '' }}"><a
                                    href="{{ url('permission') }}">Permission</a></li>
                            <li class="{{ request()->is('user_role*') ? 'active' : '' }}"><a
                                    href="{{ url('user_role') }}">User Role</a></li>
                        </ul>
                    </li>
                @endrole

            </ul>
        </nav>
    </div>
</div>
