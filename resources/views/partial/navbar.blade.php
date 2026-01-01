<!-- Top Header Bar -->
<header class="bg-dark shadow-md p-4 flex justify-between  sticky top-0 z-10">
    <div class="dropdown float-end me-0 py-1 mx-5">
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