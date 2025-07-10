<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Student;

class AdminDashboardController extends Controller
{
    // public function index()
    // {
    //     if (!Auth::guard('admin')->check()) {
    //         return redirect()->route('admin.login')->withErrors(['Access denied']);
    //     }

    //     $admin = Auth::guard('admin')->user();

    //     // Check if this admin is super admin (you must define this logic)
    //     $isSuperAdmin = $admin->is_super_admin ?? false; // or however you store it

    //     $totalAdmins = $isSuperAdmin ? Admin::count() : null;

    //     return view('admin.dashboard', compact('totalAdmins', 'isSuperAdmin'));
    // }
public function index()
{
    $admin = Auth::guard('admin')->user();
    $diceCode = $admin->dice_code;

    $studentsQuery = Student::where('dice_code', $diceCode);

    // Total counts
    $totalStudents = (clone $studentsQuery)->count();
    $totalBoys = (clone $studentsQuery)->where('gender', 'Boy')->count();
    $totalGirls = (clone $studentsQuery)->where('gender', 'Girl')->count();

    $boysPercent = $totalStudents > 0 ? round(($totalBoys / $totalStudents) * 100, 1) : 0;
    $girlsPercent = $totalStudents > 0 ? round(($totalGirls / $totalStudents) * 100, 1) : 0;

    // Category-wise counts
    $categories = ['SC', 'ST', 'OBC', 'GENERAL', 'MINORITY'];
    $categoryCounts = [];
    $categoryBoys = [];
    $categoryGirls = [];

    foreach ($categories as $cat) {
        $categoryCounts[$cat] = (clone $studentsQuery)->where('category', $cat)->count();
        $categoryBoys[$cat] = (clone $studentsQuery)->where('category', $cat)->where('gender', 'Boy')->count();
        $categoryGirls[$cat] = (clone $studentsQuery)->where('category', $cat)->where('gender', 'Girl')->count();
    }

    // Class-wise counts using display-friendly labels
    $classMap = [
        'LKG' => 'LKG',
        'UKG' => 'UKG',
        'Nursery' => 'Nursery',
        'First' => 'First',
        'Second' => 'Second',
        'Third' => 'Third',
        'Fourth' => 'Fourth',
        'Fifth' => 'Fifth',
        'Sixth' => 'Sixth',
        'Seventh' => 'Seventh',
        'Eighth' => 'Eighth',
        'Ninth' => 'Ninth',
        'Tenth' => 'Tenth',
        'Eleventh' => 'Eleventh',
        'Tweleth' => 'Tweleth',
    ];

    $classwiseData = [];
    foreach ($classMap as $dbValue => $label) {
        $boysCount = (clone $studentsQuery)->where('admission_class', $dbValue)->where('gender', 'Boy')->count();
        $girlsCount = (clone $studentsQuery)->where('admission_class', $dbValue)->where('gender', 'Girl')->count();

        $classwiseData[$label] = [
            'boys' => $boysCount,
            'girls' => $girlsCount,
        ];
    }

    // 🎯 Third Language Wise Count (e.g., Punjabi)
    $thirdLanguage = 'Punjabi';
    $targetClasses = ['6', '7', '8', '9', '10', '11', '12'];

    $thirdLanguageSummary = [];
    foreach ($targetClasses as $class) {
        $studentsInClass = Student::where('dice_code', $diceCode)
            ->where('admission_class', $class)
            ->where('third', $thirdLanguage);

        $total = (clone $studentsInClass)->count();
        $boys = (clone $studentsInClass)->where('gender', 'Boy')->count();
        $girls = (clone $studentsInClass)->where('gender', 'Girl')->count();

        $thirdLanguageSummary[$class] = [
            'total' => $total,
            'boys' => $boys,
            'girls' => $girls,
        ];
    }

    // 📌 Religion-wise Summary
    $religions = ['Hindu', 'Muslim', 'Sikh'];
    $religionSummary = [];

    foreach (array_keys($classMap) as $dbClass) {
        $row = [];

        foreach ($religions as $religion) {
            $total = Student::where('dice_code', $diceCode)
                ->where('admission_class', $dbClass)
                ->where('religion', $religion)
                ->count();

            $boys = Student::where('dice_code', $diceCode)
                ->where('admission_class', $dbClass)
                ->where('religion', $religion)
                ->where('gender', 'Boy')
                ->count();

            $girls = Student::where('dice_code', $diceCode)
                ->where('admission_class', $dbClass)
                ->where('religion', $religion)
                ->where('gender', 'Girl')
                ->count();

            $row[$religion] = [
                'total' => $total,
                'boys' => $boys,
                'girls' => $girls,
            ];
        }

        $religionSummary[$dbClass] = $row;
    }

    return view('admin.dashboard', compact(
        'totalStudents',
        'totalBoys',
        'totalGirls',
        'boysPercent',
        'girlsPercent',
        'categoryCounts',
        'categoryBoys',
        'categoryGirls',
        'classwiseData',
        'thirdLanguageSummary',
        'religionSummary'
    ));
}



}
