<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Subject;
use App\Models\ExamTimetable;
use Auth;

class ExamTimetableController extends Controller
{
    public function index()
    {
        $classes = Classe::all();
        $examTypes = ['First Term', 'Second Term', 'Third Term', 'Fourth Term', 'Fifth Term', 'Half Yearly', 'Final'];
        $timetables = ExamTimetable::where('dice_code', auth('admin')->user()->dice_code)->get();
        return view('admin.exam_timetable.index', compact('classes', 'examTypes', 'timetables'));
    }

    public function getStreams(Request $request)
    {
        $streams = Subject::where('class', $request->class)
                    ->where('dice_code', auth('admin')->user()->dice_code)
                    ->pluck('stream')->unique()->values();
        return response()->json($streams);
    }

    public function getSubjects(Request $request)
    {
        $subjects = Subject::where('class', $request->class)
                    ->where('stream', $request->stream)
                    ->where('dice_code', auth('admin')->user()->dice_code)
                    ->pluck('name');
        return response()->json($subjects);
    }

    public function getExamTypes(Request $request)
    {
        $examTypes = ExamTimetable::where('class', $request->class)
                    ->where('stream', $request->stream)
                    ->where('dice_code', auth('admin')->user()->dice_code)
                    ->pluck('exam_type')->unique()->values();
        return response()->json($examTypes);
    }

    public function getDatesheetEntries(Request $request)
    {
        $entries = ExamTimetable::where('class', $request->class)
                    ->where('stream', $request->stream)
                    ->where('exam_type', $request->exam_type)
                    ->where('dice_code', auth('admin')->user()->dice_code)
                    ->get();
        return response()->json($entries);
    }

    public function store(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'stream' => 'nullable',
            'subject' => 'required',
            'exam_type' => 'required',
            'exam_date' => 'required|date',
            'shift' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        ExamTimetable::create([
            'dice_code' => auth('admin')->user()->dice_code,
            'class' => $request->class,
            'stream' => $request->stream,
            'subject' => $request->subject,
            'exam_type' => $request->exam_type,
            'exam_date' => $request->exam_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Exam schedule added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'exam_type' => 'required',
            'exam_date' => 'required|date',
            'shift' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $exam = ExamTimetable::findOrFail($id);
        $exam->update([
            'exam_type' => $request->exam_type,
            'exam_date' => $request->exam_date,
            'shift' => $request->shift,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Exam schedule updated successfully.');
    }

    public function destroy($id)
    {
        ExamTimetable::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Exam schedule deleted.');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'stream' => 'required',
            'exam_type' => 'required',
            'subjects' => 'required|array',
            'exam_dates' => 'required|array',
            'shifts' => 'required|array',
            'start_times' => 'required|array',
            'end_times' => 'required|array',
        ]);

        // Check if datesheet already exists for this class, stream, and exam type
        $existingCount = ExamTimetable::where('class', $request->class)
                        ->where('stream', $request->stream)
                        ->where('exam_type', $request->exam_type)
                        ->where('dice_code', auth('admin')->user()->dice_code)
                        ->count();

        if ($existingCount > 0) {
            return back()->with('error', 'Datesheet already exists for this class, stream, and exam type. Please use the Edit Datesheet option instead.');
        }

        foreach ($request->subjects as $i => $subject) {
            ExamTimetable::create([
                'class' => $request->class,
                'stream' => $request->stream,
                'subject' => $subject,
                'exam_type' => $request->exam_type,
                'exam_date' => $request->exam_dates[$i],
                'shift' => $request->shifts[$i],
                'start_time' => $request->start_times[$i],
                'end_time' => $request->end_times[$i],
                'dice_code' => auth('admin')->user()->dice_code,
            ]);
        }

        return back()->with('success', 'Exam datesheet created successfully for ' . $request->class . ' - ' . $request->stream . ' (' . $request->exam_type . ').');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'class' => 'required',
            'stream' => 'required',
            'exam_type' => 'required',
            'exam_ids' => 'required|array',
            'subjects' => 'required|array',
            'exam_dates' => 'required|array',
            'shifts' => 'required|array',
            'start_times' => 'required|array',
            'end_times' => 'required|array',
        ]);

        foreach ($request->exam_ids as $i => $examId) {
            $exam = ExamTimetable::where('id', $examId)
                    ->where('dice_code', auth('admin')->user()->dice_code)
                    ->first();
                    
            if ($exam) {
                $exam->update([
                    'exam_date' => $request->exam_dates[$i],
                    'shift' => $request->shifts[$i],
                    'start_time' => $request->start_times[$i],
                    'end_time' => $request->end_times[$i],
                ]);
            }
        }

        return back()->with('success', 'Datesheet updated successfully for ' . $request->class . ' - ' . $request->stream . ' (' . $request->exam_type . ').');
    }
public function getClassWiseView(Request $request) {
    $query = ExamTimetable::where('dice_code', auth('admin')->user()->dice_code);

    if ($request->class) $query->where('class', $request->class);
    if ($request->stream) $query->where('stream', $request->stream);
    if ($request->exam_type) $query->where('exam_type', $request->exam_type);

    $exams = $query->orderBy('exam_date')->orderBy('shift')->get();

    $grouped = $exams->groupBy(['class', 'stream', 'exam_type']);

    return response()->json($grouped);
}


public function getDateWiseView(Request $request) {
    $query = ExamTimetable::where('dice_code', auth('admin')->user()->dice_code);

    if ($request->class) $query->where('class', $request->class);
    if ($request->stream) $query->where('stream', $request->stream);
    if ($request->exam_type) $query->where('exam_type', $request->exam_type);

    $exams = $query->orderBy('exam_date')->orderBy('shift')->get();

    $grouped = $exams->groupBy(['exam_date', 'shift']);

    return response()->json($grouped);
}

}