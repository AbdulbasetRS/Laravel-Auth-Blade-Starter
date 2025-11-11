<style>
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
        border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
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
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    body.theme-dark .dropdown-item {
        border-bottom-color: rgba(255, 255, 255, 0.05);
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
        background-color: rgba(0, 0, 0, 0.1);
    }

    body.theme-dark .btn-close:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
</style>

<!-- Toast container -->
<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>


<!-- Notifications Component -->
<div class="notifications-wrapper">
    <div class="dropdown w-100 text-center text-lg-start">
        <button class="btn position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="top: 2px !important;left: 75% !important;">
                0
            </span>
        </button>

        <div class="dropdown-menu notifications-container dropdown-menu-end p-0">
            <div class="p-2 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0">الإشعارات</h6>
                <button type="button" class="btn-close" data-bs-dismiss="dropdown" aria-label="Close"></button>
            </div>
            <div class="notifications-list">
                {{-- <!-- Notification Item -->
                <a href="#" class="dropdown-item p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-plus text-primary me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">مستخدم جديد</p>
                            <small class="text-muted">تم تسجيل حساب جديد</small>
                            <br>
                            <small class="text-muted">منذ 5 دقائق</small>
                        </div>
                    </div>
                </a>
                <!-- Order Notification -->
                <a href="#" class="dropdown-item p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-shopping-cart text-success me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">طلب جديد #123</p>
                            <small class="text-muted">تم استلام طلب جديد</small>
                            <br>
                            <small class="text-muted">منذ 10 دقائق</small>
                        </div>
                    </div>
                </a>
                <!-- System Notification -->
                <a href="#" class="dropdown-item p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cog text-warning me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">تحديث النظام</p>
                            <small class="text-muted">تم تحديث النظام بنجاح</small>
                            <br>
                            <small class="text-muted">منذ 15 دقيقة</small>
                        </div>
                    </div>
                </a>
                <!-- More notifications... -->
                <a href="#" class="dropdown-item p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-circle text-danger me-3"></i>
                        <div>
                            <p class="mb-0 fw-bold">تنبيه أمني</p>
                            <small class="text-muted">محاولة تسجيل دخول غير ناجحة</small>
                            <br>
                            <small class="text-muted">منذ 20 دقيقة</small>
                        </div>
                    </div>
                </a> --}}
            </div>

            <div class="p-2 border-top text-center">
                <a href="#" class="text-decoration-none">عرض كل الإشعارات</a>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * إضافة إشعار جديد في قائمة الإشعارات وتحديث العداد
     * @param {string} iconClass - أيقونة FontAwesome (مثلاً 'fa-user-plus text-primary')
     * @param {string} title - عنوان الإشعار (مثلاً "مستخدم جديد")
     * @param {string} message - محتوى الإشعار (مثلاً "تم تسجيل حساب جديد")
     * @param {string} time - الوقت (مثلاً "منذ 5 دقائق")
     * @param {string} link - الرابط (اختياري)
     */
    function addNotification(iconClass, title, message, time = 'الآن', link = '#') {
        const list = document.querySelector('.notifications-list');
        const badge = document.querySelector('.notifications-wrapper .badge');

        if (!list || !badge) return;

        // 🔹 إنشاء عنصر الإشعار بنفس التنسيق اللي كتبته
        const item = document.createElement('a');
        item.href = link;
        item.className = 'dropdown-item p-3 border-bottom';
        item.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas ${iconClass} me-3"></i>
                <div>
                    <p class="mb-0 fw-bold">${title}</p>
                    <small class="text-muted">${message}</small>
                    <br>
                    <small class="text-muted">${time}</small>
                </div>
            </div>
        `;

        // 🔸 إضافة الإشعار الجديد في أول القائمة
        list.prepend(item);

        // 🔸 تحديث العداد
        const currentCount = parseInt(badge.textContent.trim()) || 0;
        badge.textContent = currentCount + 1;

        // 🔸 تأثير لطيف على العداد
        badge.classList.add('animate__animated', 'animate__heartBeat');
        setTimeout(() => badge.classList.remove('animate__animated', 'animate__heartBeat'), 1000);
    }

    // 🧪 مثال استخدام:
    // addNotification('fa-user-plus text-primary', 'مستخدم جديد', 'تم تسجيل حساب جديد', 'منذ لحظات');
    // addNotification('fa-exclamation-circle text-danger', 'تنبيه أمني', 'محاولة تسجيل دخول غير ناجحة', 'منذ 2 دقيقة');



    /**
     * showNotificationToast
     * @param {string} iconClass - أيقونة FontAwesome (مثلاً 'fa-user-plus text-primary')
     * @param {string} title - عنوان الإشعار
     * @param {string} message - محتوى الإشعار
     * @param {string} time - الوقت
     * @param {string} link - الرابط (اختياري)
     * @param {number} duration - مدة ظهور التوست بالمللي ثانية
     */
    function showNotificationToast(iconClass, title, message, time = 'الآن', link = '#', duration = 4000, soundUrl = null) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'toast align-items-start border-0 shadow-sm mb-2';
        toast.style.width = '320px';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');

        toast.innerHTML = `
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start">
                <a href="${link}" class="d-flex text-decoration-none text-dark p-1 flex-fill">
                    <div class="align-content-center p-4">
                        <i class="fas ${iconClass} fa-lg"></i>
                    </div>
                    <div class="flex-fill">
                        <p class="mb-1 mt-1 fw-bold text-muted">${title}</p>
                        <small class="text-muted">${message}</small><br>
                        <small class="text-muted">${time}</small>
                    </div>
                </a>
                <button type="button" class="btn-close btn-close-white m-2" aria-label="Close"></button>
            </div>
            <div class="progress mt-2" style="height: 3px;">
                <div class="progress-bar bg-white" role="progressbar" style="width: 100%; transition: width linear ${duration}ms;"></div>
            </div>
        </div>
    `;

        container.appendChild(toast);


        // Default sound لو مابعتش المستخدم صوت
        const defaultSound = `${window.location.origin}/assets/sounds/default-notify.mp3`;
        const audioToPlay = soundUrl || defaultSound;

        const audio = new Audio(audioToPlay);
        audio.play().catch(e => console.log('Audio play failed:', e));

        const bsToast = new bootstrap.Toast(toast, { delay: duration });
        bsToast.show();

        // تحريك progress bar
        const progressBar = toast.querySelector('.progress-bar');
        setTimeout(() => { progressBar.style.width = '0%'; }, 50);

        // زر الإغلاق
        const closeBtn = toast.querySelector('.btn-close');
        closeBtn.addEventListener('click', () => {
            bsToast.hide(); // يخفي التوست فورًا
        });

        toast.addEventListener('hidden.bs.toast', () => toast.remove());
    }

    function showAndAddNotification(iconClass, title, message, time = 'الآن', link = '#', duration = 4000) {
        // نعرض Toast
        showNotificationToast(iconClass, title, message, time, link, duration);

        // نضيف لقائمة الإشعارات
        addNotification(iconClass, title, message, time, link);
    }

    // showAndAddNotification(
    //     'fa-user-plus text-primary',
    //     'مستخدم جديد',
    //     'تم تسجيل حساب جديد',
    //     'منذ 5 دقائق',
    //     '#',
    //     5000
    // );
</script>