<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('site.name') }} Admin</title>
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
                                New submission received
                            </h1>
                            <p style="margin:0 0 4px;font-size:14px;line-height:22px;color:#374151;">
                                A new <strong>{{ $data->formType }}</strong> has just come in. Details below.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:8px 32px 8px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                   style="border:1px solid #e5e7eb;border-radius:8px;">
                                <tr>
                                    <td style="padding:16px 20px;font-family:'Roboto',Arial,sans-serif;">
                                        <p style="margin:0 0 10px;font-size:13px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">Submitted By</p>
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding:4px 0;font-size:13px;color:#6b7280;width:40%;">Name</td>
                                                <td style="padding:4px 0;font-size:13px;color:#111827;">{{ $data->recipientName ?: '—' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="padding:4px 0;font-size:13px;color:#6b7280;">Mobile</td>
                                                <td style="padding:4px 0;font-size:13px;color:#111827;">
                                                    @if($data->recipientPhone)
                                                        <a href="tel:{{ $data->recipientPhone }}" style="color:#111827;text-decoration:none;">{{ $data->recipientPhone }}</a>
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:4px 0;font-size:13px;color:#6b7280;">Email</td>
                                                <td style="padding:4px 0;font-size:13px;color:#111827;">
                                                    @if($data->recipientEmail)
                                                        <a href="mailto:{{ $data->recipientEmail }}" style="color:#111827;text-decoration:none;">{{ $data->recipientEmail }}</a>
                                                    @else
                                                        Not provided
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @include('emails.partials.info-card')
                    @include('emails.partials.details-table')

                    @if($data->adminUrl)
                    <tr>
                        <td style="padding:16px 32px 28px;text-align:center;">
                            <a href="{{ $data->adminUrl }}"
                               style="display:inline-block;background:#fc5e28;color:#ffffff;font-size:14px;font-weight:600;
                                      padding:12px 28px;border-radius:8px;text-decoration:none;">
                                View in Admin Panel
                            </a>
                        </td>
                    </tr>
                    @endif

                    @include('emails.partials.footer')
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
