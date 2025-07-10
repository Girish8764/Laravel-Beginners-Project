<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Staff;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function pricing()
    {
        $plans = PricingPlan::all();
        $totalSchools = Admin::count();
        $totalStudents = Student::count();
        $totalStaff = Staff::count();

        // First created_at entries
        $firstSchool = Admin::min('created_at');
        $firstStudent = Student::min('created_at');
        $firstStaff = Staff::min('created_at');

        // Calculate number of months (inclusive)
        $schoolMonths = $firstSchool ? Carbon::parse($firstSchool)->diffInMonths(now()) + 1 : 1;
        $studentMonths = $firstStudent ? Carbon::parse($firstStudent)->diffInMonths(now()) + 1 : 1;
        $staffMonths = $firstStaff ? Carbon::parse($firstStaff)->diffInMonths(now()) + 1 : 1;

        // Monthly averages
        $monthlySchoolAvg = round($totalSchools / $schoolMonths);
        $monthlyStudentAvg = round($totalStudents / $studentMonths);
        $monthlyStaffAvg = round($totalStaff / $staffMonths);
        return view('index', compact('plans','totalSchools', 'totalStudents', 'totalStaff',
        'monthlySchoolAvg', 'monthlyStudentAvg', 'monthlyStaffAvg'));
    }
}
