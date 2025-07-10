<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminAuthController,
    AdminDashboardController,
    SuperAdminController,
    StudentController,
    StaffController,
    ClassTeacherController,
    TeacherSubjectController,
    AdminProfileController,
    LocationController,
    FeeController,
    FeeDepositController,
    ExamTimetableController,
    SuperAdminSubjectController,
    AdminSubjectController,
    Superadmin\SessionController,
    FrontendController,
    AdmitCardController,
    ContactController,
};
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Superadmin\{
    ManageAdminController,
    SuperadminDashboardController,
    PricingPlanController
};

// 🔓 Public Pages
Route::get('/', [FrontendController::class, 'pricing'])->name('frontend.pricing');
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::get('/signup', fn() => view('signup'));
Route::get('/admin/register', [AdminAuthController::class, 'showRegister'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

// Super Admin Login
Route::get('/superadmin/login', [LoginController::class, 'showSuperAdminLogin'])->name('superadmin.login');
Route::post('/superadmin/login', [LoginController::class, 'superAdminLoginSubmit'])->name('superadmin.login.submit');

// OTP Routes
Route::post('/send-email-otp', [LoginController::class, 'sendEmailOtp'])->name('send.email.otp');
Route::post('/verify-email-otp', [LoginController::class, 'verifyEmailOtp'])->name('verify.email.otp');

// Contact Form Submission (public)
Route::post('/contact', [ContactController::class, 'store']);

// Admin Login & Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🔐 Authenticated Admin Routes
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Student Management
    Route::get('/students', [StudentController::class, 'index'])->name('admin.students.index');
    Route::post('/students/upload', [StudentController::class, 'bulkUpload'])->name('admin.students.upload');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('admin.students.edit');
    Route::post('/student/update', [StudentController::class, 'update'])->name('student.update');
    Route::post('/students/generate-roll', [StudentController::class, 'generateRollNumbers'])->name('students.roll.generate');

    // Staff
    Route::get('/staff', [StaffController::class, 'index'])->name('admin.staff.index');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::post('/staff/update', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/teacher/status/{id}', [StaffController::class, 'changeStatus'])->name('teacher.status');

    // Teacher Class
    Route::resource('teacher-class', ClassTeacherController::class)->only(['index', 'store', 'destroy']);
    Route::post('teacher-class/update', [ClassTeacherController::class, 'update'])->name('teacher-class.update');

    // Teacher Subject
    Route::resource('teacher-subject', TeacherSubjectController::class)->only(['index', 'store', 'destroy']);
    Route::post('/fetch-streams-subjects', [TeacherSubjectController::class, 'getStreamsAndSubjects'])->name('admin.get.streams-subjects');

    // Profile & Password
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::put('/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.change.password');

    // Location
    Route::get('/get-districts', [LocationController::class, 'getDistricts'])->name('admin.get.districts');

    // Fees
    Route::get('fees', [FeeController::class, 'index'])->name('admin.fees.index');
    Route::post('fees/store', [FeeController::class, 'store'])->name('admin.fees.store');
    Route::get('fees/deposit', [FeeDepositController::class, 'index'])->name('admin.fees.deposit.index');
    Route::post('fees/deposit/store', [FeeDepositController::class, 'store'])->name('admin.fees.deposit.store');
    Route::get('fees/student-details/{student}', [FeeDepositController::class, 'getStudentFeeDetails'])->name('admin.fees.student.details');
    Route::get('fees/slip-installment/{id}', [FeeDepositController::class, 'printSlip']);

    // Exam Timetable
    Route::get('/exam-timetable', [ExamTimetableController::class, 'index'])->name('exam.timetable.index');
    Route::post('/exam-timetable/store', [ExamTimetableController::class, 'store'])->name('exam.timetable.store');
    Route::post('/exam-timetable/bulk-store', [ExamTimetableController::class, 'bulkStore'])->name('exam.timetable.bulkStore');
    Route::put('/exam-timetable/update/{id}', [ExamTimetableController::class, 'update'])->name('exam.timetable.update');
    Route::put('/exam-timetable/bulk-update', [ExamTimetableController::class, 'bulkUpdate'])->name('exam.timetable.bulkUpdate');
    Route::delete('/exam-timetable/delete/{id}', [ExamTimetableController::class, 'destroy']);
    Route::post('/exam-timetable/get-streams', [ExamTimetableController::class, 'getStreams']);
    Route::post('/exam-timetable/get-subjects', [ExamTimetableController::class, 'getSubjects']);
    Route::post('/exam-timetable/get-exam-types', [ExamTimetableController::class, 'getExamTypes']);
    Route::post('/exam-timetable/get-datesheet-entries', [ExamTimetableController::class, 'getDatesheetEntries']);
    Route::post('/exam-timetable/get-class-wise-view', [ExamTimetableController::class, 'getClassWiseView']);
    Route::post('/exam-timetable/get-date-wise-view', [ExamTimetableController::class, 'getDateWiseView']);

    // Subjects
    Route::get('/subjects', [AdminSubjectController::class, 'index']);
    Route::post('/subjects/assign-multiple', [AdminSubjectController::class, 'assignMultiple']);
    Route::delete('/subjects/{subject}', [AdminSubjectController::class, 'remove']);
    Route::post('/get-subjects', [AdminSubjectController::class, 'getSubjects']);

    // Admit Card
    Route::get('/admit-card', [AdmitCardController::class, 'index'])->name('admin.admit-card.index');
    Route::get('/admit-card/canvas/{id}', [AdmitCardController::class, 'canvas'])->name('admin.admit-card.canvas');
    Route::get('/admit-card/print/{id}', [AdmitCardController::class, 'print'])->name('admin.admit-card.print');
    Route::get('/admit-card/schedule/{studentId}', [AdmitCardController::class, 'getExamSchedule']);
});

// 🔐 Authenticated Super Admin Routes
Route::prefix('superadmin')->middleware(['auth:superadmin'])->group(function () {
    Route::get('/dashboard', [SuperadminDashboardController::class, 'index'])->name('superadmin.dashboard');

    // Manage Admins
    Route::get('/manage-admin', [ManageAdminController::class, 'index'])->name('superadmin.manageadmin');
    Route::post('/toggle-admin/{id}', [ManageAdminController::class, 'toggleStatus'])->name('superadmin.admins.toggle');

    // Subjects
    Route::get('/subjects', [SuperAdminSubjectController::class, 'index']);
    Route::post('/subjects', [SuperAdminSubjectController::class, 'store']);
    Route::delete('/subjects/{subject}', [SuperAdminSubjectController::class, 'destroy']);
    Route::post('/get-subjects', [SuperAdminSubjectController::class, 'getSubjects']);

    // Sessions
    Route::get('/sessions', [SessionController::class, 'index'])->name('sessions.index');
    Route::post('/sessions', [SessionController::class, 'store'])->name('sessions.store');
    Route::put('/sessions/{id}', [SessionController::class, 'update'])->name('sessions.update');
    Route::post('/sessions/{id}/toggle', [SessionController::class, 'toggleStatus'])->name('sessions.toggle');

    // Pricing Plans
    Route::resource('/pricing-plans', PricingPlanController::class);
    Route::post('/pricing-plans/{id}/toggle-featured', [PricingPlanController::class, 'toggleFeatured'])->name('pricing-plans.toggle-featured');

    // Staff & Students
    Route::get('/staff', [SuperAdminController::class, 'showStaffBySchool'])->name('superadmin.staff.index');
    Route::get('/students', [SuperAdminController::class, 'index1'])->name('superadmin.students.index');

    // Contact Messages
    Route::get('/contacts', [ContactController::class, 'index'])->name('superadmin.contacts');
});
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::resource('teacher-class', TeacherClassController::class);
});
Route::get('/teacher-subjects', [TeacherSubjectController::class, 'index'])->name('admin.teacher-subject.index');

