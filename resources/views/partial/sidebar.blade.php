<div class="sidebar d-flex flex-column p-3" style="background-color: #1e3a5f; min-height: 100vh;border-right: 1px solid rgba(255,255,255,0.1);">
    <div class="sidebar-header text-center">
        <a class="navbar-brand d-block" href="{{ route('dashboard') }}">
            <img class="logo shadow-sm mb-2" src="{{ asset('image/logo.jfif') }}" width="85" height="85" >
            <div class="mt-1 fw-bold text-primary small">{{ __('messages.University Name') }}</div>
            
        </a>
    </div>

    <hr class="text-secondary my-3 opacity-25">

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> {{ __('messages.dashboard') }}
            </a>
        </li>

        @canany(['view-users', 'create-users', 'edit-users', 'delete-users'])
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link text-white {{ Request::routeIs('users.*') ? 'active bg-primary' : '' }}">
                <i class="fa-solid fa-user me-2"></i>{{ __('messages.User Manage') }}
            </a>
        </li>
        @endcanany

        @canany(['view-complaints', 'view-feedback'])
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['index', 'feedback.index']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
               <i class="fas fa-eye me-1"></i> {{ __('messages.View') }}
            </a>
            <ul class="dropdown-menu bg-info shadow">
                @can('view-complaints')
                <li><a class="dropdown-item" href="{{route('index')}}"><i class="fas fa-exclamation-triangle mx-2"></i>{{ __('messages.view Complaint') }}</a></li>
                @endcan
                @can('view-feedback')
                <li><a class="dropdown-item" href="{{route('feedback.index')}}"><i class="fas fa-comment-dots mx-2"></i>{{ __('messages.View Feedback') }}</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        @can('role-management')
        <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link text-white {{ Request::routeIs('roles.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-user-tag me-2"></i> {{ __('messages.Role Management') }}
            </a>
        </li>
        @endcan

        @canany(['view-colleges', 'view-departments', 'view-directories'])
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['colleges.*', 'departments.*', 'directories.*']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-tools me-2"></i>{{ __('messages.College/Directorate') }}
            </a>
            <ul class="dropdown-menu bg-info shadow">
                <li><a class="dropdown-item" href="{{route('colleges.index')}}"><i class="fas fa-building mx-2"></i>Colleges</a></li>
                <li><a class="dropdown-item" href="{{route('departments.index')}}"><i class="fas fa-graduation-cap mx-2"></i>Departments</a></li>
                <li><a class="dropdown-item" href="{{route('directories.index')}}"><i class="fas fa-sitemap mx-2"></i>Directories</a></li>
            </ul>
        </li>
        @endcanany

           @can('view-unit-reports')
<li class="nav-item">
    <a href="{{ route('admin.reports.units') }}" class="nav-link {{ request()->routeIs('admin.reports.units') ? 'active' : '' }} text-white">
        <i class="nav-icon fas fa-chart-line"></i>
        {{ __('messages.Unit Reports') }}
    </a>
</li>
@endcan

        <li class="nav-item mt-auto pt-5">
        <a href="{{ route('wel.link') }}" class="btn text-info btn-outline-secondary w-100">
            <i class="fas fa-arrow-left me-2"></i> {{ __('messages.Back to Home') }}
        </a></li>
    
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
            <img src="https://placehold.co/100x100/E2E8F0/4A5568?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="user" width="28" height="28" class="rounded-circle me-2">
            <strong class="small">{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="#">Edit Profile</a></li>
        </ul>
    </div>
    @endauth
</div>