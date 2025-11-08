let lang = document.documentElement.lang; // هيجيب "ar" أو "en" أو غيره

// ✅ Apply global defaults for DataTables
$.extend(true, $.fn.dataTable.defaults, {
    language: {
        url: `/assets/libraries/dataTables/2.4.2/i18n/${lang}.json`,
    },
    pageLength: 10,
    dom: '<"top d-flex justify-content-between align-items-center"Bf>rt<"bottom d-flex justify-content-between align-items-center"lip>',
    buttons: [
        {
            extend: "copy",
            exportOptions: {
                columns: ":visible",
            },
            className: "btn btn-primary",
        },
        {
            extend: "excel",
            exportOptions: {
                columns: ":visible",
            },
            className: "btn btn-success",
        },
        {
            extend: "csv",
            exportOptions: {
                columns: ":visible",
            },
            className: "btn btn-info",
        },
        {
            extend: "pdf",
            exportOptions: {
                columns: ":visible",
            },
            className: "btn btn-danger",
        },
        {
            extend: "print",
            exportOptions: {
                columns: ":visible",
            },
            className: "btn btn-warning",
        },
        {
            extend: "colvis",
            className: "btn btn-dark",
        },
    ],
    lengthMenu: [
        [10, 20, 50, -1],
        [10, 20, 50, "All"],
    ],
    processing: true,
    serverSide: true,
    columnDefs: [
        {
            targets: -1,
            className: "dt-center",
        },
    ],
});



/* ===================================================== */
/* === Start: Admin Sidebar ============================ */
/* ===================================================== */

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

/* ===================================================== */
/* === End: Admin Sidebar ============================== */
/* ===================================================== */


/* ===================================================== */
/* === Start: Notification Toast ====================== */
/* ===================================================== */
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
/* ===================================================== */
/* === End: Notification Toast ======================== */
/* ===================================================== */