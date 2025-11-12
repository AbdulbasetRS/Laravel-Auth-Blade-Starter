<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 5);
        $page = (int) $request->get('page', 1);

        $user = auth()->user();
        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $query = $user->notifications()->orderBy('created_at', 'desc');
        $notifications = $query->paginate($perPage, ['*'], 'page', $page);

        // return paginator as JSON (Laravel includes data, total, current_page, next_page_url, etc.)
        return response()->json($notifications);
    }
}
