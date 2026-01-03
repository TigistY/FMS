<header class="bg-dark shadow-md p-4 flex justify-between sticky top-0 z-10 d-flex align-items-center justify-content-end">
    
    <div class="me-3">
        <a class="nav-link position-relative px-2" href="{{ route('index') }}">
            <i class="fas fa-bell fa-lg text-white"></i> @if(isset($globalNotificationCount) && $globalNotificationCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                      style="font-size: 0.65rem; padding: 0.35em 0.5em; border: 2px solid #212529;">
                    {{ $globalNotificationCount }}
                </span>
            @endif
        </a>
    </div>

    <div class="dropdown float-end me-0 py-1 mx-2">
        <button class="btn btn-light dropdown-toggle border shadow-sm" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-globe text-primary me-1"></i> 
            {{ app()->getLocale() == 'en' ? 'English' : 'አማርኛ' }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow">
            <li>
                <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ url('lang/en') }}">
                    <span class="me-2">🇺🇸</span> English
                </a>
            </li>
            <li>
                <a class="dropdown-item d-flex align-items-center {{ app()->getLocale() == 'am' ? 'active' : '' }}" href="{{ url('lang/am') }}">
                    <span class="me-2">🇪🇹</span> አማርኛ
                </a>
            </li>
        </ul>
    </div>
</header>