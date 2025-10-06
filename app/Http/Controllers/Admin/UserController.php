<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Helpers\PathHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::select([
                'id',
                'username',
                'slug',
                'email',
                'mobile_number',
                'national_id',
                'status',
                'type',
                'can_login',
                'status_details',
                'created_at',
            ]);

            // Filter by status if selected
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by type if selected
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            $users = $query->get();

            $userResource = UserResource::collection($users)->response()->getData(true);

            return DataTables::of($userResource['data'])
                ->addColumn('action', function ($user) {
                    return '<a href="'.route('admin.users.show', $user['slug']).'" class="btn btn-sm btn-info">Show</a>'
                    .'<a href="'.route('admin.users.edit', $user['slug']).'" class="btn btn-sm btn-warning">Edit</a>'
                    .'<a href="'.route('admin.users.destroy', $user['slug']).'" class="btn btn-sm btn-danger">Delete</a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $statuses = UserStatus::cases();
        $types = UserType::cases();

        return view('admin.users.index', compact('statuses', 'types'));
    }

    public function create()
    {
        $statuses = UserStatus::cases();
        $types = UserType::cases();

        return view('admin.users.create', compact('statuses', 'types'));
    }

    public function store(Request $request)
    {
        return view('admin.users.store');
    }

    public function show($slug)
    {
        $user = User::where('slug', $slug)->first();

        if (! $user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }
        $user = new UserResource($user);

        // return $user;
        return view('admin.users.show', compact('user'));
    }

    public function edit($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        
        $user = new UserResource($user);
        // return $user;
        $user = json_decode(json_encode($user)) ;
        $statuses = UserStatus::cases();
        $types = UserType::cases();

        return view('admin.users.edit', compact('user', 'statuses', 'types'));
    }

    public function update(UserUpdateRequest $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        // 🧩 Update user main fields
        $user->fill([
            'username' => $request->username,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'national_id' => $request->national_id,
            'nationality' => $request->nationality,
            'passport_number' => $request->passport_number,
            'status' => $request->status,
            'type' => $request->type,
            'can_login' => $request->can_login,
            'status_details' => $request->status_details,
        ]);

        // 🧱 Update profile if exists
        if ($user->profile) {
            $user->profile->fill([
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'whatapp_number' => $request->whatapp_number,
                'telegram_number' => $request->telegram_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'title' => $request->title,
                'address' => $request->address,
                'note' => $request->note,
            ]);
        }

        // 🖼️ Handle avatar upload
        if ($request->hasFile('avatar')) {

            // حذف الصورة القديمة لو موجودة
            if ($user->profile && $user->profile->avatar) {
                PathHelper::deleteUserAvatar($user->id, $user->profile->avatar);
            }

            // تخزين الصورة الجديدة
            $filename = PathHelper::storeUserAvatar($user->id, $request->file('avatar'));

            // حفظ اسم الصورة الجديدة في الـ DB
            if ($user->profile) {
                $user->profile->avatar = $filename;
                $user->profile->save();
            }
        }

        // 🔐 Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 💾 Save main user
        $user->save();

        // 💾 Save profile (لو لسه مش محفوظ)
        if ($user->profile) {
            $user->profile->save();
        }

        // ✅ Done
        return redirect()
            ->route('admin.users.edit', $user->slug)
            ->with('success', 'User updated successfully');
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
