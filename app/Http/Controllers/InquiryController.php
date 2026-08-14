<?php

namespace App\Http\Controllers;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use App\Services\FormNotificationService;
use App\Support\FormSubmissionData;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'nullable|string|max:100',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:150',
            'service'    => 'nullable|string',
            'message'    => 'nullable|string',
        ]);

        $inquiry = Inquiry::create([
            ...$validated,
            'status' => 'new',
        ]);

        /* ── Notify (user confirmation only sends if they gave an email) ── */
        FormNotificationService::send(new FormSubmissionData(
            formType: 'Service Inquiry (Request Quote)',
            referenceNo: null,
            submittedAt: $inquiry->created_at->format('d M Y, h:i A'),
            statusLabel: 'New',
            nextSteps: 'Our team will call you shortly to discuss your requirement.',
            recipientName: trim($inquiry->first_name . ' ' . $inquiry->last_name),
            recipientEmail: $inquiry->email,
            recipientPhone: $inquiry->phone,
            details: [
                'Service Interested In' => $inquiry->service,
                'Message'               => $inquiry->message,
            ],
            adminUrl: InquiryResource::getUrl('view', ['record' => $inquiry]),
        ));

        return redirect()->back()->with('inquiry_success', 'Your inquiry has been submitted! We will contact you soon.');
    }
}