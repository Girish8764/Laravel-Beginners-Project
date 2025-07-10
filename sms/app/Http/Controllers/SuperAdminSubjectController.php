<?php

// app/Http/Controllers/SuperAdminSubjectController.php
namespace App\Http\Controllers;

use App\Models\GlobalSubject;
use Illuminate\Http\Request;
use App\Models\Classe;

class SuperAdminSubjectController extends Controller
{
    public function index()
    {
        $subjects = GlobalSubject::orderBy('class')->get();

        // Fetch distinct class names from `classes` table (not global_subjects)
        $classes = Classe::orderBy('id')->get();

        return view('superadmin.subjects.index', compact('subjects', 'classes'));
    }


    public function store(Request $request)
    {
        $request->validate([
        'class' => 'required',
        'stream' => 'required',
        'name' => 'required',
    ]);
        GlobalSubject::create([
            'class' => $request->class,
            'stream' => $request->stream,
            'name' => $request->name,
            'is_third_language' => $request->is_third_language ?? false,
        ]);
        return back()->with('success','Subject added successfully!');
    }

    public function destroy(GlobalSubject $subject)
    {
        $subject->delete();
        return back()->with('success','Subject removed');
    }
    // SuperAdminSubjectController.php
    public function getSubjects(Request $request)
    {
        $request->validate(['class' => 'required']);

        $query = GlobalSubject::where('class', $request->class);

        if ($request->filled('stream')) {
            $query->where('stream', $request->stream);
        }

        $subjects = $query->pluck('name')->unique()->values();

        return response()->json($subjects);
    }

}

