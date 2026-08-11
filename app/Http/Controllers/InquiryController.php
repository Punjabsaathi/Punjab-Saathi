<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'phone'      => 'required|string|max:20',
            'service'    => 'nullable|string',
            'message'    => 'nullable|string',
        ]);

        Inquiry::create($validated);

        return redirect()->back()->with('success', 'Your inquiry has been submitted! We will contact you soon.');
    }
}