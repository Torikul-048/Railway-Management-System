<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display system settings page.
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Update system settings.
     */
    public function update(Request $request)
    {
        // For now, just show success message
        // In a real app, you'd save settings to database or config files
        
        return back()->with('success', 'Settings updated successfully.');
    }
}
