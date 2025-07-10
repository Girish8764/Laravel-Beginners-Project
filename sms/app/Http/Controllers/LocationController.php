<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    public function getDistricts(Request $request)
    {
        $districts = Location::where('parent_id', $request->state_id)
            ->where('type', 'district')
            ->pluck('name', 'id');

        return response()->json($districts);
    }
}
