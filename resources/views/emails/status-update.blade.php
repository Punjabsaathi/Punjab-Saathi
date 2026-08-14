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
                                There's an update on your <strong>{{ $data->formType }}</strong>.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px 32px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="background:#fff3ee;border:1px solid #fcd9c8;border-radius:8px;">
                                <tr>
                                    <td style="padding:20px;font-family:'Roboto',Arial,sans-serif;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" align="center">
                                            <tr>
                                                <td style="text-align:center;padding:0 16px;">
                                                    <span style="display:inline-block;background:#e5e7eb;color:#374151;padding:4px 14px;border-radius:12px;font-size:12px;font-weight:600;">{{ $data->previousStatusLabel }}</span>
                                                </td>
                                                <td style="text-align:center;padding:0 8px;font-size:16px;color:#fc5e28;">&rarr;</td>
                                                <td style="text-align:center;padding:0 16px;">
                                                    <span style="display:inline-block;background:#fc5e28;color:#ffffff;padding:4px 14px;border-radius:12px;font-size:12px;font-weight:600;">{{ $data->newStatusLabel }}</span>
                                                </td>
                                            </tr>
                                        </table>

                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:16px;">
                                            @if($data->referenceNo)
                                            <tr>
                                                <td style="padding:4px 0;font-size:13px;color:#6b7280;">Reference No.</td>
                                                <td style="padding:4px 0;font-size:13px;color:#fc5e28;font-weight:700;text-align:right;">{{ $data->referenceNo }}</td>
                                            </tr>
                                            @elseif($data->recipientPhone)
                                            <tr>
                                                <td style="padding:4px 0;font-size:13px;color:#6b7280;">Identify With</td>
                                                <td style="padding:4px 0;font-size:13px;color:#fc5e28;font-weight:700;text-align:right;">Mobile: {{ $data->recipientPhone }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @if($data->note)
                    <tr>
                        <td style="padding:8px 32px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="border:1px solid #e5e7eb;border-left:4px solid #fc5e28;border-radius:8px;">
                                <tr>
                                    <td style="padding:14px 18px;font-family:'Roboto',Arial,sans-serif;">
                                        <p style="margin:0 0 4px;font-size:12px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">Note from our team</p>
                                        <p style="margin:0;font-size:14px;line-height:22px;color:#374151;">{{ $data->note }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    @endif

                    <tr>
                        <td style="padding:16px 32px 28px;font-family:'Roboto',Arial,sans-serif;">
                            <p style="margin:0;font-size:13px;line-height:20px;color:#6b7280;">
                                If you have any questions about this update, feel free to reach out to us — our contact details are below.
                            </p>
                        </td>
                    </tr>

                    @include('emails.partials.footer')
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
