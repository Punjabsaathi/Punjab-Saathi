<?php

namespace App\Http\Controllers;

use App\Models\CscCenter;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CscDirectoryController extends Controller
{
    /**
     * Public CSC directory / search — by pincode, or nearest-first from
     * the visitor's browser location. Shows active centers, gating only
     * self-registered submissions behind admin verification — the bulk
     * government-imported dataset shows regardless (see
     * CscCenter::scopePubliclyVisible()).
     */
    public function index(Request $request): View
    {
        $mode = null;
        $centers = null;

        $query = CscCenter::publiclyVisible();

        if ($request->filled('district')) {
            $query->where('district', $request->string('district'));
        }

        if ($request->boolean('verified')) {
            $query->verified();
        }

        $hasPincode = $request->filled('pincode');
        $hasLatLng  = $request->filled('lat') && $request->filled('lng');

        // The filters sidebar carries the current pincode forward as a
        // hidden field so toggling "Verified" etc. keeps the same results.
        // But a fresh district selection never comes bundled with a fresh
        // pincode (the PIN-code search form doesn't submit `district` at
        // all) — so pincode+district together only ever means "district
        // just changed, this pincode is stale." District wins and the
        // stale pincode is dropped instead of returning zero results.
        if ($hasPincode && !$hasLatLng && $request->filled('district')) {
            $hasPincode = false;
        }

        if ($hasPincode) {
            $mode = 'pincode';
            $centers = (clone $query)
                ->where('pincode', $request->string('pincode'))
                ->orderBy('vle_name')
                ->paginate(20)
                ->withQueryString();
        } elseif ($hasLatLng) {
            $mode = 'nearest';
            $radius = (int) $request->query('radius', 50);
            $radius = $radius > 0 ? min($radius, 200) : 50;

            $centers = (clone $query)
                ->nearby((float) $request->query('lat'), (float) $request->query('lng'), $radius)
                ->paginate(20)
                ->withQueryString();
        } elseif ($request->filled('district')) {
            $mode = 'district';
            $centers = (clone $query)
                ->orderBy('vle_name')
                ->paginate(20)
                ->withQueryString();
        }

        $stats = [
            'total_centers'   => CscCenter::publiclyVisible()->count(),
            'district_count'  => 23, // Punjab's official district count
        ];

        $districts = CscCenter::publiclyVisible()
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->orderBy('district')
            ->pluck('district');

        return view('pages.csc-directory', compact('mode', 'centers', 'stats', 'districts'));
    }

    /**
     * A single CSC center's public profile. Uses the same visibility
     * rule as the directory search — an unverified self-registration
     * that isn't shown in search results isn't reachable directly either.
     */
    public function show(CscCenter $cscCenter): View
    {
        abort_unless(
            $cscCenter->is_active && ($cscCenter->source !== 'self-registered' || $cscCenter->is_verified),
            404
        );

        $cscCenter->load('faqs');

        return view('pages.csc-center-show', ['center' => $cscCenter]);
    }
}
