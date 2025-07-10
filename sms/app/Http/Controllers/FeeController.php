<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class FeeController extends Controller
{
    public function index()
    {
        $fees = Fee::where('dice_code', auth('admin')->user()->dice_code)->get();
        $classes = DB::table('classes')->get();
        return view('admin.fees.index', compact('fees', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_code' => 'required',
            'stream' => 'nullable|string',
            'admission_fee' => 'numeric|min:0',
            'tuition_fee' => 'numeric|min:0',
            'rte_fee' => 'numeric|min:0',
            'late_fee' => 'numeric|min:0',
            'concession_amount' => 'numeric|min:0',
        ]);

        // Calculate total fee for regular students (admission + tuition + late fee - concession)
        $totalFee = $request->admission_fee + $request->tuition_fee + $request->late_fee - $request->concession_amount;

        Fee::updateOrCreate([
            'dice_code' => auth('admin')->user()->dice_code,
            'class_code' => $request->class_code,
            'stream' => $request->stream,
        ], [
            'admission_fee' => $request->admission_fee,
            'tuition_fee' => $request->tuition_fee,
            'rte_fee' => $request->rte_fee,
            'late_fee' => $request->late_fee ?? 0,
            'concession_amount' => $request->concession_amount ?? 0,
            'total_fee' => max(0, $totalFee), // Ensure total fee is not negative
        ]);

        return back()->with('success', 'Fee structure saved successfully.');
    }
}