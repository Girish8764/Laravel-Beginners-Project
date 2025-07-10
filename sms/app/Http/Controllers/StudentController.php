<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader; 
use App\Models\Classe;

class StudentController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        $diceCode = $admin->dice_code;

        $students = Student::where('dice_code', $diceCode)
                    ->orderByDesc('id')
                    ->get();

        // 🟢 Fetch classes for the dropdown
        $classes = Classe::orderBy('id')->get();

        return view('admin.student', compact('students', 'classes'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'sr_no' => 'required|string|max:10',
            'admission_date' => 'nullable|date',
            'admission_class' => 'required|string|max:25',
            'student_name' => 'required|string|max:100',
            'father_name' => 'nullable|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'required|string|max:10',
            'mobile' => 'nullable|string|max:11',
            'category' => 'required|string|max:20',
            'caste' => 'nullable|string|max:50',
            'stream' => 'required|string|max:20',
            // 'email' => 'nullable|email|max:100|unique:students,email',
            // 'password' => 'nullable|string|min:6',
        ]);

        // Hash password if included (currently disabled)
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        // ✅ Get current admin's dice_code
        $admin = Auth::guard('admin')->user();
        $diceCode = $admin->dice_code;

         // 🟢 Resolve class display name
        $class = Classe::where('code', $validated['admission_class'])->first();
        $className = $class ? $class->name : $validated['admission_class']; // fallback if not found

        // ✅ Store student with admin’s dice_code and current date
        Student::create([
            ...$validated,
            'admission_class' => $className,
            'dice_code' => $diceCode,
            'date' => now(), // Or change to your custom logic if needed
        ]);

        return back()->with('success', 'Student admitted successfully!');
    }


    public function bulkUpload(Request $request)
    {
        $request->validate([
            'students_csv' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('students_csv')->getRealPath();

        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // First row as header

        $records = $csv->getRecords();

        $admin = Auth::guard('admin')->user(); // ✅ Get admin info
        $diceCode = $admin->dice_code;

        foreach ($records as $record) {
            Student::updateOrCreate(
                ['sr_no' => $record['Admission / SR No.'] ?? null],
                [
                    'dice_code' => $diceCode, // ✅ Store admin’s dice code here
                    'student_name' => $record['Student Name'] ?? null,
                    'father_name' => $record['Father Name'] ?? null,
                    'mother_name' => $record['Mother Name'] ?? null,
                    'admission_class' => $record['Class'] ?? null,
                    'medium' => $record['Medium'] ?? null,
                    'caste' => $record['Caste'] ?? null,
                    'gender' => $record['Gender'] ?? null,
                    'dob' => $record['DOB'] ?? null,
                    'religion' => $record['Religion'] ?? null,
                    'stream' => $record['Stream'] ?? null,
                    'third' => $record['Third Language'] ?? null,
                    'mobile' => $record['Mobile'] ?? null,
                    'jan_aadhar' => $record['Jan Aadhar'] ?? null,
                    'aadhar' => $record['Aadhar'] ?? null,
                    'rte' => $record['RTE/Non RTE'] ?? null,
                    'admission_date' => now(),
                ]
            );
        }

        return back()->with('success', 'Students uploaded successfully!');
    }
    public function edit($id)
{
    $student = Student::findOrFail($id);
    return view('admin.students.edit', compact('student'));
}
public function update(Request $request)
{
    $student = Student::findOrFail($request->id);

    $student->update([
        'img' => $request->img,
        'rollno' => $request->rollno,
        'b_rollno' => $request->b_rollno,
        'sr_no' => $request->sr_no,
        'admission_date' => $request->admission_date,
        'admission_class' => $request->admission_class,
        'stream' => $request->stream,
        'section' => $request->section,
        'medium' => $request->medium,
        'subject1' => $request->subject1,
        'subject2' => $request->subject2,
        'subject3' => $request->subject3,
        'subject4' => $request->subject4,
        'subject5' => $request->subject5,
        'subject6' => $request->subject6,
        'subject7' => $request->subject7,
        'subject8' => $request->subject8,
        'subject9' => $request->subject9,
        'third' => $request->third,
        'student_name' => $request->student_name,
        'father_name' => $request->father_name,
        'mother_name' => $request->mother_name,
        'grand_father' => $request->grand_father,
        'g_age' => $request->g_age,
        'dob' => $request->dob,
        'gender' => $request->gender,
        'caste' => $request->caste,
        'category' => $request->category,
        'religion' => $request->religion,
        'aadhar' => $request->aadhar,
        'jan_aadhar' => $request->jan_aadhar,
        'pan_no' => $request->pan_no,
        'f_aadhar' => $request->f_aadhar,
        'f_dob' => $request->f_dob,
        'f_place' => $request->f_place,
        'gmail' => $request->gmail,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'address' => $request->address,
        'district' => $request->district,
        'tehsil' => $request->tehsil,
        'gram' => $request->gram,
        'occupation' => $request->occupation,
        'income' => $request->income,
        'rte' => $request->rte,
        'class1' => $request->class1,
        'year1' => $request->year1,
        'old_rollno1' => $request->old_rollno1,
        'old_result1' => $request->old_result1,
        'old_board1' => $request->old_board1,
        'class2' => $request->class2,
        'year2' => $request->year2,
        'old_rollno2' => $request->old_rollno2,
        'old_result2' => $request->old_result2,
        'old_board2' => $request->old_board2,
        'class3' => $request->class3,
        'year3' => $request->year3,
        'old_rollno3' => $request->old_rollno3,
        'old_result3' => $request->old_result3,
        'old_board3' => $request->old_board3,
        'father_mother_aadhar' => $request->father_mother_aadhar,
        'labour_card' => $request->labour_card,
        'labour_no' => $request->labour_no,
        'labour_date' => $request->labour_date,
        'validity_date' => $request->validity_date,
        'officer_issuing' => $request->officer_issuing,
        'session' => $request->session,
    ]);

    return back()->with('success', 'Student updated successfully!');
}



public function generateRollNumbers(Request $request)
{
    $validated = $request->validate([
        'admission_class' => 'required|string',
        'stream' => 'nullable|string',
        'rollno' => 'required|integer|min:1',
    ]);

    $admin = Auth::guard('admin')->user();
    $diceCode = $admin->dice_code;

    // Get students without roll numbers (to assign new ones)
    $studentsWithoutRoll = Student::where('admission_class', $validated['admission_class'])
        ->when($validated['stream'], fn($q) => $q->where('stream', $validated['stream']))
        ->where('dice_code', $diceCode)
        ->whereNull('rollno')
        ->orderByRaw('LOWER(student_name)')
        ->get();

    $rollStart = $validated['rollno'];
    $rollEnd = $rollStart + $studentsWithoutRoll->count() - 1;

    // Check for any overlap with existing roll numbers
    $conflictingRolls = Student::where('admission_class', $validated['admission_class'])
        ->when($validated['stream'], fn($q) => $q->where('stream', $validated['stream']))
        ->where('dice_code', $diceCode)
        ->whereBetween('rollno', [$rollStart, $rollEnd])
        ->pluck('rollno')
        ->toArray();

    if (count($conflictingRolls)) {
        return back()->with('error', 'Roll numbers from ' . $rollStart . ' to ' . $rollEnd . ' already include assigned numbers: ' . implode(', ', $conflictingRolls));
    }

    // No conflict, assign roll numbers
    $rollNo = $rollStart;
    foreach ($studentsWithoutRoll as $student) {
        $student->rollno = $rollNo++;
        $student->save();
    }

    return back()->with('success', 'Roll numbers generated successfully from ' . $rollStart . ' to ' . $rollEnd . '.');
}





}
