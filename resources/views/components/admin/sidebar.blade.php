<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm mb-5">
    <div class="container">
        <div class="d-flex w-100 flex-column flex-lg-row">
            <!-- Top Row for Mobile: Brand and Menu -->
            <div class="d-flex justify-content-between align-items-center w-100">
                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center gap-2 {{ app()->getLocale() === 'ar' ? 'order-1' : 'order-5' }}"
                    href="{{ route('admin.dashboard') }}" aria-label="Go to dashboard">
                    {{-- Optional dual logos for theme switching --}}
                    {{-- Provide your actual logo files below, or keep the text fallback. --}}
                    {{-- Light logo (visible by default) --}}
                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="Logo" height="28" class="logo-light"
                        onerror="this.classList.add('d-none')">
                    {{-- Dark logo --}}
                    <img src="{{ asset('assets/images/logo-dark.png') }}" alt="Logo" height="28"
                        class="logo-dark d-none" onerror="this.classList.add('d-none')">
                    {{-- Text fallback --}}
                    <span class="fw-semibold app-name">{{ config('app.name') }}</span>
                </a>

                <!-- Menu Toggle & Notifications -->
                <div class="d-flex align-items-center gap-2">
                    <!-- Menu Toggle Button -->
                    <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"
                        aria-label="فتح القائمة">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <!-- Notifications Component -->
                    <div class="notifications-wrapper">
                        <!-- Desktop View -->
                        <div class="d-none d-lg-block">
                            <div class="dropdown">
                                <!-- تغيير من <a> إلى <button> -->
                                <button class="btn btn-outline-secondary position-relative" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        3
                                    </span>
                                </button>
                                <div class="dropdown-menu notifications-container dropdown-menu-end p-0">
                                    <div class="p-2 border-bottom d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0">الإشعارات</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="dropdown"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="notifications-list">
                                        <!-- قائمة الإشعارات -->
                                        @include('components.notifications-list')
                                    </div>
                                    <div class="p-2 border-top text-center">
                                        <a href="#" class="text-decoration-none">عرض كل الإشعارات</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile View -->
                        <div class="d-lg-none w-100 text-center">
                            <button class="btn btn-outline-secondary position-relative" type="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    3
                                </span>
                            </button>
                            <div class="dropdown-menu notifications-container dropdown-menu-end p-0">
                                <div class="p-2 border-bottom d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">الإشعارات</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="dropdown"
                                        aria-label="Close"></button>
                                </div>
                                <div class="notifications-list">
                                    <!-- قائمة الإشعارات -->
                                    @include('components.notifications-list')
                                </div>
                                <div class="p-2 border-top text-center">
                                    <a href="#" class="text-decoration-none">عرض كل الإشعارات</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
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
                @isset($menu)
                    @foreach ($menu as $index => $item)
                        @php
                            $collapseId = 'menuItem_' . $index;
                        @endphp

                        <li class="nav-item">

                            {{-- لو مفيش children → لينك عادي --}}
                            @if(empty($item['children']))
                                <a class="nav-link d-flex align-items-center {{ $item['active'] ? 'active-menu' : '' }}"
                                    href="{{ isset($item['route']) ? route($item['route']) : '#' }}">
                                    <i class="{{ $item['icon'] }} me-2"></i> {{ $item['title'] }}
                                </a>
                            @else
                                {{-- لو في children → collapsible --}}
                                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                                    href="#{{ $collapseId }}" role="button" aria-expanded="{{ $item['active'] ? 'true' : 'false' }}"
                                    aria-controls="{{ $collapseId }}">

                                    <span><i class="{{ $item['icon'] }} me-2"></i>{{ $item['title'] }}</span>
                                    <i class="fa-solid fa-chevron-down collapse-arrow"></i>
                                </a>

                                <div class="collapse {{ $item['active'] ? 'show' : '' }}" id="{{ $collapseId }}">
                                    <ul class="nav flex-column submenu-indent">
                                        @foreach ($item['children'] as $child)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $child['active'] ? 'active-submenu' : '' }}"
                                                    href="{{ route($child['route']) }}">
                                                    <i class="{{ $child['icon'] }} me-2"></i> {{ $child['title'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </li>
                    @endforeach
                @endisset
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

        /* 🔵 Active Parent Menu Style */
        .active-menu,
        .active-submenu {
            color: red !important;
            font-weight: bolder !important;
        }

        .active-submenu::before {
            content: "→ ";
            color: #d63031;
            font-weight: bold;
        }

        .active-menu::before {
            content: "→ ";
            color: #d63031;
            font-weight: bold;
        }

        [dir="rtl"] .active-submenu::before {
            content: " ←" !important;
        }

        [dir="rtl"] .active-menu::before {
            content: " ←" !important;
        }

        /* Notifications Styles */
        .notifications-list {
            /* max-height: 250px; */
            overflow-y: auto;
        }

        /* تعديل تنسيقات الإشعارات */
        .notifications-container {
            width: 300px !important;
            min-width: 300px !important;
            max-width: 300px !important;
        }

        @media (min-width: 768px) {
            .notifications-container {
                height: auto !important;
                max-height: 500px !important;
            }

            .notifications-list {
                max-height: 400px !important;
                overflow-y: auto;
            }
        }

        /* تنسيق فوتر الإشعارات */
        .notifications-container .border-top {
            border-top: 1px solid rgba(0, 0, 0, .1) !important;
        }

        .notifications-container .border-top a {
            font-size: 0.875rem;
            color: var(--bs-primary);
            display: inline-block;
            padding: 0.25rem 0.5rem;
        }

        /* إلغاء التنسيقات السابقة التي تسبب المشكلة */
        .dropdown-menu.notifications-container.show {
            width: 300px !important;
            height: auto !important;
        }

        [dir="rtl"] .notifications-container {
            left: auto !important;
            right: auto !important;
        }

        /* تنسيق السكرول */
        .notifications-list::-webkit-scrollbar {
            width: 5px;
        }

        .notifications-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .notifications-list::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 3px;
        }

        /* تنسيقات الوضع المظلم */
        body.theme-dark .notifications-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        .dropdown-item {
            white-space: normal;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }

        body.theme-dark .dropdown-item {
            border-bottom-color: rgba(255, 255, 255, .05);
        }

        /* New Responsive Styles */
        @media (max-width: 991px) {
            .notifications-container {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                bottom: 0 !important;
                width: 100% !important;
                max-height: 100vh !important;
                margin: 0 !important;
                transform: none !important;
            }

            .dropdown-menu.notifications-container.show {
                display: block !important;
                z-index: 1050 !important;
                border-radius: unset;
            }

            .notifications-list {
                height: calc(100vh - 110px);
            }
        }

        /* RTL Support for notifications on mobile */
        [dir="rtl"] .dropdown-menu-end {
            /* right: auto !important; */
            left: 0 !important;
            right: 0 !important;
        }

        /* Dropdown close button hover effect */
        .btn-close:hover {
            opacity: 1;
            background-color: rgba(0, 0, 0, .1);
        }

        body.theme-dark .btn-close:hover {
            background-color: rgba(255, 255, 255, .1);
        }


    </style>
@endauth