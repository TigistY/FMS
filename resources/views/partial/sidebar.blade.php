<div class="sidebar d-flex flex-column p-3">
    <div class="sidebar-header text-center">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img class="logo" src="{{asset(('image/fe4.jfif'))}}" width="80" height="80">FMS</a>
    </div>

    <hr class="text-secondary my-3">

    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </li>

        @if (Auth::check() && (Auth::user()->can('view-complaints') || Auth::user()->can('view-feedback')))
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['index', 'feedback.index']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-reply-all me-2"></i>
                Response
            </a>
            <ul class="dropdown-menu bg-info" >
                @can('view-complaints')
                
                <li><a class="dropdown-item" href="{{route('index')}}"><i class="fas fa-exclamation-triangle mx-2"></i>View Complaints</a></li>
                @endcan
                
                @can('view-feedback')
               
                <li><a class="dropdown-item" href="{{route('feedback.index')}}"><i class="fas fa-comment-dots mx-2"></i>View Feedback</a></li>
                @endcan
            </ul>
        </li>
        @endif

        
        @if (Auth::check() && Auth::user()->hasAnyPermission(['manage colleges', 'manage directories', 'role-management']))
        <li class="nav-item dropdown mt-2">
            @php
                $managementRoutes = ['admin.colleges.*', 'admin.departments.*', 'admin.directories.*', 'admin.roles.*'];
                $isRouteActive = collect($managementRoutes)->contains(fn ($route) => Request::routeIs($route));
            @endphp
            
            {{-- Updated title here --}}
            <a class="nav-link dropdown-toggle text-white {{ $isRouteActive ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tools me-2"></i>
                Managemnt
            </a>
            
            <ul class="dropdown-menu bg-info" >
                
                @can('manage colleges')
                <li><a class="dropdown-item {{ Request::routeIs('colleges.*') ? 'active' : '' }}" href="{{route('colleges.index')}}"><i class="fas fa-building mx-2"></i>Colleges</a></li>
                <li><a class="dropdown-item {{ Request::routeIs('departments.*') ? 'active' : '' }}" href="{{route('departments.index')}}"><i class="fas fa-graduation-cap mx-2"></i>Departments</a></li>
                @endcan

                @can('manage directories')
                <li><a class="dropdown-item {{ Request::routeIs('directories.*') ? 'active' : '' }}" href="{{route('directories.index')}}"><i class="fas fa-sitemap mx-2"></i>Directories</a></li>
                @endcan
                
                @can('role-management') {{-- Assuming you use this permission for role management --}}
                <li><a class="dropdown-item {{ Request::routeIs('admin.roles.*') ? 'active' : '' }}" href="{{route('roles.index')}}"><i class="fas fa-user-tag mx-2"></i>Role Management</a></li> 
                @endcan
            </ul>
        </li>
        @endif
        
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
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://placehold.co/100x100/E2E8F0/4A5568?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="user" width="32" height="32" class="rounded-circle me-2">
            
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Edit Profile</a></li>
        </ul>
    </div>
    @endauth
</div>