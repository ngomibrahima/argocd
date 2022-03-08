<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            <div class="user-img">
                @if(\Illuminate\Support\Facades\Auth::user()->profile_photo_path != null)
                    <img src="{{asset('images/photo-profil/'.\Illuminate\Support\Facades\Auth::user()->profile_photo_path)}}" alt="" class="avatar-lg mx-auto img-thumbnail rounded-circle">
                @else
                    <img src="{{asset('images/user.png')}}" alt="" class="avatar-lg mx-auto img-thumbnail rounded-circle">
                @endif
            </div>

            <div class="mt-3">

                <a href="#" class="text-dark font-weight-medium font-size-16">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
                <p class="text-body mt-1 mb-0 font-size-13">{{\Illuminate\Support\Facades\Auth::user()->agent->fonction}}</p>

            </div>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "SUPER-ADMIN" ||
                        \Illuminate\Support\Facades\Auth::user()->user_type == "ADMIN")
                    <li>
                        <a href="{{route('elections.index')}}" class="waves-effect">
                            <i class="fas fa-person-booth"></i>
                            <span>ELECTIONS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('agents.index')}}" class="waves-effect">
                            <i class="fas fa-users"></i>
                            <span>AGENTS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('adherents')}}" class="waves-effect">
                            <i class="fas fa-user-check"></i>
                            <span>ADHERENTS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('posts.index')}}" class="waves-effect">
                            <i class="fas fa-file-alt"></i>
                            <span>PUBLICATIONS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('emailing.sendMailToAllAdherentForm')}}" class="waves-effect">
                            <i class="fas fa-paper-plane"></i>
                            <span>NOTIFICATIONS</span>
                        </a>
                    </li>
                @endif



                <li>
                    <a href="{{route('election.elections')}}" class="waves-effect">
                        <i class="fas fa-user-tie"></i>
                        <span>CANDIDATS</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('reglement')}}" class="waves-effect">
                        <i class="fas fa-gavel"></i>
                        <span>REGLEMENTS</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('statut')}}" class="waves-effect">
                        <i class="fas fa-info"></i>
                        <span>STATUTS</span>
                    </a>
                </li>




                @if(\Illuminate\Support\Facades\Auth::user()->user_type == "SUPER-ADMIN")
                    <li>
                        <a href="{{route('auth.users')}}" class="waves-effect">
                            <i class="fas fa-users"></i>
                            <span>UTILISATEURS</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{route('ressource.index')}}" class="waves-effect">
                            <i class="fas fa-camera"></i>
                            <span>RESSOURCES</span>
                        </a>
                    </li>
                @endif






            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
