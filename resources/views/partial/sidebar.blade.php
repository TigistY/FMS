<div class="sidebar d-flex flex-column p-3">
    <!-- Sidebar Header -->
    <div class="sidebar-header text-center">
        <a class="navbar-brand text-light fw-bold" href="{{ route('dashboard') }}">
            <img class="logo rounded-circle shadow" src="{{asset('imag/logo.jfif')}}" width="60" height="60" alt="FMSLogo">
            FMS
        </a>
    </div>

    <hr class="text-secondary my-3">

    <!-- Navigation Links -->
    <ul class="nav nav-pills flex-column mb-auto">
        <!-- Dashboard Link -->
        <li class="nav-item">
            <!-- Add active class for the correct page -->
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i>
                Dashboard
            </a>
        </li>

        @if (Auth::check() && (Auth::user()->can('view-complaints') || Auth::user()->can('view-feedback')))
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['complaints.index', 'feedback.index']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-reply-all me-2"></i>
                Response
            </a>
            <ul class="dropdown-menu bg-info" >

                @can('view-complaints')
                <li><a class="dropdown-item" href="{{route('index')}}"><i class="fas fa-exclamation-triangle mx-2"></i>View Complaints</a></li>
                @endcan
                
               
                @can('view-feedback')
                <li><a class="dropdown-item" href="#"><i class="fas fa-comment-dots mx-2"></i>View Feedback</a></li>
                @endcan
            </ul>
        </li>
        @endif

        
        @can('manage-units')
        <li class="nav-item dropdown mt-2">
            <a class="nav-link dropdown-toggle text-white {{ Request::routeIs(['units.create', 'roles.index']) ? 'active bg-primary' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-tools me-2"></i>
                Admin Tools
            </a>
            <ul class="dropdown-menu bg-info" >
                <li><a class="dropdown-item" href="{{route('units.create')}}"><i class="fas fa-building mx-2"></i>Add New Unit </a></li>
                <li><a class="dropdown-item" href="{{route('units.index')}}"><i class="fas fa-chart-bar mx-2"></i>View Units</a></li>
              
                <li><a class="dropdown-item" href="{{route('roles.index')}}"><i class="fas fa-user-tag mx-2"></i>Role Management</a></li> 
            </ul>
        </li>
        @endcan
        
        <li class="nav-item mt-auto pt-5">
            <form method="post" action="{{ route('logout') }}" class="w-100">
                @csrf
                <!-- We removed the style that pushed the Logout Button down -->
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i> LogOut
                </button>
            </form>
        </li>
    </ul>

    <hr class="text-secondary">
    
    <!-- User Profile at Bottom -->
    @auth
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://placehold.co/100x100/E2E8F0/4A5568?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="user" width="32" height="32" class="rounded-circle me-2">
            
            <strong>{{ Auth::user()->name }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Profile</a></li>
        </ul>
    </div>
    @endauth
</div>