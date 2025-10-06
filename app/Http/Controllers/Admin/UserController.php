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
        // $user = json_decode(json_encode($user)) ;
        $statuses = UserStatus::cases();
        $types = UserType::cases();

        return view('admin.users.edit', compact('user', 'statuses', 'types'));
    }

    public function update(UserUpdateRequest $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        $user->fill($request->userData());

        if ($user->profile) {
            $user->profile->fill($request->profileData());
        }

        if ($request->hasFile('avatar')) {
            if ($user->profile && $user->profile->avatar) {
                PathHelper::deleteUserAvatar($user->id, $user->profile->avatar);
            }

            $filename = PathHelper::storeUserAvatar($user->id, $request->file('avatar'));

            if ($user->profile) {
                $user->profile->avatar = $filename;
            }
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $userChanged = $user->isDirty();
        $profileChanged = $user->profile?->isDirty();

        if (! $userChanged && ! $profileChanged) {
            return redirect()
                ->route('admin.users.edit', $user->slug)
                ->with('info', 'لم يتم إجراء أي تغييرات');
        }

        // 💾 Save user and profile together
        $user->push();

        // ✅ Done
        return redirect()
            ->route('admin.users.edit', $user->slug)
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
