<?php

namespace App\Http\Controllers;

use App\Models\ServiceApplication;
use Illuminate\Http\Request;

class ApplicationTrackingController extends Controller
{
    public function show()
    {
        return view('pages.tracking.track-application');
    }

    public function search(Request $request)
    {
        $request->validate([
            'reference_no' => 'required|string',
        ]);

        $application = ServiceApplication::with('service')
            ->where('reference_no', strtoupper(trim($request->reference_no)))
            ->first();

        if (!$application) {
            return back()
                ->withInput()
                ->withErrors(['reference_no' => 'No application found with this reference number. Please check and try again.']);
        }

        return view('pages.tracking.track-application', compact('application'));
    }
}