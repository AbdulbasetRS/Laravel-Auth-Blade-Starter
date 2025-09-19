<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function index()
    {
        return view('admin.users.index');
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