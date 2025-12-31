<footer class="footer bg-dark text-white pt-5 pb-3 mt-auto border-top border-primary border-4">
    <div class="container">
        <div class="row g-4">
          
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3 text-primary text-uppercase">INU - FMS</h5>
                <p class="small text-white-50">
                    ይህ በእንጅባራ ዩኒቨርሲቲ የኮምፒውተር ሳይንስ ተማሪዎች የበለጸገ የቅሬታ እና ግብረ-መልስ ማስተዳደሪያ ሲስተም ነው። አገልግሎታችንን ለማሻሻል የእርስዎ ድምፅ ወሳኝ ነው።
                </p>
                <div class="mt-3">
                    <a href="http://www.inu.edu.et" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fas fa-globe"></i></a>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-2"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-primary btn-sm rounded-circle"><i class="fab fa-telegram-plane"></i></a>
                </div>
            </div>

<div class="col-lg-2 col-md-6">
    <h6 class="fw-bold mb-3 border-bottom border-primary pb-2" style="width: fit-content;">Quick Links</h6>
    <ul class="list-unstyled small">
        <li class="mb-2">
            <a href="{{ route('home.link') }}" class="text-white-50 text-decoration-none hover-link">
                <i class="fas fa-home me-2 text-primary"></i>Home
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('create') }}" class="text-white-50 text-decoration-none hover-link">
                <i class="fas fa-file-signature me-2 text-primary"></i>Send Complaint
            </a>
        </li>
        <li class="mb-2">
            <a href="{{ route('feedback.link') }}" class="text-white-50 text-decoration-none hover-link">
                <i class="fas fa-comment-dots me-2 text-primary"></i>Send Feedback
            </a>
        </li>
        <li class="mb-2 pt-2 mt-2 border-top border-secondary">
            <a href="{{ route('login') }}" class="text-warning text-decoration-none hover-link fw-bold">
                <i class="fas fa-sign-in-alt me-2 text-warning"></i>System Login
            </a>
        </li>
    </ul>
</div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Information</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{route('aboutinfo')}}" class="text-white-50 text-decoration-none hover-link"><i class="fas fa-info-circle me-2"></i>About system</a></li>
                    <li class="mb-2"><a href="{{route('aboutpolicy')}}" class="text-white-50 text-decoration-none hover-link"><i class="fas fa-user-shield me-2"></i>system policy</a></li>
                    <li class="mb-2"><a href="{{route('help')}}" class="text-white-50 text-decoration-none hover-link"><i class="fas fa-question-circle me-2"></i>Help Center</a></li>
                </ul>
            </div>

            
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Contact Address</h6>
                <ul class="list-unstyled small text-white-50">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Injibara University, Ethiopia</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> FMS@inu.edu.et</li>
                    <li class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i> +251 58 412 4578</li>
                    
                </ul>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="small mb-0 text-white-50">&copy; {{ date('Y') }} Injibara University. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="small mb-0 text-white-50">Developed by <span class="text-primary">CS Students</span></p>
            </div>
        </div>
    </div>
</footer>

<style>
    .hover-link:hover {
        color: #0d6efd !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    footer {
        font-family: 'Noto Sans Ethiopic', sans-serif;
    }
</style>