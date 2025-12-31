<div class="sidebar d-flex flex-column p-3" style="min-height: 100vh; background: linear-gradient(180deg, #2c3e50 0%, #000000 100%); width: 280px;">
    
    <div class="sidebar-header text-center mb-2">
        <a class="navbar-brand d-block" href="{{ route('dashboard') }}">
            <img class="logo shadow-sm mb-2" src="{{ asset('image/logo.jfif') }}" width="85" height="85" style="border: 3px solid #fff; border-radius: 50%; padding: 2px; object-fit: cover;">
            <div class="fw-bold text-white small" style="letter-spacing: 1px;">እንጅባራ ዩኒቨርሲቲ</div>
            <div class="extra-small text-info text-uppercase" style="font-size: 0.65rem;">Injibara University</div>
        </a>
    </div>

    <hr class="text-secondary my-3 opacity-25">

    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link text-white {{ Request::routeIs('dashboard') ? 'active bg-primary' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        {{-- User Management --}}
        @canany(['view-users', 'create-users', 'edit-users', 'delete-users'])
        <li class="nav-item mt-2">
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
            <ul class="dropdown-menu bg-info shadow">
                @can('view-complaints')
                <li><a class="dropdown-item" href="{{route('index')}}"><i class="fas fa-exclamation-triangle mx-2"></i>View Complaints</a></li>
                @endcan
                
                @can('view-feedback')
                <li><a class="dropdown-item" href="{{route('feedback.index')}}"><i class="fas fa-comment-dots mx-2"></i>View Feedback</a></li>
                @endcan
            </ul>
        </li>
        @endcanany

        {{-- Role Management --}}
        @can('role-management')
        <li class="nav-item mt-2">
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
                <i class="fas fa-tools me-2"></i> College/Directory
            </a>
            <ul class="dropdown-menu bg-info shadow">
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
    </ul>

    <div class="sidebar-footer mt-auto pt-3">
        <hr class="text-secondary opacity-25">
        
        {{-- Motto and Support --}}
        <div class="text-center mb-3 px-2">
            <h6 class="text-danger small fw-bold mb-1" style="text-shadow: 1px 1px 2px #000;">FMS - ለተሻለ አገልግሎት!</h6>
            <div class="bg-dark rounded p-2 border border-secondary mt-2">
                <small class="text-info d-block mb-1" style="font-size: 0.65rem;"><i class="fas fa-headset me-1"></i> የቴክኒክ ድጋፍ</small>
                <small class="text-white fw-bold" style="font-size: 0.75rem;">+251 9XX XXX XXX</small>
            </div>
        </div>

        {{-- Social Media Icons --}}
        <div class="d-flex justify-content-center gap-3 mb-3">
            <a href="https://www.facebook.com/injibarauniversity" target="_blank" class="text-white-50 social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="https://t.me/injibara_university" target="_blank" class="text-white-50 social-icon"><i class="fab fa-telegram-plane"></i></a>
            <a href="http://www.inu.edu.et" target="_blank" class="text-white-50 social-icon"><i class="fas fa-globe"></i></a>
        </div>

        {{-- Logout --}}
        <div class="mb-3">
            <form method="post" action="{{ route('logout') }}" class="w-100">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100 border-0 text-start ps-3">
                    <i class="fas fa-sign-out-alt me-2"></i> LogOut
                </button>
            </form>
        </div>

        {{-- Copyright & Developer --}}
        <div class="text-center border-top border-secondary pt-2">
            <small class="text-white-50 d-block" style="font-size: 0.65rem;">© {{ date('Y') }} Injibara University</small>
            <small class="text-info fw-bold" style="font-size: 0.6rem; letter-spacing: 1px;">ICT DIRECTORATE</small>
        </div>

        {{-- User Profile Dropdown --}}
        @auth
        <div class="dropdown mt-3">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://placehold.co/100x100/E2E8F0/4A5568?text={{ strtoupper(substr(Auth::user()->name, 0, 1)) }}" alt="user" width="28" height="28" class="rounded-circle me-2">
                <strong class="small text-truncate" style="max-width: 150px;">{{ Auth::user()->name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">Profile Settings</a></li>
            </ul>
        </div>
        @endauth
    </div>
</div>

<style>
    /* Custom Styles for better visual appeal */
    .social-icon {
        font-size: 1rem;
        transition: transform 0.3s ease, color 0.3s ease;
    }
    .social-icon:hover {
        color: #3498db !important;
        transform: translateY(-3px);
    }
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    .extra-small {
        font-size: 0.65rem;
    }
    /* Ensure sidebar handles long text */
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>