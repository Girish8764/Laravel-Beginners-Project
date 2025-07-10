<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\Student;
use App\Models\ExamTimetable;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class AdmitCardController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classe::all();
        $students = [];
        $admin = auth('admin')->user();

        if ($request->filled('class') && $request->filled('stream')) {
            $students = Student::where('admission_class', $request->class)
                ->where('stream', $request->stream)
                ->where('dice_code', auth('admin')->user()->dice_code)
                ->get();
        }

        return view('admin.admit_card.index', compact('classes', 'students', 'admin','request'));
    }

    public function getExamSchedule($studentId)
    {
        try {
            // Validate student exists and belongs to current admin
            $student = Student::where('id', $studentId)
                ->where('dice_code', auth('admin')->user()->dice_code)
                ->first();

            if (!$student) {
                return response()->json([
                    'error' => 'Student not found or access denied'
                ], 404);
            }

            $examSchedule = ExamTimetable::where('class', $student->admission_class)
                ->where('stream', $student->stream)
                ->where('dice_code', $student->dice_code)
                ->orderBy('exam_date')
                ->orderByRaw("FIELD(shift, 'Morning', 'Evening')")
                ->get()
                ->map(function($exam) {
                    // Ensure all required fields are present
                    return [
                        'id' => $exam->id,
                        'subject' => $exam->subject ?? 'N/A',
                        'exam_date' => $exam->exam_date ?? date('Y-m-d'),
                        'start_time' => $exam->start_time ?? '09:00:00',
                        'end_time' => $exam->end_time ?? '12:00:00',
                        'shift' => $exam->shift ?? 'Morning',
                        'class' => $exam->class,
                        'stream' => $exam->stream
                    ];
                });

            return response()->json($examSchedule);

        } catch (\Exception $e) {
            Log::error('Error fetching exam schedule: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to load exam schedule',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function print($id)
    {
        try {
            $student = Student::where('id', $id)
                ->where('dice_code', auth('admin')->user()->dice_code)
                ->firstOrFail();
                
            $admin = auth('admin')->user();

            $examSchedule = ExamTimetable::where('class', $student->admission_class)
                ->where('stream', $student->stream)
                ->where('dice_code', $student->dice_code)
                ->orderBy('exam_date')
                ->orderByRaw("FIELD(shift, 'Morning', 'Evening')")
                ->get();

            return view('admin.admit_card.print', compact('student', 'examSchedule', 'admin'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Student not found or access denied');
        }
    }

    public function canvas($id)
{
    $student = Student::where('id', $id)
        ->where('dice_code', auth('admin')->user()->dice_code)
        ->firstOrFail();

    $admin = auth('admin')->user();

    $examSchedule = ExamTimetable::where('class', $student->admission_class)
        ->where('stream', $student->stream)
        ->where('dice_code', $student->dice_code)
        ->orderBy('exam_date')
        ->orderByRaw("FIELD(shift, 'Morning', 'Evening')")
        ->get();

    return view('admin.admit_card.canvas', compact('student', 'examSchedule', 'admin'));
}

}