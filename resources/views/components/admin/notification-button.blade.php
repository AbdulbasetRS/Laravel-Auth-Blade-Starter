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
<div class="notifications-wrapper" data-per-page="5">
    <div class="dropdown w-100 text-center text-lg-start">
        <button class="btn position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary"
                style="top: 2px !important;left: 75% !important;">
                0
            </span>
        </button>

        <div class="dropdown-menu notifications-container dropdown-menu-end p-0">
            <div class="p-2 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="mb-0">الإشعارات</h6>
                <button type="button" class="btn-close" data-bs-dismiss="dropdown" aria-label="Close"></button>
            </div>
            <div class="notifications-list"
                style="min-height:80px; max-height:400px; overflow:auto; position:relative;">
                <!-- items will be appended here -->
                {{-- <div class="notifications-loader text-center py-2 d-none">
                    <div class="spinner-border spinner-border-sm" role="status"><span
                            class="visually-hidden">Loading...</span></div>
                </div> --}}
                <div class="notifications-loader text-center p-2 d-none">جاري التحميل...</div>

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
    function updateBadgeVariant(badgeEl) {
        if (!badgeEl) return;
        const n = parseInt(badgeEl.textContent.trim()) || 0;
        badgeEl.classList.remove('bg-danger', 'bg-secondary');
        badgeEl.classList.add(n > 0 ? 'bg-danger' : 'bg-secondary');
    }

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
        updateBadgeVariant(badge);

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


    (function () {
        const wrapper = document.querySelector('.notifications-wrapper');
        if (!wrapper) return;

        const perPage = parseInt(wrapper.dataset.perPage || 5, 10);
        let currentPage = 1;
        let loading = false;
        let lastPage = false;

        const list = wrapper.querySelector('.notifications-list');
        const loader = list.querySelector('.notifications-loader');
        const badge = wrapper.querySelector('.badge');

        function showLoader(show) {
            if (!loader) return;
            loader.classList.toggle('d-none', !show);
        }

        function emptyPlaceholder() {
            const existing = list.querySelector('.no-notifications');
            if (existing) return existing;
            const el = document.createElement('div');
            el.className = 'no-notifications text-center text-muted p-3';
            el.innerText = 'لا توجد إشعارات';
            return el;
        }

        function renderNotificationItem(n) {
            // support both shapes: n may be notification object or data-only
            const id = n.id || null;
            const createdAt = n.created_at || n.createdAt || (n.data?.created_at ?? null);

            // payload inside `data` (DB notifications)
            const payload = n.data && typeof n.data === 'object' ? n.data : (n.payload || n);

            const title = payload.title || payload.title_ar || 'إشعار جديد';
            const body = payload.body || payload.message || JSON.stringify(payload);
            const time = createdAt ? new Date(createdAt).toLocaleString() : 'الآن';
            const iconClass = payload.icon || 'fa-user-plus text-primary';
            // try to link to user by id if provided (best-effort)
            const userId = payload.user_id || payload.user?.id || payload.user_id;
            const slug = payload.slug || payload.user?.slug || payload.slug;
            const link = slug ? `/admin/users/${slug}` : (payload.link || '#');

            const item = document.createElement('a');
            item.href = link;
            item.dataset.notificationId = id ?? '';
            item.className = 'dropdown-item p-3 border-bottom';
            item.innerHTML = `
                <div class="d-flex align-items-center">
                    <i class="fas ${iconClass} me-3" style="min-width:28px;text-align:center;"></i>
                    <div class="flex-fill">
                        <p class="mb-1 fw-bold">${title}</p>
                        <small class="text-muted d-block text-truncate" style="max-width:220px;">${escapeHtml(body)}</small>
                        <small class="text-muted">${escapeHtml(time)}</small>
                    </div>
                </div>
            `;
            return item;
        }

        // simple escaping to avoid raw HTML from payloads
        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        }

        async function fetchNotifications(page = 1) {
            if (loading || lastPage) return;
            loading = true;
            showLoader(true);
            try {
                const url = `/admin/notifications?page=${page}&per_page=${perPage}`;
                const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                if (!res.ok) throw new Error('Failed to fetch notifications');

                const data = await res.json();

                // support two shapes:
                // 1) paginator: { data: [...], total, next_page_url, current_page }
                // 2) plain array: [...]
                let items = [];
                let total = null;
                let nextPageUrl = null;
                if (Array.isArray(data)) {
                    items = data;
                    total = data.length;
                    nextPageUrl = null;
                } else if (data && Array.isArray(data.data)) {
                    items = data.data;
                    total = data.total ?? (data.data.length);
                    nextPageUrl = data.next_page_url ?? null;
                } else {
                    // fallback: if response wrapped directly as object list
                    items = data.items || [];
                    total = items.length;
                    nextPageUrl = data.next_page_url ?? null;
                }

                // first page: clear existing items and show placeholder if none
                if (page === 1) {
                    // remove existing items (except loader)
                    list.querySelectorAll('.dropdown-item, .no-notifications').forEach(el => el.remove());
                    if (!items.length) {
                        list.insertBefore(emptyPlaceholder(), loader);
                    }
                }

                // insert items (newest first). Items are expected sorted desc by API.
                items.forEach(n => {
                    const el = renderNotificationItem(n);
                    // insert before loader so newest appear on top
                    list.insertBefore(el, loader);
                });

                // update badge: prefer unread total if available, otherwise total
                if (total !== null) {
                    badge.textContent = total;
                } else {
                    // fallback to count of rendered notifications
                    const cnt = list.querySelectorAll('.dropdown-item').length;
                    badge.textContent = cnt;
                }
                updateBadgeVariant(badge);

                // determine if there are more pages
                if (!nextPageUrl && items.length < perPage) {
                    lastPage = true;
                } else {
                    lastPage = !nextPageUrl;
                    if (!lastPage) currentPage = page;
                }
            } catch (e) {
                console.error('Notifications load error:', e);
            } finally {
                loading = false;
                showLoader(false);
            }
        }

        // Infinite scroll handler
        function onScroll() {
            if (loading || lastPage) return;
            const threshold = 60; // px from bottom
            if (list.scrollTop + list.clientHeight >= list.scrollHeight - threshold) {
                fetchNotifications(currentPage + 1);
            }
        }

        // init on DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            updateBadgeVariant(wrapper.querySelector('.badge'));
            fetchNotifications(1);
        });

        // attach scroll and dropdown behavior
        const dropdownButton = wrapper.querySelector('[data-bs-toggle="dropdown"]');
        if (list) {
            list.addEventListener('scroll', onScroll);
        }
        if (dropdownButton && list) {
            dropdownButton.addEventListener('click', () => {
                // if empty (only loader or placeholder), load first page
                const hasItems = list.querySelectorAll('.dropdown-item').length > 0;
                if (!hasItems) {
                    fetchNotifications(1);
                }
            });
        }
    }());
</script>