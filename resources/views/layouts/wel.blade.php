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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* for dropdown */
@media (max-width: 991.98px) {
    .navbar-nav .dropdown-menu {
        position: static !important;
        float: none;
        background-color: rgba(255, 255, 255, 0.05);
        border: none;
        margin-top: 0;
        box-shadow: none;
    }

    .dropdown-item {
        color: #adb5bd !important;
        padding-left: 2rem !important; 
    }

    .dropdown-item:hover {
        color: #ffffff !important;
        background-color: transparent !important;
    }
    .dropdown-menu.show {
        display: block !important;
    }
}

 body { font-family: 'Noto Sans Ethiopic', sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; }

        
        @media (min-width: 992px) {
            .hover-dropdown:hover .dropdown-menu { display: block; margin-top: 0; animation: fadeIn 0.3s; }
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .dropdown-item { padding: 10px 20px; font-size: 0.9rem; transition: all 0.2s; }
        .dropdown-item:hover { background-color: #f8f9fa; padding-left: 25px; color: #0d6efd; }
        .dropdown-menu { border-radius: 8px; overflow: hidden; }

        .section-card {
            background-color: white; padding: 20px; margin-bottom: 20px; border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08); transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer; border-left: 5px solid #0d6efd; 
        }
        .section-card:hover { transform: translateY(-3px); box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15); }
        .section-title { font-size: 1.25rem; font-weight: 700; color: #004d40; margin-bottom: 8px; }

        .complaint-theme { border-left: 6px solid #dc3545; }
        .complaint-button { background-color: #dc3545; border-color: #dc3545; color: white; }
        .complaint-button:hover { background-color: #c82333; }
        
        .feedback-theme { border-left: 6px solid #0d6efd; }
        .feedback-button { background-color: #0d6efd; border-color: #0d6efd; color: white; }
        .feedback-button:hover { background-color: #0b5ed7; }

        
        .login-container { 
            margin: 40px auto; 
            max-width: 450px; 
            padding: 40px; 
            background: white;
             border-radius: 12px;
              box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
        .login-container h2 { 
            text-align: center;
         margin-left: 0; 
         color: #007bff; 
         margin-bottom: 30px; 
         font-weight: 600; 
     }

        
        .header-main-bar { background-color: #1e3a5f; color: white;}
        .iu-logo { width: 70px; height: 70px; }
        .iu-main-title { font-size: 1.5rem; font-weight: 700; line-height: 1.1;}
        .iu-tagline { font-size: 0.75rem; font-weight: 300; line-height: 1; }
        .system-title-text { font-size: 1.5rem; font-weight: 300; }
        .navbar-custom { background-color: #004d40 !important; }

        
        .site-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
        .content-area { flex: 1; }
        .lo{
            
            background-color: #1e3a5f;
        }
    </style>
</head>
<body>

    <div class="site-wrapper">
        @include('partial.navbar2')

        <div class="content-area">
            @yield('content')
        </div>

        @include('partial.footer2')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //for mobile toogle
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
</body>
</html>