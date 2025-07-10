<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\AcademicSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::orderByDesc('created_at')->get();
        return view('superadmin.sessions.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:academic_sessions,name']);

        // If marked as active, set all others inactive
        // if ($request->is_active) {
        //     AcademicSession::where('is_active', true)->update(['is_active' => false]);
        // }

        AcademicSession::create([
            'name' => $request->name,
            // 'is_active' => $request->has('is_active')
        ]);

        return back()->with('success', 'Session added successfully!');
    }

    public function update(Request $request, $id)
    {
        $session = AcademicSession::findOrFail($id);

        $request->validate(['name' => 'required|unique:academic_sessions,name,' . $id]);

        // if ($request->is_active) {
        //     AcademicSession::where('is_active', true)->where('id', '!=', $id)->update(['is_active' => false]);
        // }

        $session->update([
            'name' => $request->name,
            
        ]);

        return back()->with('success', 'Session updated successfully!');
    }
    public function toggleStatus($id)
{
    $session = AcademicSession::findOrFail($id);

    if (!$session->is_active) {
        // Deactivate all others
        AcademicSession::where('is_active', true)->update(['is_active' => false]);
        $session->is_active = true;
    } else {
        $session->is_active = false;
    }

    $session->save();

    return back()->with('success', 'Session status updated.');
}

}
