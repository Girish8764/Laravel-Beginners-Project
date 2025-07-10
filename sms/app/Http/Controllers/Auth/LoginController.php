<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailOTP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:school,teacher,student',
            'dice_code' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $role = $request->role;
        $dice_code = $request->dice_code;

        $guard = match ($role) {
            'school' => 'admin',
            'teacher' => 'teacher',
            'student' => 'student',
        };

        $model = match ($role) {
            'school' => \App\Models\Admin::class,
            'teacher' => \App\Models\Staff::class,
            'student' => \App\Models\Student::class,
        };

        $user = $model::where('email', $request->email)
            ->where('dice_code', $dice_code)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Invalid login credentials.']);
        }

        if ($role === 'school' && !$user->is_active) {
            return back()->withErrors(['email' => 'Your ID is Inactive, Please contact Administrator.']);
        }
        if ($role === 'teacher' && $user->status != 1) {
            return back()->withErrors(['email' => 'Your ID is Inactive, Please contact Administrator.']);
        }

        $credentials['dice_code'] = $dice_code;

        if (Auth::guard($guard)->attempt($credentials)) {
            $request->session()->regenerate();

            return match ($role) {
                'school' => redirect()->route('admin.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'student' => redirect()->route('student.dashboard'),
            };
        }

        return back()->withErrors(['email' => 'Invalid login credentials.']);
    }


    public function logout(Request $request)
    {
        $role = $request->input('role', 'school');

        $guard = match ($role) {
            'school' => 'admin',
            'teacher' => 'teacher',
            'student' => 'student',
        };

        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function showSuperAdminLogin()
    {
        return view('superadmin.login');
    }
    public function superAdminLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('superadmin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('superadmin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid super admin credentials.']);
    }
    public function sendEmailOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'role' => 'required|in:school,teacher,student',
                'dice_code' => 'required|string',
            ]);

            $otp = rand(100000, 999999);

            \App\Models\EmailOTP::create([
                'email' => $request->email,
                'otp' => $otp,
                'role' => $request->role,
                'dice_code' => $request->dice_code,
                'expires_at' => now()->addMinutes(1),
            ]);

            \Mail::raw("Your SchoolDiGi login OTP is: $otp", function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('SchoolDiGi Login OTP');
            });

            return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() // ❗ Show actual error
            ]);
        }
    }

    // Verify OTP
    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required',
            'role' => 'required|in:school,teacher,student',
            'dice_code' => 'required|string',
        ]);

        $record = EmailOTP::where('email', $request->email)
            ->where('role', $request->role)
            ->where('dice_code', $request->dice_code)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Invalid or expired OTP']);
        }

        $model = match ($request->role) {
            'school' => \App\Models\Admin::class,
            'teacher' => \App\Models\Staff::class,
            'student' => \App\Models\Student::class,
        };

        $user = $model::where('email', $request->email)
            ->where('dice_code', $request->dice_code)
            ->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        // Extra check
        if ($request->role === 'school' && !$user->is_active) {
            return response()->json(['success' => false, 'message' => 'Your ID is inactive']);
        }
        if ($request->role === 'teacher' && $user->status != 1) {
            return response()->json(['success' => false, 'message' => 'Your ID is inactive']);
        }

        $guard = match ($request->role) {
            'school' => 'admin',
            'teacher' => 'teacher',
            'student' => 'student',
        };

        Auth::guard($guard)->login($user);
        $request->session()->regenerate();

        $redirect = match ($request->role) {
            'school' => route('admin.dashboard'),
            'teacher' => route('teacher.dashboard'),
            'student' => route('student.dashboard'),
        };

        return response()->json(['success' => true, 'redirect' => $redirect]);
    }
}
