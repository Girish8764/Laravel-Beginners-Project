<?php

// app/Http/Controllers/IDCardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admin;
use Auth;

class IDCardController extends Controller
{
    public function index()
    {
        $classes = \App\Models\Classe::all(); // if you use Classe model
        return view('admin.id_cards.index', compact('classes'));
    }

    public function generate(Request $request)
    {
        $template = $request->template;
        $type = $request->type; // student or staff
        $class = $request->class;
        $stream = $request->stream;

        $admin = Admin::where('dice_code', auth('admin')->user()->dice_code)->first();

        if ($type === 'student') {
            $students = Student::where('dice_code', $admin->dice_code)
                        ->when($class, fn($q) => $q->where('class', $class))
                        ->when($stream, fn($q) => $q->where('stream', $stream))
                        ->get();

            return view("admin.id_cards.templates.student.template$template", compact('students', 'admin'));
        } elseif ($type === 'staff') {
            $teachers = Teacher::where('dice_code', $admin->dice_code)->get();

            return view("admin.id_cards.templates.staff.template$template", compact('teachers', 'admin'));
        }

        return back()->with('error', 'Invalid request');
    }
}
