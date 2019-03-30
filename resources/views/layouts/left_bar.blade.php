
    <div id="left-sidebar" class="sidebar">
        <div class="sidebar-scroll">
            <div class="user-account">
                <img src="{!! Auth::user()->fotoUrl !!}" class="rounded-circle user-photo" alt="User Profile Picture">
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }}</strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account">
                        <li><a href="page-profile2.html"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
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
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#Chat"><i class="icon-book-open"></i></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#setting"><i class="icon-settings"></i></a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#question"><i class="icon-question"></i></a></li>                
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
                <div class="tab-pane p-l-15 p-r-15" id="Chat">
                    <form>
                        <div class="input-group m-b-20">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="icon-magnifier"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                    <ul class="right_chat list-unstyled">
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="{!! asset('lucid/assets/images/xs/avatar4.jpg') !!}" alt="">
                                    <div class="media-body">
                                        <span class="name">Chris Fox</span>
                                        <span class="message">Designer, Blogger</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="{!! asset('lucid/assets/images/xs/avatar5.jpg') !!}" alt="">
                                    <div class="media-body">
                                        <span class="name">Joge Lucky</span>
                                        <span class="message">Java Developer</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="{!! asset('lucid/assets/images/xs/avatar2.jpg') !!}" alt="">
                                    <div class="media-body">
                                        <span class="name">Isabella</span>
                                        <span class="message">CEO, Thememakker</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="offline">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="{!! asset('lucid/assets/images/xs/avatar1.jpg') !!}" alt="">
                                    <div class="media-body">
                                        <span class="name">Folisise Chosielie</span>
                                        <span class="message">Art director, Movie Cut</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>
                        <li class="online">
                            <a href="javascript:void(0);">
                                <div class="media">
                                    <img class="media-object " src="{!! asset('lucid/assets/images/xs/avatar3.jpg') !!}" alt="">
                                    <div class="media-body">
                                        <span class="name">Alexander</span>
                                        <span class="message">Writter, Mag Editor</span>
                                        <span class="badge badge-outline status"></span>
                                    </div>
                                </div>
                            </a>                            
                        </li>                        
                    </ul>
                </div>
                <div class="tab-pane p-l-15 p-r-15" id="setting">
                    <h6>Choose Skin</h6>
                    <ul class="choose-skin list-unstyled">
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>                   
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="cyan" class="active">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="blush">
                            <div class="blush"></div>
                            <span>Blush</span>
                        </li>
                    </ul>
                    <hr>
                    <h6>General Settings</h6>
                    <ul class="setting-list list-unstyled">
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox">
                                <span>Report Panel Usag</span>
                            </label>
                        </li>
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox" checked>
                                <span>Email Redirect</span>
                            </label>
                        </li>
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox" checked>
                                <span>Notifications</span>
                            </label>                      
                        </li>
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox">
                                <span>Auto Updates</span>
                            </label>
                        </li>
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox">
                                <span>Offline</span>
                            </label>
                        </li>
                        <li>
                            <label class="fancy-checkbox">
                                <input type="checkbox" name="checkbox">
                                <span>Location Permission</span>
                            </label>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane p-l-15 p-r-15" id="question">
                    <form>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" ><i class="icon-magnifier"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                    </form>
                    <ul class="list-unstyled question">
                        <li class="menu-heading">HOW-TO</li>
                        <li><a href="javascript:void(0);">How to Create Campaign</a></li>
                        <li><a href="javascript:void(0);">Boost Your Sales</a></li>
                        <li><a href="javascript:void(0);">Website Analytics</a></li>
                        <li class="menu-heading">ACCOUNT</li>
                        <li><a href="javascript:void(0);">Cearet New Account</a></li>
                        <li><a href="javascript:void(0);">Change Password?</a></li>
                        <li><a href="javascript:void(0);">Privacy &amp; Policy</a></li>
                        <li class="menu-heading">BILLING</li>
                        <li><a href="javascript:void(0);">Payment info</a></li>
                        <li><a href="javascript:void(0);">Auto-Renewal</a></li>                        
                        <li class="menu-button m-t-30">
                            <a href="javascript:void(0);" class="btn btn-primary"><i class="icon-question"></i> Need Help?</a>
                        </li>
                    </ul>
                </div>                
            </div>          
        </div>
    </div>