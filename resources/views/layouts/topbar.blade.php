<header id="page-topbar">
    <div class="navbar-header">
        <div class="container-fluid">
            <div class="float-right">

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(\Illuminate\Support\Facades\Auth::user()->profile_photo_path != null)
                            <img src="{{asset('images/photo-profil/'.\Illuminate\Support\Facades\Auth::user()->profile_photo_path)}}" alt="" class="rounded-circle header-profile-user">
                        @else
                            <img src="{{asset('images/user.png')}}" alt="" class="rounded-circle header-profile-user">
                        @endif
                        <span class="d-none d-xl-inline-block ml-1">{{\Illuminate\Support\Facades\Auth::user()->name}}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <!-- item-->
                        <a class="dropdown-item" href="{{route('auth.profil')}}"><i class="bx bx-user font-size-16 align-middle mr-1"></i> Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="{{route('auth.logout')}}"><i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Déconnexion</a>
                    </div>
                </div>



            </div>
            <div>
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <a href="{{route('auth.dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset('images/seter logo blanc.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('images/seter logo blanc.png')}}" alt="" height="30">
                        </span>
                    </a>

                    <a href="{{route('auth.dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('images/seter logo blanc.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('images/seter logo blanc.png')}}" alt="" height="50">
                        </span>
                    </a>
                </div>



            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

        </div>
    </div>
</header>
