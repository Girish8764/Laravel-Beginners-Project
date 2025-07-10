<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
public function index()
{
    $admin = Auth::guard('admin')->user();
    $diceCode = $admin->dice_code;

    $teachers = Staff::where('dice_code', $diceCode)
                ->orderByDesc('id')
                ->get();

    return view('admin.staff', compact('teachers'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:12',
        ]);

        Staff::create([
            'dice_code' => Auth::guard('admin')->user()->dice_code,
            'name' => $request->name,
            'f_name' => $request->f_name,
            'm_name' => $request->m_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'religion' => $request->religion,
            'category' => $request->category,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'subject' => $request->subject,
            'joining' => $request->joining,
            'password' => Hash::make($request->mobile), // 👈 Password same as mobile number
            'aadhar' => $request->aadhar
        ]);

        return redirect()->back()->with('success', 'Staff added successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:teachers,id',
            'name' => 'required|string|max:100',
            'email' => 'nullable|email|max:255',
        ]);

        $staff = Staff::findOrFail($request->id);
        $staff->update([
            'name' => $request->name,
            'f_name' => $request->f_name,
            'm_name' => $request->m_name,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'religion' => $request->religion,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'subject' => $request->subject,
            'joining' => $request->joining,
            'category' => $request->category,
            'aadhar' => $request->aadhar,
        ]);

        return redirect()->back()->with('success', 'Staff updated successfully.');
    }
public function changeStatus($id)
{
    $teacher = Staff::findOrFail($id); // Use Teacher::findOrFail($id) if model name is Teacher

    // Toggle status: 1 => 0, 0 => 1
    $teacher->status = $teacher->status ? 0 : 1;
    $teacher->save();

    return redirect()->back()->with('success', 'Teacher status updated successfully.');
}


}
