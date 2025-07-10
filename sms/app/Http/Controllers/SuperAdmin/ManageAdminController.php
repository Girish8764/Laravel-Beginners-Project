<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ManageAdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all();
        return view('superadmin.manageadmin', compact('admins'));
    }

    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->is_active = !$admin->is_active;
        $admin->save();

        return redirect()->route('superadmin.manageadmin')->with('status', 'Admin status updated successfully.');
    }
}
