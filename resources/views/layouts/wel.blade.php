<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>
    
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/wel.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    <style>
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
        
        .header-main-bar { background-color: #004d40; color: white; }
        
        .iu-logo { width: 50px; height: 50px; }
        .iu-main-title { font-size: 1.5rem; font-weight: 700; line-height: 1.1; }
        .iu-tagline { font-size: 0.75rem; font-weight: 300; line-height: 1; }
        .system-title-text { font-size: 1.5rem; font-weight: 300; }
        
        .navbar-custom { background-color: #0d6efd !important; } /* Blue Navigation Bar */
    </style>
</head>
<body>
    <div class="header-main-bar ">
        <div class="container d-flex align-items-center justify-content-between py-2 mx-auto">
            <div class="logo-area d-flex align-items-center">
                <img src="{{asset('image/logo.jfif')}}" alt="Logo" class="iu-logo">
                <div class="text-area ms-3">
                    <h1 class="iu-main-title mb-0">INJIBARA UNIVERSITY</h1>
                    <p class="iu-tagline mb-0">Explore your creative potentials</p>
                </div>
            </div>

            <span class="system-title-text d-none d-md-block">Feedback And Complaint System</span>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid container mx-auto">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white btn btn-sm btn-outline-light me-2" aria-current="page" href="{{route('home.link')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white btn btn-sm btn-outline-light me-2" href="#">Help Center</a>
                </li>
                <li><a class="nav-link text-white btn btn-sm btn-outline-light me-2" href="{{route('feedback.link')}}">Send Feedback</a></li>
                <li><a class="nav-link text-white btn btn-sm btn-outline-light me-2" href="{{route('create')}}">Send Complaint</a></li>
            </ul>
            <a href="{{ route('login') }}" class="btn btn-warning btn-sm fw-bold">Login</a>
        </div>
    </nav>

    @yield('content')

    @include('partial.footer2') 
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>