<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Management</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <link rel="stylesheet" href="{{asset('css/layout.css')}}" type="text/css">
    <!-- Custom CSS for Layout -->
    <style>
        body {
            font-family: 'Inter', sans-serif; /* A nice, clean font */
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #212529; /* Dark background for sidebar */
            color: white;
            transition: margin-left 0.3s;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #ffffff;
            background-color: #343a40;
        }
        .sidebar .sidebar-header {
            padding: 1.5rem;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .main-content {
            flex-grow: 1;
            transition: margin-left 0.3s;
        }
        .content {
            padding: 2rem;
        }
        
        /* For mobile view */
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -260px; /* Hide sidebar by default */
            }
            .sidebar.active {
                margin-left: 0;
            }
            .main-content {
                width: 100%;
            }
        }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    /* Scale the card up slightly and add a larger shadow on hover */
    .card-hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }

    /* Create a subtle zoom effect for the image on hover */
    .card-hover-effect:hover .card-img-top {
        transform: scale(1.05);
    }
    
    /* Ensure image transition is smooth and doesn't overflow */
    .image-container {
        overflow: hidden;
    }

    .card-img-top {
        transition: transform 0.3s ease-in-out;
    }

    /* Optional: Style for the button hover effects */
    .btn-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    </style>
</head>
<body>
    <div class="d-flex">
        @include('partial.sidebar')

        <div class="main-content flex-fill">
            @include('partial.navbar')

            <div class="content">
                @yield('content')
            </div>

        </div>
        
    </div>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS for toggling sidebar -->
    <script>
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
</body>
</html>