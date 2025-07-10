<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Staff;
use App\Models\Classe;
use App\Models\Student;

class SuperAdminController extends Controller
{
    // View all admins
    public function index()
    {
        if (!session()->has('super_admin')) {
            return redirect('/login')->withErrors(['Access denied']);
        }

        $admins = Admin::all();
        return view('superadmin.manageadmin', compact('admins'));
    }

    // Toggle admin status
    public function toggleStatus($id)
    {
        if (!session()->has('super_admin')) {
            return redirect('/login')->withErrors(['Access denied']);
        }

        $admin = Admin::findOrFail($id);
        $admin->is_active = !$admin->is_active;
        $admin->save();

        return redirect()->back()->with('success', 'Admin status updated.');
    }

    // Show admin details
    public function show($id)
    {
        if (!session()->has('super_admin')) {
            return redirect('/login')->withErrors(['Access denied']);
        }

        $admin = Admin::findOrFail($id);
        return view('superadmin.admins.show', compact('admin'));
    }
    public function showStaffBySchool(Request $request)
    {
        $schools = Admin::orderBy('school_name')->get();
        $selectedSchool = null;
        $teachers = collect();

        if ($request->filled('school_id')) {
            $selectedSchool = Admin::find($request->school_id);
            if ($selectedSchool) {
                $teachers = Staff::where('dice_code', $selectedSchool->dice_code)->orderBy('name')->get();
            }
        }

        return view('superadmin.staff', compact('schools', 'selectedSchool', 'teachers'));
    }
public function index1(Request $request)
{
    $schools = Admin::all();
    $classes = Classe::all();

    $students = collect(); // default empty
    $selectedSchool = null;

    if ($request->filled('school_id')) {
        $selectedSchool = Admin::find($request->school_id);

        if ($selectedSchool) {
            $query = Student::where('dice_code', $selectedSchool->dice_code);

            if ($request->filled('admission_class')) {
                $query->where('admission_class', $request->class);
            }

            $students = $query->get();
        }
    }

    return view('superadmin.students', compact('schools', 'classes', 'students', 'selectedSchool'));
}

}

