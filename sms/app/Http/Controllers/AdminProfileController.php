<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminProfileController extends Controller
{

public function update(Request $request)
{
    $admin = auth('admin')->user();

    $validated = $request->validate([
        'school_name'   => 'nullable|string|max:255',
        'Sch_code'      => 'nullable|string|max:255',
        'Psp_code'      => 'nullable|string|max:255',
        'phone'         => 'nullable|string|max:15',
        'medium'        => 'nullable|string|max:50',
        'School_type'   => 'nullable|string|max:255',
        'Aff_year'      => 'nullable|string|max:255',
        'Aff_no'        => 'nullable|string|max:255',
        'standrad'      => 'nullable|string|max:255',
        'sec_year'      => 'nullable|string|max:255',
        'sr_sec_year'   => 'nullable|string|max:255',
        'address'       => 'nullable|string|max:255',
        'village'       => 'nullable|string|max:255',
        'tehsil'        => 'nullable|string|max:255',
        'district'      => 'nullable|string|max:255',
        'state_id'      => 'nullable|exists:locations,id',
        'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
    ]);

    // Convert state_id to state name
    if ($request->filled('state_id')) {
        $state = \App\Models\Location::where('id', $request->state_id)
                                     ->whereNull('parent_id')
                                     ->first();
        if ($state) {
            $validated['state'] = $state->name;
        }
    }

    // Handle image upload
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/admin'), $filename);
        $validated['image'] = 'uploads/admin/' . $filename;
    }

    // Update admin profile
    $admin->update($validated);

    return redirect()->back()->with('success', 'Profile updated successfully.');
}


public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $admin = auth('admin')->user();

    if (!Hash::check($request->current_password, $admin->password)) {
        throw ValidationException::withMessages([
            'current_password' => 'Current password is incorrect.',
        ]);
    }

    $admin->password = Hash::make($request->password);
    $admin->save();

    return redirect()->back()->with('success', 'Password changed successfully.');
}

}
