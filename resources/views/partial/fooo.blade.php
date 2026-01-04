<footer class="footer p-5 text-white-50 mt-auto border-top border-warning border-4" style="background-color: #1e3a5f;">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-md-3">
                <h6 class="fw-bold text-warning mb-3">{{ __('messages.Get Started') }}</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a class="text-white text-decoration-none hover-link" href="{{ route('dashboard') }}"><i class="fas fa-chevron-right me-2 small text-warning"></i>{{ __('messages.dashboard') }}</a></li>
                    <li class="mb-2"><a class="text-white text-decoration-none hover-link" href="{{ route('feedback.link') }}"><i class="fas fa-chevron-right me-2 small text-warning"></i>{{ __('messages.Submit Feedback') }}</a></li>
                </ul>
            </div>
            
            <div class="col-md-3">
                <h6 class="fw-bold text-warning mb-3">{{ __('messages.About FMS') }}</h6>
                <ul class="list-unstyled small text-white">
                    <li class="mb-2"><a class="text-white text-decoration-none hover-link" href="{{route('System.info')}}"><i class="fas fa-info-circle me-2 text-warning"></i>{{ __('messages.System Info') }}</a></li>
                    <li class="mb-2"><a class="text-white text-decoration-none hover-link" href="{{route('System.policy')}}"><i class="fas fa-shield-alt me-2 text-warning"></i>{{ __('messages.Privacy Policy') }}</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <h6 class="fw-bold text-warning mb-3">{{ __('messages.Contact Support') }}</h6>
                <ul class="list-unstyled small text-white">
                    <li class="mb-2"><i class="fas fa-phone me-2 text-warning"></i> +251 58 412 4578</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-warning"></i> FMS@inu.edu.et</li>
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-warning"></i> Injibara, Ethiopia</li>
                </ul>
            </div>

            <div class="col-md-3 text-md-end text-center mt-3 mt-md-0">
                <h6 class="fw-bold text-warning">{{ __('messages.University Name') }}</h6>
                <p class="extra-small mb-1 text-white">ICT Directorate</p>
                <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-2">
                    <a href="#" class="text-white-50 hover-warning"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white-50 hover-warning"><i class="fab fa-telegram-plane"></i></a>
                    <a href="http://www.inu.edu.et" target="_blank" class="text-white-50 hover-warning"><i class="fas fa-globe"></i></a>
                </div>
            </div>
        </div>
        <hr class="bg-light opacity-25 my-4">
        <div class="text-center">
            <p class="mb-0 small text-white-50">&copy; {{ date('Y') }} {{ __('messages.University Name') }}. {{ __('messages.All Rights Reserved') }}</p>
        </div>
    </div>
</footer>

<style>
    .hover-link:hover {
        color: #ffc107 !important;
        padding-left: 5px;
        transition: all 0.3s ease;
    }
    .hover-warning:hover {
        color: #ffc107 !important;
    }
</style>