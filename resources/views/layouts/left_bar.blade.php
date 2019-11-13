
    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                <img src="{!! Auth::user()->fotoUrl !!}" class="rounded-circle user-photo" alt="User Profile Picture">
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account">
                        <li><a href="#"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="#"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="#"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
             </ul>
                
            <!-- Tab panes -->
            <div class="tab-content p-l-0 p-r-0">
                <div class="tab-pane active" id="menu">
                    <nav id="left-sidebar-nav" class="sidebar-nav">
                        <ul id="main-menu" class="metismenu">   
                            <li class="{{ (request()->is('log_book*') || request()->is('ckp*')) ? 'active' : '' }}">
                                <a href="#App" class="has-arrow"><i class="icon-grid"></i> <span>Aktivitas</span></a>
                                <ul>
                                    <li class="{{ request()->is('ckp*') ? 'active' : '' }}"><a href="{{url('ckp')}}">CKP</a></li>
                                    <li class="{{ request()->is('log_book*') ? 'active' : '' }}"><a href="{{ url('log_book') }}">Log Book</a></li>
                                </ul>
                            </li>

                            <li class="{{ (request()->is('pegawai_anda*')) ? 'active' : '' }}">
                                <a href="{{ url('pegawai_anda') }}" > <i class="icon-users"></i><span>Pegawai Anda</span></a>
                            </li>

                            <li class="{{ (request()->is('surat_km*')) ? 'active' : '' }}">
                                <a href="{{ url('surat_km') }}" > <i class="icon-users"></i><span>Surat Menyurat</span></a>
                            </li>

                            <li class="{{ (request()->is('jadwal_tugas*')) ? 'active' : '' }}">
                                <a href="#Jadwal" class="has-arrow"><i class="icon-basket-loaded"></i> <span>Jadwal Pegawai</span></a>
                                <ul>                                  
                                    <li class="{{ request()->is('jadwal_tugas*') ? 'active' : '' }}"><a href="{{url('jadwal_tugas')}}">Dinas Luar</a></li>
                                </ul>
                            </li>

                            
                            <li class="{{ (request()->is('master_barang*') || request()->is('opname_persediaan*')) ? 'active' : '' }}">
                                <a href="#Dashboard" class="has-arrow"><i class="icon-basket-loaded"></i> <span>Barang Persediaan</span></a>
                                <ul>                                  
                                    <li class="{{ request()->is('master_barang*') ? 'active' : '' }}"><a href="{{url('master_barang')}}">Master Barang</a></li>
                                    <li class="{{ request()->is('opname_persediaan*') ? 'active' : '' }}"><a href="{{url('opname_persediaan')}}">Opname Persediaan</a></li>
                                </ul>
                            </li>

                            @role('superadmin')
                                <li class="{{ (request()->is('uker*') || request()->is('angka_kredit*') || request()->is('type_kredit*') || request()->is('rincian_kredit*') || request()->is('user*')) ? 'active' : '' }}">
                                    <a href="#Dashboard" class="has-arrow"><i class="icon-layers"></i> <span>Master Data</span></a>
                                    <ul>                                  
                                        <li class="{{ request()->is('uker*') ? 'active' : '' }}"><a href="{{url('uker')}}">Unit Kerja</a></li>
                                        <li class="{{ request()->is('angka_kredit*') ? 'active' : '' }}"><a href="{{url('angka_kredit')}}">Angka Kredit</a></li>
                                        <li class="{{ request()->is('type_kredit*') ? 'active' : '' }}"><a href="{{url('type_kredit')}}">Peruntukan Angka Kredit</a></li>
                                        <li class="{{ request()->is('rincian_kredit*') ? 'active' : '' }}"><a href="{{url('rincian_kredit')}}">Rincian Angka Kredit</a></li>
                                        <li class="{{ request()->is('user*') ? 'active' : '' }}"><a href="{{url('user')}}">User</a></li>
                                    </ul>
                                </li>
                                
                                <li class="{{ (request()->is('role*') || request()->is('permission*') || request()->is('user_role*')) ? 'active' : '' }}">
                                    <a href="#User" class="has-arrow"><i class="icon-user-following"></i> <span>Manajemen User</span></a>
                                    <ul>
                                        <li class="{{ request()->is('role*') ? 'active' : '' }}"><a href="{{url('role')}}">Roles</a></li>
                                        <li class="{{ request()->is('permission*') ? 'active' : '' }}"><a href="{{url('permission')}}">Permission</a></li>
                                        <li class="{{ request()->is('user_role*') ? 'active' : '' }}"><a href="{{url('user_role')}}">User Role</a></li>
                                    </ul>
                                </li>
                            @endrole               
                            
                        </ul>
                    </nav>
                </div>          
            </div>          
        </div>
    </div>