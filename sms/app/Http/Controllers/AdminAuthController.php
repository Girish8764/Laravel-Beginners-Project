<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Auth;


class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'dice_code' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);


        // Try Super Admin login first
        $superAdmin = SuperAdmin::where('email', $request->email)->first();
        if ($superAdmin && Hash::check($request->password, $superAdmin->password)) {
            session(['super_admin' => $superAdmin->id]);
            return redirect('/admin/dashboard');
        }

        // Try Admin login
        $admin = Admin::where('email', $request->email)
              ->where('dice_code', $request->dice_code)
              ->where('is_active', 1)
              ->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin' => $admin->id]);
            return redirect('/admin/dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials or inactive account']);
    }
    public function register(Request $request)
    {
        $request->validate([
            'dice_code' => 'required|unique:admins,dice_code',
            'school_name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'mobile' => 'required|digits:10',
            'password' => 'required|confirmed|min:6',
        ]);

        Admin::create([
            'dice_code' => $request->dice_code,
            'school_name' => $request->school_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'is_active' => 0,
        ]);

        return redirect()->back()->with('success', 'Your School registered successfully.');
    }
    public function showRegister()
    {
        return view('register');
    }
    public function showLogin()
    {
        return view('login');
    }


}