Route::post('/student/admission', [StudentController::class, 'storeAdmission'])
     ->name('student.admission.store');



     

// File: routes/web.php (Add these routes to your existing routes file)

// use App\Http\Controllers\IdCardController;
// Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
//     // ID Card Template Management
//     Route::get('/id-cards', [IdCardController::class, 'index'])->name('id-cards.index');
//     Route::get('/id-cards/designer', [IdCardController::class, 'designer'])->name('id-cards.designer');
//     Route::post('/id-cards/save-template', [IdCardController::class, 'saveTemplate'])->name('id-cards.save-template');
//     Route::get('/id-cards/edit/{id}', [IdCardController::class, 'edit'])->name('id-cards.edit');
//     Route::put('/id-cards/update/{id}', [IdCardController::class, 'update'])->name('id-cards.update');
//     Route::delete('/id-cards/delete/{id}', [IdCardController::class, 'destroy'])->name('id-cards.destroy');
//     Route::post('/id-cards/toggle-status/{id}', [IdCardController::class, 'toggleStatus'])->name('id-cards.toggle-status');

//     // ID Card Generation
//     Route::get('/id-cards/generate', [IdCardController::class, 'generate'])->name('id-cards.generate');
//     Route::get('/id-cards/get-students', [IdCardController::class, 'getStudents'])->name('id-cards.get-students');
//     Route::get('/id-cards/get-staff', [IdCardController::class, 'getStaff'])->name('id-cards.get-staff');
//     // routes/web.php
// Route::post('admin/id-cards/generate-cards', [IdCardController::class, 'generateCards'])->name('id-cards.generate-cards');
// Route::get('/id-cards/debug', [IdCardController::class, 'debug'])->name('id-cards.debug');
// Route::post('/id-cards/generate', [IdCardController::class, 'generateCards'])->name('id-cards.generate');
    
// });


// routes/web.php

use App\Http\Controllers\IDCardController;

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('id-cards', [IDCardController::class, 'index'])->name('id-cards.index');
    Route::post('generate-id-cards', [IDCardController::class, 'generate'])->name('id-cards.generate');
});
