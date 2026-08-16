<?php

namespace App\Http\Controllers;

use App\Models\CscCenter;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AgentRegistrationController extends Controller
{
    public function show()
    {
        $totalCenters = CscCenter::publiclyVisible()->count();

        return view('agents.agent-registration', compact('totalCenters'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'vle_name'     => 'required|string|max:255',
            'mobile'       => 'required|string|max:15',
            'kiosk_name'   => 'nullable|string|max:255',
            'email'        => 'nullable|email|max:255',
            'csc_id'       => 'nullable|string|max:30',
            'address'      => 'nullable|string|max:1000',
            'sub_district' => 'nullable|string|max:100',
            'district'     => 'required|string|max:100',
            'state'        => 'nullable|string|max:100',
            'pincode'      => 'nullable|string|max:10',
            'latitude'     => 'nullable|numeric|between:-90,90',
            'longitude'    => 'nullable|numeric|between:-180,180',
        ]);

        // Clean mobile — digits only
        $mobile = preg_replace('/\D/', '', $validated['mobile']);

        if (strlen($mobile) !== 10) {
            return back()
                ->withErrors(['mobile' => 'Please enter a valid 10-digit mobile number.'])
                ->withInput();
        }

        $validated['mobile']     = $mobile;
        $validated['source']     = 'self-registered';
        $validated['ip_address'] = $request->ip();
        $result = CscCenter::registerOrUpdate($validated);

        $message = $result['action'] === 'created'
            ? 'Your CSC Center has been registered successfully!'
            : 'Your existing record has been updated successfully!';

        return back()->with('success', $message)->with('reg_action', $result['action']);
    }

    public function success(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        $center = CscCenter::find($request->query('center'));
        $action = $request->query('action');

        if (!$center || !in_array($action, ['created', 'updated'], true)) {
            return redirect()->route('agent.registration');
        }

        return view('agents.agent-registration-success', compact('center', 'action'));
    }

    /**
     * Live duplicate check called from the registration form's JS —
     * lets a VLE know before submitting whether their mobile number
     * already has a record (so they understand it'll be an update,
     * not a fresh registration).
     */
    public function checkMobile(Request $request): JsonResponse
    {
        $mobile = preg_replace('/\D/', '', (string) $request->query('mobile'));

        if (strlen($mobile) !== 10) {
            return response()->json(['exists' => false]);
        }

        $center = CscCenter::where('mobile', $mobile)->first(['vle_name', 'district']);

        return response()->json([
            'exists'  => (bool) $center,
            'vle_name' => $center?->vle_name,
            'district' => $center?->district,
        ]);
    }
}