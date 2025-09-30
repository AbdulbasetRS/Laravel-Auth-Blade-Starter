<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $statuses = UserStatus::cases();
        $types = UserType::cases();
        return view('admin.users.edit', compact('user', 'statuses', 'types'));
    }

    public function update(Request $request, $id)
    {
        return view('admin.users.update');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}