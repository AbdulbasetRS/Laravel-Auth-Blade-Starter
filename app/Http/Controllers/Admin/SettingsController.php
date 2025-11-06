<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    // Show settings form
    public function index()
    {
        // read cached/global setting (fallback false)
        $twoFactor = Cache::get('admin_two_factor_enabled', false);

        return view('admin.settings.index', compact('twoFactor'));
    }

    // Save settings
    public function update(Request $request)
    {
        $request->validate([
            'two_factor' => ['nullable', 'in:1'],
        ]);

        $enabled = $request->has('two_factor') && $request->input('two_factor') == '1';

        // store for one year (adjust persistence as needed)
        Cache::put('admin_two_factor_enabled', $enabled, now()->addYear());

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully');
    }
}
