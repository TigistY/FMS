<header class="shadow-sm p-3 sticky-top z-10 d-flex align-items-center justify-content-end" style="background-color: #1e3a5f; border-bottom: 2px solid #ffc107;">
    
    {{-- notification part--}}
    <div class="me-3">
      @php
        $targetRoute = route('dashboard'); 
        if(Auth::check()){
            if(Auth::user()->hasRole('Unit Responder')){
                $targetRoute = route('index');
            }
        }
      @endphp

      @if(Auth::check() && !Auth::user()->hasRole('System Administrator'))
          @cannot('role-management')
             <a class="nav-link position-relative px-2 text-white" href="{{ $targetRoute }}">
                <i class="fas fa-bell fa-lg"></i> 
                @if(isset($globalNotificationCount) && $globalNotificationCount > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $globalNotificationCount }}
                    </span>
                @endif
            </a>
          @endcannot
      @endif
    </div>

    <div class="dropdown float-end me-2 py-1 mx-2">
        <button class="btn btn-outline-light dropdown-toggle border-0 shadow-sm fw-bold" type="button" data-bs-toggle="dropdown">
            <i class="fas fa-globe me-1 text-warning"></i> 
            {{ app()->getLocale() == 'en' ? 'English' : 'አማርኛ' }}
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
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