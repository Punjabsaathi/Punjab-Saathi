<tr>
    <td style="padding:8px 32px 8px;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
               style="background:#fff3ee;border:1px solid #fcd9c8;border-radius:8px;">
            <tr>
                <td style="padding:16px 20px;font-family:'Roboto',Arial,sans-serif;">
                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="padding:4px 0;font-size:13px;color:#6b7280;">Request Type</td>
                            <td style="padding:4px 0;font-size:13px;color:#111827;font-weight:600;text-align:right;">{{ $data->formType }}</td>
                        </tr>
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
                        <tr>
                            <td style="padding:4px 0;font-size:13px;color:#6b7280;">Submitted On</td>
                            <td style="padding:4px 0;font-size:13px;color:#111827;text-align:right;">{{ $data->submittedAt }}</td>
                        </tr>
                        <tr>
                            <td style="padding:4px 0;font-size:13px;color:#6b7280;">Status</td>
                            <td style="padding:4px 0;font-size:13px;text-align:right;">
                                <span style="background:#fc5e28;color:#ffffff;padding:2px 10px;border-radius:12px;font-size:12px;font-weight:600;">{{ $data->statusLabel }}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
