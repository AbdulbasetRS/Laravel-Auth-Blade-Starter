<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
    <div class="container">
        <!-- Left: Logo / Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}" aria-label="Go to dashboard">
            {{-- Optional dual logos for theme switching --}}
            {{-- Provide your actual logo files below, or keep the text fallback. --}}
            {{-- Light logo (visible by default) --}}
            <img src="{{ asset('general/images/logo-light.png') }}" alt="Logo" height="28" class="logo-light" onerror="this.classList.add('d-none')">
            {{-- Dark logo --}}
            <img src="{{ asset('general/images/logo-dark.png') }}" alt="Logo" height="28" class="logo-dark d-none" onerror="this.classList.add('d-none')">
            {{-- Text fallback --}}
            <span class="fw-semibold app-name">{{ config('app.name') }}</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
            aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNavbar">
            <!-- Right: User Dropdown -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu"
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user me-2"></i>
                            <span>{{ auth()->user()->name ?? auth()->user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.users.show', ['id' => auth()->id()]) }}">
                                    <i class="fa-regular fa-id-badge me-2"></i> الملف الشخصي
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                   onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> تسجيل الخروج
                                </a>
                                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
    <!-- Note: Requires Bootstrap 5 JS (already included in admin.structure) -->
</nav>