<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm">
    <div class="container">
        <!-- Brand: keep before collapse on mobile to avoid jumping -->
        <a class="navbar-brand d-flex align-items-center gap-2 {{ app()->getLocale() === 'ar' ? 'order-1' : 'order-5' }}"
            href="{{ route('admin.dashboard') }}" aria-label="Go to dashboard">
            {{-- Optional dual logos for theme switching --}}
            {{-- Provide your actual logo files below, or keep the text fallback. --}}
            {{-- Light logo (visible by default) --}}
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo" height="28" class="logo-light"
                onerror="this.classList.add('d-none')">
            {{-- Dark logo --}}
            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="28" class="logo-dark d-none"
                onerror="this.classList.add('d-none')">
            {{-- Text fallback --}}
            <span class="fw-semibold app-name">{{ config('app.name') }}</span>
        </a>


        <!-- Collapse: comes after brand & toggler on mobile to avoid pushing them -->
        <div class="{{ app()->getLocale() === 'ar' ? 'order-1' : 'order-3' }}  order-lg-2" id="adminNavbar">
            <!-- Right: User Dropdown -->
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-lg-center">
                @auth
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"
                        aria-label="فتح القائمة">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                @endauth
            </ul>
        </div>
    </div>



</nav>


@auth
    <div class="offcanvas {{ app()->getLocale() === 'ar' ? 'offcanvas-end' : 'offcanvas-start' }}" data-bs-scroll="true"
        tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">

        <div class="offcanvas-header p-3">
            <div class="d-flex w-100 align-items-center justify-content-between">
                <div class="offcanvas-title-wrap flex-fill {{ app()->getLocale() === 'ar' ? 'text-start' : '' }}">
                    <h5 class="offcanvas-title mb-0" id="offcanvasWithBothOptionsLabel">
                        القائمة
                    </h5>
                </div>
                <div class="offcanvas-close-wrap flex-shrink-0">
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <div class="offcanvas-body d-flex flex-column h-100 p-0">

            <!-- Sidebar Menu -->
            <ul class="nav flex-column p-3">

                <!-- Link before list -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="fa-solid fa-house me-2"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>

                <!-- Collapse Menu -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                        href="#submenu1" role="button" aria-expanded="false" aria-controls="submenu1">
                        <span><i class="fa-solid fa-folder me-2"></i> المشاريع</span>
                        <i class="fa-solid fa-chevron-down collapse-arrow"></i>
                    </a>
                    <div class="collapse" id="submenu1">
                        <ul class="nav flex-column ms-4">
                            <li class="nav-item">
                                <a class="nav-link" href="#">مشروع 1</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">مشروع 2</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Link after list -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="#">
                        <i class="fa-solid fa-gear me-2"></i>
                        <span>الإعدادات</span>
                    </a>
                </li>
            </ul>

            <!-- Logout Section -->
            <div class="mt-auto border-top p-3">
                <a class="btn btn-danger w-100" href="#"
                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> تسجيل الخروج
                </a>
                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- CSS -->
    <style>
        .collapse-arrow {
            transition: transform 0.3s ease;
        }

        .nav-link[aria-expanded="true"] .collapse-arrow {
            transform: rotate(180deg);
        }
    </style>
@endauth
