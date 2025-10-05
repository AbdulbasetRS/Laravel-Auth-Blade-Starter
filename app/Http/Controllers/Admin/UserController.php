<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

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
                'created_at'
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
                    return '<a href="' . route('admin.users.show', $user['slug']) . '" class="btn btn-sm btn-info">Show</a>' 
                    . '<a href="' . route('admin.users.edit', $user['slug']) . '" class="btn btn-sm btn-warning">Edit</a>'
                    . '<a href="' . route('admin.users.destroy', $user['slug']) . '" class="btn btn-sm btn-danger">Delete</a>';
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        
        $statuses = UserStatus::cases();
        $types = UserType::cases();
        
        return view('admin.users.index', compact('statuses','types'));
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
        
        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found');
        }
        $user = new UserResource($user);
        // return $user;
        return view('admin.users.show', compact('user'));
    }

    public function edit($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $statuses = UserStatus::cases();
        $types = UserType::cases();
        return view('admin.users.edit', compact('user', 'statuses', 'types'));
    }

    public function update(UserUpdateRequest $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();

        // Update user fields
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile_number = $request->mobile_number;
        $user->national_id = $request->national_id;
        $user->nationality = $request->nationality;
        $user->passport_number = $request->passport_number;
        $user->status = $request->status;
        $user->type = $request->type;
        $user->can_login = $request->can_login;
        $user->status_details = $request->status_details;

        // Update profile fields if exists
        if ($user->profile) {
            $user->profile->first_name = $request->first_name;
            $user->profile->middle_name = $request->middle_name;
            $user->profile->last_name = $request->last_name;
            $user->profile->whatapp_number = $request->whatapp_number;
            $user->profile->telegram_number = $request->telegram_number;
            $user->profile->date_of_birth = $request->date_of_birth;
            $user->profile->gender = $request->gender;
            $user->profile->title = $request->title;
            $user->profile->address = $request->address;
            $user->profile->note = $request->note;
            $user->profile->save();
        }

        // Handle avatar upload (profile avatar)
        if ($request->hasFile('avatar')) {
            if ($user->profile && $user->profile->avatar) {
                Storage::delete($user->profile->avatar);
            }
            if ($user->profile) {
                $user->profile->avatar = $request->file('avatar')->store('avatars');
                $user->profile->save();
            }
        }

        // Handle password change
        if ($request->filled('password')) {
            // Only update if password is not empty and passes validation
            $user->password = \Hash::make($request->password);
        }

        $user->save();

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