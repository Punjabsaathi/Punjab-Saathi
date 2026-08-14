<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('site.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#f5f7fb;font-family:'Roboto',Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f5f7fb;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                       style="max-width:600px;width:100%;background:#ffffff;border-radius:10px;overflow:hidden;">

                    @include('emails.partials.header')

                    <tr>
                        <td style="padding:28px 32px 8px;font-family:'Roboto',Arial,sans-serif;">
                            <h1 style="margin:0 0 12px;font-size:20px;color:#111827;">
                                Hi {{ $data->recipientName ?: 'there' }},
                            </h1>
                            <p style="margin:0 0 4px;font-size:14px;line-height:22px;color:#374151;">
                                Thank you for reaching out to {{ config('site.name') }}. We've successfully received your request and our team is on it.
                            </p>
                        </td>
                    </tr>

                    @include('emails.partials.info-card')
                    @include('emails.partials.details-table')

                    <tr>
                        <td style="padding:8px 32px 28px;font-family:'Roboto',Arial,sans-serif;">
                            <p style="margin:0 0 6px;font-size:13px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">What happens next?</p>
                            <p style="margin:0;font-size:14px;line-height:22px;color:#374151;">{{ $data->nextSteps }}</p>
                            @if($data->referenceNo)
                            <p style="margin:12px 0 0;font-size:13px;line-height:20px;color:#6b7280;">
                                Keep your reference number <strong style="color:#fc5e28;">{{ $data->referenceNo }}</strong> handy — you can use it to check your status anytime.
                            </p>
                            @elseif($data->recipientPhone)
                            <p style="margin:12px 0 0;font-size:13px;line-height:20px;color:#6b7280;">
                                If you need to follow up, just quote your registered mobile number <strong style="color:#fc5e28;">{{ $data->recipientPhone }}</strong> — that's how we'll find your request.
                            </p>
                            @endif
                        </td>
                    </tr>

                    @include('emails.partials.footer')
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
