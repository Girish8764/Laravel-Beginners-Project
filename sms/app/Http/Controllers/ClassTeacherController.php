<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherClass;
use App\Models\Classe;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ClassTeacherController extends Controller
{
    public function index()
    {
        $diceCode = auth('admin')->user()->dice_code;

        $classes = Classe::all();
        $teachers = Staff::where('dice_code', $diceCode)->orderBy('name')->get();
        $assignedTeachers = TeacherClass::where('dice_code', $diceCode)->get();

        return view('admin.teacherClass', compact('classes', 'teachers', 'assignedTeachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'class' => 'required',
            'stream' => 'required',
        ]);

        $diceCode = Auth::guard('admin')->user()->dice_code;

        // Check if already assigned
        $exists = TeacherClass::where('dice_code', $diceCode)
            ->where('name', $request->name)
            ->where('class', $request->class)
            ->where('stream', $request->stream)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This teacher is already assigned to this class and stream.');
        }

        TeacherClass::create([
            'dice_code' => $diceCode,
            'name' => $request->name,
            'class' => $request->class,
            'stream' => $request->stream,
        ]);

        return redirect()->back()->with('success', 'Class Teacher Added Successfully');
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:teacher_class,id',
            'class' => 'required|string',
            'stream' => 'required|string',
            'name' => 'required|string',
        ]);

        DB::table('teacher_class')
            ->where('id', $request->id)
            ->update([
                'class' => $request->class,
                'stream' => $request->stream,
                'name' => $request->name,
            ]);

        return back()->with('success', 'Class teacher updated successfully.');
    }
    public function destroy($id)
    {
        TeacherClass::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Class Teacher Removed Successfully');
    }
}
