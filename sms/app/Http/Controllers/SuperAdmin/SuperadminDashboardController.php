<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;

class SuperadminDashboardController extends Controller
{
    public function index()
    {
        // All students
        $totalStudents = Student::count();
        $totalBoys = Student::where('gender', 'Boy')->count();
        $totalGirls = Student::where('gender', 'Girl')->count();

        $boysPercent = $totalStudents > 0 ? round(($totalBoys / $totalStudents) * 100, 1) : 0;
        $girlsPercent = $totalStudents > 0 ? round(($totalGirls / $totalStudents) * 100, 1) : 0;

        // Admin count
        $totalAdmins = Admin::count();

        // Category-wise stats
        $categories = ['SC', 'ST', 'OBC', 'GENERAL', 'MINORITY'];
        $categoryBoys = [];
        $categoryGirls = [];

        foreach ($categories as $cat) {
            $categoryBoys[$cat] = Student::where('category', $cat)->where('gender', 'Boy')->count();
            $categoryGirls[$cat] = Student::where('category', $cat)->where('gender', 'Girl')->count();
        }

        // Class-wise summary
        $classMap = [
            'LKG', 'UKG', 'Nursery', 'First', 'Second', 'Third', 'Fourth', 'Fifth',
            'Sixth', 'Seventh', 'Eighth', 'Ninth', 'Tenth', 'Eleventh', 'Tweleth'
        ];

        $classwiseData = [];
        foreach ($classMap as $class) {
            $boys = Student::where('admission_class', $class)->where('gender', 'Boy')->count();
            $girls = Student::where('admission_class', $class)->where('gender', 'Girl')->count();
            $classwiseData[$class] = ['boys' => $boys, 'girls' => $girls];
        }

        // Third Language-wise (Punjabi example)
        $thirdLanguage = 'Punjabi';
        $targetClasses = ['6', '7', '8', '9', '10', '11', '12'];
        $thirdLanguageSummary = [];

        foreach ($targetClasses as $class) {
            $query = Student::where('admission_class', $class)->where('third', $thirdLanguage);
            $thirdLanguageSummary[$class] = [
                'total' => $query->count(),
                'boys' => (clone $query)->where('gender', 'Boy')->count(),
                'girls' => (clone $query)->where('gender', 'Girl')->count(),
            ];
        }

        // Religion-wise summary
        $religions = ['Hindu', 'Muslim', 'Sikh'];
        $religionSummary = [];

        foreach ($classMap as $class) {
            $row = [];
            foreach ($religions as $religion) {
                $query = Student::where('admission_class', $class)->where('religion', $religion);
                $row[$religion] = [
                    'total' => $query->count(),
                    'boys' => (clone $query)->where('gender', 'Boy')->count(),
                    'girls' => (clone $query)->where('gender', 'Girl')->count(),
                ];
            }
            $religionSummary[$class] = $row;
        }

        return view('superadmin.dashboard', compact(
            'totalStudents',
            'totalBoys',
            'totalGirls',
            'boysPercent',
            'girlsPercent',
            'totalAdmins',
            'categoryBoys',
            'categoryGirls',
            'classwiseData',
            'thirdLanguageSummary',
            'religionSummary'
        ));
    }
}
