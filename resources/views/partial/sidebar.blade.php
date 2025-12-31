<div class="sidebar d-flex flex-column p-3">
    <div class="sidebar-header text-center">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img class="logo" src="{{asset(('image/fe4.jfif'))}}" width="80" height="80">FMS</a>
    </div>

    <hr class="text-secondary my-3">

    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        {{-- User Management --}}
        @canany(['view-users', 'create-users', 'edit-users', 'delete-users'])
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link text-white {{ Request::routeIs('users.*') ? 'active bg-primary' : '' }}">
                <i class="fa-solid fa-user me-2"></i> User Manage
            </a>
        </li>
        @endcanany

        {{-- View (Complaints and Feedback) --}}
        @canany(['view-complaints', 'view-feedback'])
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['index', 'feedback.index']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
               <i class="fas fa-eye me-1"></i> View
            </a>
            <ul class="dropdown-menu bg-info">
                @can('view-complaints')
                <li><a class="dropdown-item" href="{{route('index')}}"><i class="fas fa-exclamation-triangle mx-2"></i>View Complaints</a></li>
                @endcan
                
                @can('view-feedback')
                <li><a class="dropdown-item" href="{{route('feedback.index')}}"><i class="fas fa-comment-dots mx-2"></i>View Feedback</a></li>
                @endcan
            </ul>
        </li>
          @endcanany

        {{-- Role Management  --}}
        @can('role-management')
        <li class="nav-item">
            <a href="{{route('roles.index')}}" class="nav-link text-white {{ Request::routeIs('roles.*') ? 'active bg-primary' : '' }}">
                <i class="fas fa-user-tag me-2"></i> Role Management
            </a>
        </li>
        @endcan

        {{-- Management (Colleges, Departments, Directories) --}}
        @canany(['view-colleges', 'view-departments', 'view-directories'])
        <li class="nav-item dropdown mt-2">
            @php
                $isMgmtActive = Request::routeIs(['colleges.*', 'departments.*', 'directories.*']);
            @endphp
            
            <a class="nav-link dropdown-toggle text-white {{ $isMgmtActive ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-tools me-2"></i>College/Directory
            </a>
            
            <ul class="dropdown-menu bg-info">
                @can('view-colleges')
                <li><a class="dropdown-item {{ Request::routeIs('colleges.*') ? 'active' : '' }}" href="{{route('colleges.index')}}"><i class="fas fa-building mx-2"></i>Colleges</a></li>
                @endcan

                @can('view-departments')
                <li><a class="dropdown-item {{ Request::routeIs('departments.*') ? 'active' : '' }}" href="{{route('departments.index')}}"><i class="fas fa-graduation-cap mx-2"></i>Departments</a></li>
                @endcan

                @can('view-directories')
                <li><a class="dropdown-item {{ Request::routeIs('directories.*') ? 'active' : '' }}" href="{{route('directories.index')}}"><i class="fas fa-sitemap mx-2"></i>Directories</a></li>
                @endcan
            </ul>
        </li>
        @endcanany
        
        {{-- Logout --}}
        <li class="nav-item mt-auto pt-5">
            <form method="post" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> LogOut
                </button>
            </form>
        </li>
    </ul>

    <hr class="text-secondary">
    
    @auth
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
            <img src="https://placehold.co/100x100/E2E8F0/4A5568?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="user" width="32" height="32" class="rounded-circle me-2">
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="#">Edit Profile</a></li>
        </ul>
    </div>
    @endauth
</div>