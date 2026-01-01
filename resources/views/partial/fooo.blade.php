<footer class="footer p-4 text-white-50 bg-dark mt-auto border-top border-secondary">
    <div class="container-fluid">
        <div class="row">
            {{-- ፈጣን ሊንኮች --}}
            <div class="col-md-3">
                <h6 class="fw-bold text-white mb-3">{{ __('messages.Get Started') }}</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('dashboard') }}"><i class="fas fa-chevron-right me-2 small"></i>{{ __('messages.dashboard') }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{ route('feedback.link') }}"><i class="fas fa-chevron-right me-2 small"></i>{{ __('messages.Submit Feedback') }}</a></li>
                </ul>
            </div>
            {{-- መረጃ --}}
            <div class="col-md-3">
                <h6 class="fw-bold text-white mb-3">{{ __('messages.About FMS') }}</h6>
                <ul class="list-unstyled small">
                    <li><a class="text-white-50 text-decoration-none" href="{{route('System.info')}}"><i class="fas fa-info-circle me-2"></i>{{ __('messages.System Info') }}</a></li>
                    <li><a class="text-white-50 text-decoration-none" href="{{route('System.policy')}}"><i class="fas fa-shield-alt me-2"></i>{{ __('messages.Privacy Policy') }}</a></li>
                </ul>
            </div>
            {{-- አድራሻ --}}
            <div class="col-md-3">
                <h6 class="fw-bold text-white mb-3">{{ __('messages.Contact Support') }}</h6>
                <ul class="list-unstyled small">
                    <li><i class="fas fa-phone me-2"></i> +251 58 412 4578</li>
                    <li><i class="fas fa-envelope me-2"></i> FMS@inu.edu.et</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i> Injibara, Ethiopia</li>
                </ul>
            </div>
            {{-- ዩኒቨርሲቲው --}}
            <div class="col-md-3 text-md-end text-center mt-3 mt-md-0">
                <h6 class="fw-bold text-white">{{ __('messages.University Name') }}</h6>
                <p class="extra-small mb-1">ICT Directorate</p>
                <div class="d-flex justify-content-md-end justify-content-center gap-3 mt-2">
                    <a href="#" class="text-white-50"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white-50"><i class="fab fa-telegram-plane"></i></a>
                    <a href="http://www.inu.edu.et" target="_blank" class="text-white-50"><i class="fas fa-globe"></i></a>
                </div>
            </div>
        </div>
        <hr class="bg-secondary opacity-25">
        <div class="text-center">
            <p class="mb-0 small">&copy; {{ date('Y') }} {{ __('messages.University Name') }} ,{{ __('messages.All Rights Reserved') }}</p>
        </div>
    </div>
</footer>