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
                    <a class="nav-link d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                        <i class="fa-solid fa-house me-2"></i>
                        <span>الرئيسية</span>
                    </a>
                </li>

                <!-- Users Management -->
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                        href="#userMenu" role="button" aria-expanded="false" aria-controls="userMenu">
                        <span><i class="fa-solid fa-users me-2"></i>إدارة المستخدمين</span>
                        <i class="fa-solid fa-chevron-down collapse-arrow"></i>
                    </a>
                    <div class="collapse" id="userMenu">
                        <ul class="nav flex-column submenu-indent">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">
                                    <i class="fa-solid fa-users me-2"></i> كل المستخدمين
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.create') }}">
                                    <i class="fa-solid fa-user-plus me-2"></i> إضافة مستخدم
                                </a>
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

        /* Base nav-link */
        .offcanvas .nav-link {
            color: var(--app-fg) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            /* شوية نعومة في الحواف */
            display: block;
            /* عشان ياخد العرض كله */
            margin-bottom: 3px;
            /* المسافة بين العناصر */

        }

        /* Hover & Focus */
        .offcanvas .nav-link:hover,
        .offcanvas .nav-link:focus {
            background-color: rgba(0, 0, 0, 0.08);
            /* خلفية خفيفة */
            color: #000 !important;

        }

        /* Dark theme hover */
        body.theme-dark .offcanvas .nav-link:hover,
        body.theme-dark .offcanvas .nav-link:focus {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff !important;

        }

        /* Active link (لما القائمة تتفتح أو اللينك selected) */
        .offcanvas .nav-link.active,
        .offcanvas .nav-link[aria-expanded="true"] {
            background-color: rgba(0, 123, 255, 0.2);
            /* لون مميز */
            color: #007bff !important;
        }

        /* Dark theme active */
        body.theme-dark .offcanvas .nav-link.active,
        body.theme-dark .offcanvas .nav-link[aria-expanded="true"] {
            background-color: rgba(0, 123, 255, 0.3);
            color: #4dabff !important;
        }

        .offcanvas .nav-link {
            line-height: 1.5rem;
            /* طول سطر ثابت */
            padding: 0.5rem 1rem;
            /* padding ثابت */
        }

        /* الافتراضي (LTR) */
        .submenu-indent {
            margin-left: 1.5rem;
        }

        /* RTL */
        [dir="rtl"] .submenu-indent {
            margin-left: 0;
        }
    </style>
@endauth
