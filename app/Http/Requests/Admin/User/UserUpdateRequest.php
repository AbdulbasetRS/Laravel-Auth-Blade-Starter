<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = \App\Models\User::where('slug', $this->route('user'))->first();
        $userId = $user ? $user->id : null;

        return [
            // User fields
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'mobile_number' => 'nullable|string|max:20|unique:users,mobile_number,' . $userId,
            'national_id' => 'nullable|string|max:20|unique:users,national_id,' . $userId,
            'nationality' => 'nullable|string|max:255',
            'passport_number' => 'nullable|string|max:255|unique:users,passport_number,' . $userId,
            'status' => 'required',
            'type' => 'required',
            'can_login' => 'required|boolean',
            'status_details' => 'nullable|string|max:1000',

            // Profile fields
            'first_name' => 'nullable|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'whatapp_number' => 'nullable|string|max:20',
            'telegram_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'title' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'note' => 'nullable|string|max:2000',

            // Avatar
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Password
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
