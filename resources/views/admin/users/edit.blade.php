@extends('admin.structure')

@section('title', 'Edit User')

@section('content')
<div class="container">
    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="accordion" id="userAccordion">
            {{-- User Info Accordion --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingUser">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
                        User Info
                    </button>
                </h2>
                <div id="collapseUser" class="accordion-collapse collapse show" aria-labelledby="headingUser" data-bs-parent="#userAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @else @if(old('username')) is-valid @endif @enderror">
                                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @else @if(old('email')) is-valid @endif @enderror">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mobile_number" class="form-label">Mobile Number</label>
                                    <input type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number', $user->mobile_number) }}" class="form-control @error('mobile_number') is-invalid @else @if(old('mobile_number')) is-valid @endif @enderror">
                                    @error('mobile_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="national_id" class="form-label">National ID</label>
                                    <input type="text" name="national_id" id="national_id" value="{{ old('national_id', $user->national_id) }}" class="form-control @error('national_id') is-invalid @else @if(old('national_id')) is-valid @endif @enderror">
                                    @error('national_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nationality" class="form-label">Nationality</label>
                                    <input type="text" name="nationality" id="nationality" value="{{ old('nationality', $user->nationality) }}" class="form-control @error('nationality') is-invalid @else @if(old('nationality')) is-valid @endif @enderror">
                                    @error('nationality') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passport_number" class="form-label">Passport Number</label>
                                    <input type="text" name="passport_number" id="passport_number" value="{{ old('passport_number', $user->passport_number) }}" class="form-control @error('passport_number') is-invalid @else @if(old('passport_number')) is-valid @endif @enderror">
                                    @error('passport_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @else @if(old('status')) is-valid @endif @enderror">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}"
                                                {{ (old('status') !== null ? old('status') : $user->status) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" id="type" class="form-select @error('type') is-invalid @else @if(old('type')) is-valid @endif @enderror">
                                        @foreach($types as $type)
                                            <option value="{{ $type }}"
                                                {{ (old('type') !== null ? old('type') : $user->type) == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="can_login" class="form-label">Can Login</label>
                                    <select name="can_login" id="can_login" class="form-select @error('can_login') is-invalid @else @if(old('can_login')) is-valid @endif @enderror">
                                        <option value="1" @selected(old('can_login', $user->can_login))>Yes</option>
                                        <option value="0" @selected(!old('can_login', $user->can_login))>No</option>
                                    </select>
                                    @error('can_login') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="status_details" class="form-label">Status Details</label>
                                    <textarea name="status_details" id="status_details" class="form-control @error('status_details') is-invalid @else @if(old('status_details')) is-valid @endif @enderror">{{ old('status_details', $user->status_details) }}</textarea>
                                    @error('status_details') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Accordion --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingProfile">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProfile" aria-expanded="false" aria-controls="collapseProfile">
                        Profile Info
                    </button>
                </h2>
                <div id="collapseProfile" class="accordion-collapse collapse" aria-labelledby="headingProfile" data-bs-parent="#userAccordion">
                    <div class="accordion-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->profile?->first_name) }}" class="form-control @error('first_name') is-invalid @else @if(old('first_name')) is-valid @endif @enderror">
                                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" value="{{ old('middle_name', $user->profile?->middle_name) }}" class="form-control @error('middle_name') is-invalid @else @if(old('middle_name')) is-valid @endif @enderror">
                                    @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->profile?->last_name) }}" class="form-control @error('last_name') is-invalid @else @if(old('last_name')) is-valid @endif @enderror">
                                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="whatapp_number" class="form-label">WhatsApp Number</label>
                                    <input type="text" name="whatapp_number" id="whatapp_number" value="{{ old('whatapp_number', $user->profile?->whatapp_number) }}" class="form-control @error('whatapp_number') is-invalid @else @if(old('whatapp_number')) is-valid @endif @enderror">
                                    @error('whatapp_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telegram_number" class="form-label">Telegram Number</label>
                                    <input type="text" name="telegram_number" id="telegram_number" value="{{ old('telegram_number', $user->profile?->telegram_number) }}" class="form-control @error('telegram_number') is-invalid @else @if(old('telegram_number')) is-valid @endif @enderror">
                                    @error('telegram_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth"
                                        value="{{ old('date_of_birth', optional($user->profile)->date_of_birth ? \Carbon\Carbon::parse($user->profile->date_of_birth)->format('Y-m-d') : '') }}"
                                        class="form-control @error('date_of_birth') is-invalid @else @if(old('date_of_birth')) is-valid @endif @enderror">
                                    @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @else @if(old('gender')) is-valid @endif @enderror">
                                        <option value="">Select</option>
                                        <option value="male" @selected(old('gender', $user->profile?->gender) == 'male')>Male</option>
                                        <option value="female" @selected(old('gender', $user->profile?->gender) == 'female')>Female</option>
                                    </select>
                                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $user->profile?->title) }}" class="form-control @error('title') is-invalid @else @if(old('title')) is-valid @endif @enderror">
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @else @if(old('address')) is-valid @endif @enderror">{{ old('address', $user->profile?->address) }}</textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea name="note" id="note" class="form-control @error('note') is-invalid @else @if(old('note')) is-valid @endif @enderror">{{ old('note', $user->profile?->note) }}</textarea>
                                    @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Change Password Accordion --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingPassword">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
                        Change Password
                    </button>
                </h2>
                <div id="collapsePassword" class="accordion-collapse collapse" aria-labelledby="headingPassword" data-bs-parent="#userAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @else @if(old('password')) is-valid @endif @enderror">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @else @if(old('password_confirmation')) is-valid @endif @enderror">
                            @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Avatar Accordion --}}
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAvatar">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAvatar" aria-expanded="false" aria-controls="collapseAvatar">
                        Avatar
                    </button>
                </h2>
                <div id="collapseAvatar" class="accordion-collapse collapse" aria-labelledby="headingAvatar" data-bs-parent="#userAccordion">
                    <div class="accordion-body">
                        <div class="mb-3">
                           
                            @if($user->profile?->avatar_url)
                                <img src="{{ $user->profile->avatar_url }}" alt="Avatar" class="img-thumbnail mb-2" width="100">
                            @endif
                     
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @else @if(old('avatar')) is-valid @endif @enderror">
                            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">تحديث المستخدم</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right"></i> الرجوع للقائمة
            </a>
        </div>
    </form>
</div>
@endsection