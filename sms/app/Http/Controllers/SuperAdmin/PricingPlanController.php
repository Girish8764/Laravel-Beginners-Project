<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingPlan;

class PricingPlanController extends Controller
{
    public function index()
    {
        $plans = PricingPlan::all();
        return view('superadmin.pricing.index', compact('plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'nullable|string',
            'title' => 'nullable|string|max:255'
        ]);

        // Process features - convert textarea input to array
        $features = [];
        if ($request->features) {
            $features = array_filter(
                array_map('trim', explode("\n", $request->features)),
                function($feature) {
                    return !empty($feature);
                }
            );
        }

        try {
            PricingPlan::create([
                'title' => $request->title,
                'price' => $request->price,
                'duration' => $request->duration,
                'features' => $features,
                'is_featured' => $request->has('is_featured')
            ]);

            return back()->with('success', 'Plan added successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to add plan: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'nullable|string',
            'title' => 'nullable|string|max:255'
        ]);

        try {
            $plan = PricingPlan::findOrFail($id);

            // Process features - convert textarea input to array
            $features = [];
            if ($request->features) {
                $features = array_filter(
                    array_map('trim', explode("\n", $request->features)),
                    function($feature) {
                        return !empty($feature);
                    }
                );
            }

            $plan->update([
                'title' => $request->title,
                'price' => $request->price,
                'duration' => $request->duration,
                'features' => $features,
                'is_featured' => $request->has('is_featured')
            ]);

            return back()->with('success', 'Plan updated successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update plan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $plan = PricingPlan::findOrFail($id);
            $plan->delete();
            return back()->with('success', 'Plan deleted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete plan: ' . $e->getMessage()]);
        }
    }
    public function toggleFeatured($id)
    {
        $plan = PricingPlan::findOrFail($id);
        $plan->is_featured = !$plan->is_featured;
        $plan->save();

        return back()->with('success', 'Plan featured status updated.');
    }
}