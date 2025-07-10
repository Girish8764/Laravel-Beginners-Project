<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Subject;
use App\Models\GlobalSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSubjectController extends Controller
{
    // Display available and assigned subjects
    public function index(Request $request)
    {
        $dice_code = Auth::guard('admin')->user()->dice_code;

        // Step 1: Fetch Global Subjects (Available)
        $globalSubjectsQuery = GlobalSubject::query();

        if ($request->filled('class')) {
            $globalSubjectsQuery->where('class', $request->class);
        }
        if ($request->filled('stream')) {
            $globalSubjectsQuery->where('stream', $request->stream);
        }
        if ($request->filled('third_lang')) {
    $globalSubjectsQuery->where('is_third_language', (int) $request->third_lang);
}

        $globalSubjects = $globalSubjectsQuery->get();

        // Step 2: Fetch Admin Subjects (Already Assigned)
        $mySubjectsQuery = Subject::where('dice_code', $dice_code);

        if ($request->filled('class')) {
            $mySubjectsQuery->where('class', $request->class);
        }
        if ($request->filled('stream')) {
            $mySubjectsQuery->where('stream', $request->stream);
        }
        if ($request->filled('third_lang')) {
    $mySubjectsQuery->where('is_third_language', (int) $request->third_lang);
}

        $mySubjects = $mySubjectsQuery->get();

        // Step 3: Filter out already assigned from global subjects
        $available = $globalSubjects->filter(function ($subject) use ($mySubjects) {
            return !$mySubjects->contains(function ($my) use ($subject) {
                return $my->class === $subject->class &&
                       $my->stream === $subject->stream &&
                       $my->name === $subject->name;
            });
        });

        $classes = Classe::orderBy('id')->get();

        return view('admin.subjects.index', [
            'available' => $available,
            'mine' => $mySubjects,
            'classes' => $classes,
        ]);
    }

    // Assign multiple global subjects
    public function assignMultiple(Request $request)
    {
        $request->validate([
            'global_ids' => 'required|array',
            'global_ids.*' => 'exists:global_subjects,id',
        ]);

        $adminDice = auth('admin')->user()->dice_code;

        foreach ($request->global_ids as $id) {
            $gs = GlobalSubject::find($id);
            if (!$gs) continue;

            // Prevent overwriting existing records
            $exists = Subject::where([
                'dice_code' => $adminDice,
                'class' => $gs->class,
                'stream' => $gs->stream,
                'name' => $gs->name,
            ])->exists();

            if (!$exists) {
                Subject::create([
                    'dice_code' => $adminDice,
                    'class' => $gs->class,
                    'stream' => $gs->stream,
                    'name' => $gs->name,
                    'is_third_language' => (int) $gs->is_third_language,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Subjects assigned successfully.');
    }

    // Assign a single global subject
    public function assign(Request $request)
    {
        $request->validate([
            'global_id' => 'required|exists:global_subjects,id'
        ]);

        $gs = GlobalSubject::findOrFail($request->global_id);

        $adminDice = Auth::guard('admin')->user()->dice_code;

        // Prevent overwriting existing records
        $exists = Subject::where([
            'dice_code' => $adminDice,
            'class' => $gs->class,
            'stream' => $gs->stream,
            'name' => $gs->name,
        ])->exists();

        if (!$exists) {
            Subject::create([
                'dice_code' => $adminDice,
                'class' => $gs->class,
                'stream' => $gs->stream,
                'name' => $gs->name,
                'is_third_language' => (int) $gs->is_third_language,
            ]);
        }

        return back()->with('success', 'Subject assigned successfully.');
    }

    // Remove assigned subject
    public function remove(Subject $subject)
    {
        $subject->delete();
        return back()->with('success', 'Subject removed successfully.');
    }

    // AJAX: Fetch subjects by class (and optional stream)
    public function getSubjects(Request $request)
{
    $request->validate([
        'class' => 'required'
    ]);

    $query = Subject::where('dice_code', auth('admin')->user()->dice_code)
                    ->where('class', $request->class);

    // Handle stream (only if not empty string)
    if ($request->filled('stream') && $request->stream !== '') {
        $query->where('stream', $request->stream);
    }

    // Handle third_lang explicitly ('1' or '0' as string)
    if ($request->filled('third_lang')) {
    $query->where('is_third_language', (int) $request->third_lang);
}

    $subjects = $query->pluck('name')->unique()->values();

    return response()->json($subjects);
}

}
