<div class="header-main-bar">
    <div class="container-fluid d-flex align-items-center justify-content-between py-2">
        <div class="logo-area d-flex align-items-center">
            <img src="{{asset('image/logo.jfif')}}" alt="Logo" class="iu-logo rounded-circle border border-4 border-white shadow">
            <div class="text-area ms-3">
                <h1 class="iu-main-title mb-0">INJIBARA UNIVERSITY</h1>
                <h1 class="iu-main-title mb-0 px-4">እንጅባራ ዩኒቨርሲቲ</h1>
                <p class="iu-tagline mb-0">Explore your creative potentials</p>
            </div>
        </div>
        <span class="system-title-text d-none d-md-block ms-auto text-end pe-3">
            Feedback And Complain System
        </span>
    </div>
</div>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid container mx-auto">
        <button class="navbar-toggler text-white border-0 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
    <i class="fas fa-bars fa-lg text-warning"></i>
</button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white me-2 hover-link" aria-current="page" href="{{route('home.link')}}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white hover-link me-2" href="{{route('feedback.link')}}">
                        <i class="fas fa-comment-dots me-1"></i> Send Feedback
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white hover-link me-2" href="{{route('create')}}">
                        <i class="fas fa-file-alt me-1"></i> Send Complain
                    </a>
                </li>

                <li class="nav-item dropdown hover-dropdown">
                    <a class="nav-link text-white hover-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                        <i class="fas fa-info-circle me-1"></i> About
                    </a>
                    <ul class="dropdown-menu shadow-lg border-0 mt-0" aria-labelledby="aboutDropdown">
                        <li><a class="dropdown-item" href="{{route('aboutinfo')}}"><i class="fas fa-laptop-code text-primary me-2"></i> System Info</a></li>
                        <li><a class="dropdown-item" href="{{route('aboutpolicy')}}"><i class="fas fa-user-shield text-success me-2"></i> Privacy Policy</a></li>
                        <li><a class="dropdown-item" href="{{route('aboutinu')}}"><i class="fas fa-university text-warning me-2"></i> About INU</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{route('help')}}"><i class="fas fa-question-circle text-danger me-2"></i> Help Center</a></li>
                    </ul>
                </li>
            </ul>
            <a href="{{ route('login') }}" class="btn btn-warning btn-outline-secondary btn-sm fw-bold px-3">
                <i class="fas fa-sign-in-alt me-1"></i> Login
            </a>
        </div>
    </div>
</nav>