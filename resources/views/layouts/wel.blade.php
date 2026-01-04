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
        
        .header-main-bar { background-color: #1e3a5f; color: white;}
        
        .iu-logo { width: 70px; height: 70px; }
        .iu-main-title { font-size: 1.5rem; font-weight: 700; line-height: 1.1;}
        .iu-tagline { font-size: 0.75rem; font-weight: 300; line-height: 1; }
        .system-title-text { font-size: 1.5rem; font-weight: 300; }
        
        .navbar-custom { background-color:#004d40; !important; }
    </style>
</head>
<body>

<div class="d-flex">

        <div class="main-content flex-fill">
            @include('partial.navbar2')

            <div class="content">
                @yield('content')
            </div>

        </div>
        
    </div>
@include('partial.footer2')

    
    
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>