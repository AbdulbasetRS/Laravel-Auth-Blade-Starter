@extends('admin.structure')

@section('title', 'عرض المستخدم - ' . $user->username)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">معلومات المستخدم</h3>
                        <div class="">
                            <a href="{{ route('admin.users.edit', $user->slug) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> تعديل
                            </a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- User Image -->
                            <div class="col-md-3 text-center mb-4">
                                <div class="mb-3">
                                    @if ($user->profile && $user->profile->avatar)
                                        <img src="{{ asset('storage/' . $user->profile->avatar) }}" alt="صورة المستخدم"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    @else
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 200px; height: 200px; margin: 0 auto;">
                                            <i class="fas fa-user fa-5x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <h4>{{ $user->profile->full_name ?? 'غير محدد' }}</h4>
                                <span class="badge bg-{{ $user->status }}">{{ $user->status }}</span>
                            </div>

                            <!-- User Details -->
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>المعلومات الأساسية</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">اسم المستخدم:</th>
                                                <td>{{ $user->username }}</td>
                                            </tr>
                                            <tr>
                                                <th>البريد الإلكتروني:</th>
                                                <td>{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <th>رقم الجوال:</th>
                                                <td>{{ $user->mobile_number ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>رقم الهوية:</th>
                                                <td>{{ $user->national_id ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>حالة الحساب:</th>
                                                <td>
                                                    <span class="badge bg-{{ $user->status }}">
                                                        {{ $user->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>نوع المستخدم:</th>
                                                <td>{{ $user->type }}</td>
                                            </tr>
                                            <tr>
                                                <th>تاريخ الإنشاء:</th>
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <h5>معلومات الملف الشخصي</h5>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th width="40%">الاسم الأول:</th>
                                                <td>{{ $user->profile->first_name ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>اسم الأب:</th>
                                                <td>{{ $user->profile->middle_name ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>العائلة:</th>
                                                <td>{{ $user->profile->last_name ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>الجنس:</th>
                                                <td>{{ $user->profile->gender ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>تاريخ الميلاد:</th>
                                                <td>{{ $user->profile->date_of_birth ? $user->profile->date_of_birth->format('Y-m-d') : 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>رقم الواتساب:</th>
                                                <td>{{ $user->profile->whatapp_number ?? 'غير محدد' }}</td>
                                            </tr>
                                            <tr>
                                                <th>العنوان:</th>
                                                <td>{{ $user->profile->address ?? 'غير محدد' }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if ($user->profile->note)
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <h5>ملاحظات إضافية</h5>
                                            <div class="card ">
                                                <div class="card-body">
                                                    {{ $user->profile->note }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="me-3">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    تم الإنشاء: {{ $user->created_at->diffForHumans() }}
                                </span>
                                <span>
                                    <i class="fas fa-sync-alt me-1"></i>
                                    آخر تحديث: {{ $user->updated_at->diffForHumans() }}
                                </span>
                            </div>
                            <div>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                    <i class="fas fa-arrow-right"></i> العودة للقائمة
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>هل أنت متأكد من رغبتك في حذف المستخدم <strong>{{ $user->username }}</strong>؟</p>
                    <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه وسيتم حذف جميع البيانات المرتبطة بهذا المستخدم.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.users.destroy', $user->slug) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add any additional JavaScript if needed
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any tooltips or other JS functionality
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
