<tr>
    <td style="background:#f9fafb;border-top:1px solid #e5e7eb;padding:24px 32px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="font-family:'Roboto',Arial,sans-serif;font-size:13px;line-height:20px;color:#6b7280;">
                    <p style="margin:0 0 8px;font-weight:700;color:#111827;">{{ config('site.name') }}</p>
                    <p style="margin:0 0 4px;">{{ config('site.address') }}</p>
                    <p style="margin:0 0 4px;">
                        <a href="tel:{{ config('site.phone') }}" style="color:#fc5e28;text-decoration:none;">{{ config('site.phone') }}</a>
                        &nbsp;&middot;&nbsp;
                        <a href="mailto:{{ config('site.email') }}" style="color:#fc5e28;text-decoration:none;">{{ config('site.email') }}</a>
                    </p>
                    <p style="margin:0 0 16px;">
                        <a href="{{ config('site.website') }}" style="color:#fc5e28;text-decoration:none;">{{ config('site.website') }}</a>
                    </p>
                    <p style="margin:0 0 8px;padding-top:12px;border-top:1px solid #e5e7eb;color:#9ca3af;">
                        {{ config('site.name') }} is a private citizen service &amp; assistance platform. We are not a Government of Punjab or Government of India department, and this email is not an official government communication.
                    </p>
                    <p style="margin:0;color:#9ca3af;">
                        &copy; {{ date('Y') }} {{ config('site.name') }}. All rights reserved.
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
