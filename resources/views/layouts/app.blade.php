<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fcms</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.0/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.0/css/buttons.dataTables.css">
    
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.4/css/select.dataTables.min.css">

    <link rel="stylesheet" href="{{asset('css/layout.css')}}" type="text/css">
    
    <style>
        table.dataTable tbody tr.selected > * {
        background-color: #e7f1ff !important;
        color: #084298 !important; 
        box-shadow: inset 0 0 0 9999px #e7f1ff !important;
        border-bottom: 2px solid #0d6efd !important; 
    }

   
    table.dataTable tbody tr:hover {
        background-color: #f8f9fa !important;
        cursor: pointer;
    }

        .badge.rounded-pill.bg-danger {
    border: 2px solid #fff;
}

.dropdown-menu {
    border-radius: 12px;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.extra-small {
    font-size: 0.75rem;
}
        body {
            font-family: 'Inter', sans-serif; 
        }
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background-color: #212529; 
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
            margin-left: -260px;
            position: fixed;
            z-index: 1050;   
            height: 100vh;
            transition: 0.3s;
        }
        .sidebar.active {
            margin-left: 0 !important;
            box-shadow: 5px 0 15px rgba(0,0,0,0.5); 
        }
    }

    .card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

   
    .card-hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
    }

    
    .card-hover-effect:hover .card-img-top {
        transform: scale(1.05);
    }
    
    
    .image-container {
        overflow: hidden;
    }

    .card-img-top {
        transition: transform 0.3s ease-in-out;
    }

    
    .btn-primary:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    .dt-info {
        display: inline-block;
        margin-left: 15px;
        font-size: 0.9rem;
        color: #6c757d; 
    }
    .dt-length {
        display: inline-block;
    }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .sidebar { width: 260px; min-height: 100vh; background-color: #212529; color: white; transition: 0.3s; }
        .main-content { flex-grow: 1; transition: 0.3s; }
        .content { padding: 2rem; }
        .dt-buttons { margin-bottom: 15px; } 
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
    
    @include('partial.fooo')
{{-- for DataTable links--}}
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.datatables.net/2.1.0/js/dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.print.min.js"></script>

    <script src="https://cdn.datatables.net/select/2.0.4/js/dataTables.select.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sidebar-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('.sidebar').toggleClass('active');
        });

        $(document).on('click', function (e) {
            if (!$(e.target).closest('.sidebar').length && !$(e.target).closest('#sidebar-toggle').length) {
                $('.sidebar').removeClass('active');
            }
        });
    });
</script>

    @stack('scripts') 
</body>
</html>


