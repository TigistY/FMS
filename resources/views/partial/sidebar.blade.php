<div class="sidebar d-flex flex-column p-3" style="background-color: #1e3a5f; min-height: 100vh; border-right: 1px solid rgba(255,255,255,0.1);">
    <div class="sidebar-header text-center">
        <a class="navbar-brand d-block" href="{{ route('dashboard') }}">
            <img class="logo shadow-sm mb-2" src="{{ asset('image/logo.jfif') }}" width="85" height="85">
            <div class="mt-1 fw-bold text-primary small">{{ __('messages.University Name') }}</div>
        </a>
    </div>

    <hr class="text-secondary my-3 opacity-25">

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-home me-1"></i> {{ __('messages.Home') }}
            </a>
        </li>

        @canany(['view-users', 'role-management'])
        <li class="nav-item mt-2">
            <a class="nav-link text-white dropdown-btn {{ Request::routeIs(['users.*', 'roles.*']) ? 'active bg-primary' : '' }}" 
               data-bs-toggle="collapse" href="#userRoleMenu" role="button">
                <i class="fa-solid fa-users-gear me-2"></i> {{ __('messages.User Manage') }}
                <i class="fas fa-chevron-down float-end mt-1 small"></i>
            </a>
            <div class="collapse {{ Request::routeIs(['users.*', 'roles.*']) ? 'show' : '' }}" id="userRoleMenu">
                <ul class="nav flex-column ms-3 mt-1 submenu">
                    @can('view-users')
                    <li class="nav-item">
                        <a href="{{route('users.index')}}" class="nav-link text-white-50 small {{ Request::routeIs('users.index') ? 'text-white fw-bold' : '' }}">
                            <i class="fa-solid fa-user me-2"></i> {{ __('messages.Users List') }}
                        </a>
                    </li>
                    @endcan
                    @can('role-management')
                    <li class="nav-item">
                        <a href="{{route('roles.index')}}" class="nav-link text-white-50 small {{ Request::routeIs('roles.index') ? 'text-white fw-bold' : '' }}">
                            <i class="fas fa-user-tag me-2"></i> {{ __('messages.Role Management') }}
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcanany

        @can('view-complaints')
        <li class="nav-item mt-2">
            <a href="{{route('index')}}" class="nav-link text-white {{ Request::routeIs('index') ? 'active bg-primary' : '' }}">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ __('messages.view Complaint') }}
            </a>
        </li>
        @endcan

        @can('view-feedback')
        <li class="nav-item">
            <a href="{{route('feedback.index')}}" class="nav-link text-white {{ Request::routeIs('feedback.index') ? 'active bg-primary' : '' }}">
                <i class="fas fa-comment-dots me-2"></i> {{ __('messages.View Feedback') }}
            </a>
        </li>
        @endcan

        @canany(['view-colleges', 'view-departments', 'view-directories'])
        <li class="nav-item mt-2">
            <a class="nav-link text-white dropdown-btn {{ Request::routeIs(['colleges.*', 'departments.*', 'directories.*']) ? 'active bg-primary' : '' }}" 
               data-bs-toggle="collapse" href="#collegeMenu" role="button">
                <i class="fas fa-building-columns me-2"></i> {{ __('messages.College/Directorate') }}
                <i class="fas fa-chevron-down float-end mt-1 small"></i>
            </a>
            <div class="collapse {{ Request::routeIs(['colleges.*', 'departments.*', 'directories.*']) ? 'show' : '' }}" id="collegeMenu">
                <ul class="nav flex-column ms-3 mt-1 submenu">
                    <li><a class="nav-link text-white-50 small" href="{{route('colleges.index')}}"><i class="fas fa-university me-2"></i>Colleges</a></li>
                    <li><a class="nav-link text-white-50 small" href="{{route('directories.index')}}"><i class="fas fa-sitemap me-2"></i>Directories</a></li>
                </ul>
            </div>
        </li>
        @endcanany


        @can('view-unit-reports')
        <li class="nav-item">
            <a href="{{ route('admin.reports.units') }}" class="nav-link {{ request()->routeIs('admin.reports.units') ? 'active bg-primary' : '' }} text-white mt-2">
                <i class="nav-icon fas fa-chart-line me-2"></i> {{ __('messages.Unit Reports') }}
            </a>
        </li>
        @endcan

        {{-- Logout --}}
        <li class="nav-item mt-auto pt-5">
            <form method="post" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm w-100 border-0 text-start ps-3">
                    <i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.Logout') }}
                </button>
            </form>
        </li>
    </ul>

    @auth
    <div class="dropdown border-top border-secondary pt-3 mt-2">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                <i class="fas fa-user text-white small"></i>
            </div>
            <strong class="small">{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">My Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Logout</button>
                </form>
            </li>
        </ul>
    </div>
@endauth
</div>