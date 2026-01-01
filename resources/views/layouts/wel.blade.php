<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/wel.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <style>
        /* Hover Dropdown Logic for Desktop */
@media (min-width: 992px) {
    .hover-dropdown:hover .dropdown-menu {
        display: block;
        margin-top: 0;
        animation: fadeIn 0.3s;
    }
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Dropdown Item Styling */
.dropdown-item {
    padding: 10px 20px;
    font-size: 0.9rem;
    transition: all 0.2s;
}

.dropdown-item:hover {
    background-color: #f8f9fa;
    padding-left: 25px;
    color: #0d6efd;
}

.dropdown-menu {
    border-radius: 8px;
    overflow: hidden;
}
        .section-card {
        background-color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); 
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer; 
        border-left: 5px solid #0d6efd; 
    }

    .section-card:hover {
        transform: translateY(-3px); 
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #004d40; 
        margin-bottom: 8px;
    }


        body { font-family: 'Noto Sans Ethiopic', sans-serif; background-color: #f8f9fa; } /* Changed background */
        
        /* Style for Complaint (Red/Orange Theme) */
        .complaint-theme { border-left: 6px solid #dc3545; } /* Bootstrap red */
        .complaint-button { background-color: #dc3545; border-color: #dc3545; }
        .complaint-button:hover { background-color: #c82333; border-color: #bd2130; }
        
        /* Style for Feedback (Blue Theme) */
        .feedback-theme { border-left: 6px solid #0d6efd; } /* Bootstrap blue */
        .feedback-button { background-color: #0d6efd; border-color: #0d6efd; }
        .feedback-button:hover { background-color: #0b5ed7; border-color: #0a58ca; }

        /* Login Container - Using your existing style */
        .login-container { 
            margin: 40px auto;
            max-width: 450px; 
            padding: 40px; 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
        
        h2 { margin-left: 150px; color: #007bff; margin-bottom: 30px; font-weight: 600; }
        
        .header-main-bar { background-color: #1e3a5f; color: white; }
        
        .iu-logo { width: 70px; height: 70px; }
        .iu-main-title { font-size: 1.5rem; font-weight: 700; line-height: 1.1;}
        .iu-tagline { font-size: 0.75rem; font-weight: 300; line-height: 1; }
        .system-title-text { font-size: 1.5rem; font-weight: 300; }
        
        .navbar-custom { background-color:#004d40; !important; } /* Blue Navigation Bar */
    </style>
</head>
<body>

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
            Feedback And Complaint System
        </span>
    </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid container mx-auto">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link text-white btn btn-sm btn-outline-secondary me-2" aria-current="page" href="{{route('home.link')}}">
                    <i class="fas fa-home me-1"></i> Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white btn btn-sm btn-outline-secondary me-2" href="{{route('feedback.link')}}">
                    <i class="fas fa-comment-dots me-1"></i> Send Feedback
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white btn btn-sm btn-outline-secondary me-2" href="{{route('create')}}">
                    <i class="fas fa-file-alt me-1"></i> Send Complaint
                </a>
            </li>

            <li class="nav-item dropdown hover-dropdown">
                <a class="nav-link text-white btn btn-sm btn-outline-secondary dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
</nav>

    @yield('content')

    @include('partial.footer2') 
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>