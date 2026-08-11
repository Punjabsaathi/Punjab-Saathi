<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /* ── Show the contact page ──────────────────── */
    public function index(): View
    {
        $faqs = $this->getFaqs();

        return view('pages.contact', compact('faqs'));
    }

    /* ── Handle form submission ─────────────────── */
    public function submit(Request $request): RedirectResponse
    {
        /* ── Honeypot check ── */
        if ($request->filled('website')) {
            return redirect()->route('contact')->with('success', 'Thank you! We will get back to you shortly.');
        }

        /* ── Validate ── */
        $validated = $request->validate([
            'name'     => ['required', 'string', 'min:2', 'max:100'],
            'phone'    => ['required', 'string', 'regex:/^[6-9][0-9]{9}$/'],
            'email'    => ['nullable', 'email', 'max:150'],
            'subject'  => ['required', 'string', 'in:application_status,document_help,service_info,fees_payment,complaint,other'],
            'message'  => ['required', 'string', 'min:10', 'max:2000'],
            'language' => ['nullable', 'string', 'in:en,hi,pa'],
        ], [
            'phone.regex'    => 'Please enter a valid 10-digit Indian mobile number.',
            'subject.in'     => 'Please select a valid subject.',
            'message.min'    => 'Message must be at least 10 characters.',
        ]);

        /* ── Save to DB ── */
        ContactQuery::create([
            'name'       => $validated['name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'] ?? null,
            'subject'    => $validated['subject'],
            'message'    => $validated['message'],
            'language'   => $validated['language'] ?? 'en',
            'status'     => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Thank you, ' . $validated['name'] . '! Your message has been received. We will contact you within 24 hours.');
    }

    /* ── Static FAQ data ────────────────────────── */
    private function getFaqs(): array
    {
        return [
            [
                'question' => 'How quickly will I get a response after submitting the contact form?',
                'answer'   => 'We respond to all contact form submissions within 24 working hours. For urgent matters, we recommend reaching out via WhatsApp for a faster reply — usually within a few hours during working hours.',
            ],
            [
                'question' => 'Can I visit your Amritsar office without an appointment?',
                'answer'   => 'Yes, walk-ins are welcome at our office at Lane No. 12, Shri Hargobind Avenue, Sher Shah Suri Road, Chherrata, Amritsar during working hours (Mon–Sat, 9 AM–6 PM). However, for complex service requests, we recommend calling ahead.',
            ],
            [
                'question' => 'What languages can I communicate in?',
                'answer'   => 'Our team supports Punjabi (ਪੰਜਾਬੀ), Hindi (हिंदी), and English. You can choose your preferred language when submitting this form and we will reply accordingly.',
            ],
            [
                'question' => 'Is Punjab Seva Kendra an official government office?',
                'answer'   => 'Punjab Seva Kendra is an authorised Common Service Centre (CSC) — a private assistance platform that helps citizens apply through official government portals. We are not a government office, but we work with government systems to assist you.',
            ],
            [
                'question' => 'What documents do I need to bring or send for service applications?',
                'answer'   => 'Required documents vary by service. You can browse the specific service page on our website to see a detailed checklist. For general enquiries, our team will guide you after reviewing your query.',
            ],
            [
                'question' => 'How can I check my application status?',
                'answer'   => 'Mention your reference number (e.g. PSK-2026-XXXXXX) in the contact form above and we will respond with a status update. You can also WhatsApp us directly with your reference number for a quicker reply.',
            ],
        ];
    }
}