<?php

namespace App\Http\Controllers;

use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Classe;
use App\Models\Subject;

class TeacherSubjectController extends Controller
{
    public function index()
    {
        $diceCode = auth('admin')->user()->dice_code;

        $subjects = TeacherSubject::where('dice_code', $diceCode)->get();
        $teachers = Staff::where('dice_code', $diceCode)->orderBy('name')->get();
        $classes = Classe::all(); // Make sure 'Classe' model exists
        $streams = ['General', 'Arts', 'Science', 'Commerce', 'Agriculture'];
        $subjectOptions = ['Hindi', 'English', 'Math', 'Science', 'Geography', 'Computer Science'];

        return view('admin.subject_allotment', compact(
            'subjects', 'teachers', 'classes', 'streams', 'subjectOptions'
        ));
    }


public function store(Request $request)
{
    TeacherSubject::create([
        'dice_code' => auth('admin')->user()->dice_code,
        'teacher' => $request->teacher_name,
        'class' => $request->class,
        'stream' => $request->stream,
        'subject' => $request->subject,
    ]);

    return back()->with('success', 'Subject assigned successfully!');
}


    public function destroy($id)
    {
        TeacherSubject::destroy($id);
        return back()->with('success', 'Assignment removed.');
    }
public function getStreamsAndSubjects(Request $request)
{
    $request->validate([
        'class' => 'required',
    ]);

    // Fetch all streams for this class
    $streams = Subject::where('class', $request->class)
        ->pluck('stream')
        ->unique()
        ->values();

    // If stream is also selected, filter subjects by both class and stream
    if ($request->filled('stream')) {
        $subjects = Subject::where('class', $request->class)
            ->where('stream', $request->stream)
            ->pluck('name')
            ->unique()
            ->values();
    } else {
        // If no stream is selected (e.g. for classes like 6th–10th)
        $subjects = Subject::where('class', $request->class)
            ->pluck('name')
            ->unique()
            ->values();
    }

    return response()->json([
        'streams' => $streams,
        'subjects' => $subjects,
    ]);
}



}
