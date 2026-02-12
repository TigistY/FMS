<footer class="footer p-5 text-white-50 mt-auto border-top border-warning border-4" style="background-color: #1e3a5f;">
    <div class="container-fluid">
    
            <div class="col-md-3 text-md-end text-centerg mt-3 mt-md-0">
                <div class="d-flex gap-3 mt-2">
                    <a href="#" class="text-white-50 hover-warning"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white-50 hover-warning"><i class="fab fa-telegram-plane"></i></a>
                    <a href="http://www.inu.edu.et" target="_blank" class="text-white-50 hover-warning"><i class="fas fa-globe"></i></a>
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