<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\FeeDeposit;
use App\Models\Student;

class FeeDepositController extends Controller
{
   public function index()
{
    $admin = auth('admin')->user();

    if (!$admin) {
        return redirect()->route('admin.login')->with('error', 'Please login to access fee management.');
    }

    $students = Student::with('feeDeposits')
                ->where('dice_code', $admin->dice_code)
                ->get();

    return view('admin.fees.deposit', compact('students', 'admin'));
}


    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_paid' => 'required|numeric|min:0',
            'late_fee' => 'nullable|numeric|min:0',
            'concession_amount' => 'nullable|numeric|min:0',
            'paid_on' => 'required|date',
            'payment_mode' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        FeeDeposit::create([
            'student_id' => $request->student_id,
            'amount_paid' => $request->amount_paid,
            'late_fee' => $request->late_fee ?? 0,
            'concession_amount' => $request->concession_amount ?? 0,
            'paid_on' => $request->paid_on,
            'payment_mode' => $request->payment_mode,
            'remarks' => $request->remarks,
        ]);

        return back()->with('success', 'Fee deposited successfully.');
    }

    public function getStudentFeeDetails($studentId)
    {
        $student = Student::findOrFail($studentId);
        
        $classCode = \DB::table('classes')
                      ->where('name', $student->admission_class)
                      ->value('code');

        $fee = Fee::where('dice_code', $student->dice_code)
                 ->where('class_code', $classCode)
                 ->where(function($query) use ($student) {
                     $query->where('stream', $student->stream)
                           ->orWhereNull('stream')
                           ->orWhere('stream', '');
                 })
                 ->orderByRaw("FIELD(stream, ?, '', NULL)", [$student->stream])
                 ->first();

        if (!$fee) {
            return response()->json(['error' => 'Fee structure not found'], 404);
        }

        $isRTE = strtoupper($student->category) === 'RTE';
        $totalFee = $fee->calculateTotalFee($isRTE);
        $totalPaid = $student->feeDeposits->sum('amount_paid');
        $pending = max(0, $totalFee - $totalPaid);

        return response()->json([
            'is_rte' => $isRTE,
            'fee_structure' => $fee,
            'total_fee' => $totalFee,
            'total_paid' => $totalPaid,
            'pending_amount' => $pending
        ]);
    }
    public function printSlip($id)
{
    $deposit = FeeDeposit::with('student')->findOrFail($id);
    return view('admin.fees.slip', compact('deposit'));
}

}