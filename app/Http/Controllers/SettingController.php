<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']); // Assumes 'admin' middleware for admin role
    }

    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = Setting::firstOrCreate([]);
        $admin = Auth::user();
        return view('admin.settings.index', compact('settings', 'admin'));
    }

    /**
     * Update site settings.
     */
    public function updateSiteSettings(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'currency' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:10',
            'tax_rate' => 'required|numeric|min:0|max:100',
        ]);

        $settings = Setting::firstOrCreate([]);

        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            if ($settings->site_logo) {
                Storage::disk('public')->delete($settings->site_logo);
            }
            $validated['site_logo'] = $request->file('site_logo')->store('logos', 'public');
        }

        $settings->update($validated);

        return redirect()->route('admin.settings.index')->with('success', 'Site settings updated successfully.');
    }

    /**
     * Update admin profile.
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $admin->id,
            'old_password' => 'nullable|string|min:8',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update name, email, and phone
        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->phone = $validated['phone'];

        // Update password if provided
        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($request->old_password, $admin->password)) {
                return back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }
            $admin->password = Hash::make($validated['new_password']);
        }

        $admin->save();

        return redirect()->route('admin.settings.index')->with('success', 'Admin profile updated successfully.');
    }
}
