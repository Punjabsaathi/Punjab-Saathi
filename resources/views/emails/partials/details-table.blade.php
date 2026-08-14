@if(!empty($data->details))
<tr>
    <td style="padding:8px 32px 8px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
               style="border:1px solid #e5e7eb;border-radius:8px;">
            <tr>
                <td style="padding:16px 20px;font-family:'Roboto',Arial,sans-serif;">
                    <p style="margin:0 0 10px;font-size:13px;font-weight:700;color:#111827;text-transform:uppercase;letter-spacing:.5px;">Details</p>
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                        @foreach($data->details as $label => $value)
                            @if(!is_null($value) && $value !== '')
                            <tr>
                                <td style="padding:6px 0;font-size:13px;color:#6b7280;width:40%;vertical-align:top;">{{ $label }}</td>
                                <td style="padding:6px 0;font-size:13px;color:#111827;vertical-align:top;">{{ $value }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
@endif
