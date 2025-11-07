<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom shadow-sm  mb-5">
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
                                <a class="nav-link d-flex justify-content-between align-items-center"
                                    data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button"
                                    aria-expanded="{{ $item['active'] ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">

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
        /* 
                                .active-menu {
                                    background-color: #0d6efd !important;
                                    color: #000000 !important;
                                    border-radius: 6px; 
                                }

                                .active-menu i {
                                    color: #000000 !important;
                                }

                                .active-submenu {
                                    color: #0d6efd !important;
                                    font-weight: 600;
                                }

                                .active-submenu i {
                                    color: #000000 !important;
                                }

                                body.theme-dark .active-menu {
                                    background-color: #1e88e5 !important;
                                    color: #0984e3 !important;
                                    font-weight: bolder;
                                }

                                body.theme-dark .active-submenu {
                                    color: #0984e3 !important;
                                    font-weight: bolder;
                                } 
                            */

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
    </style>
@endauth