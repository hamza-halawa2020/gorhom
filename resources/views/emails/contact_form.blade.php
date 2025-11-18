<div style="font-family: Arial, sans-serif; background-color: #f7f9fc; padding: 20px;">
    <div
        style="max-width: 700px; margin: auto; background: #ffffff; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); overflow: hidden;">

        <!-- Header -->
        <div style="background-color: #0d6efd; color: #ffffff; padding: 20px 25px;">
            <div style="margin: 0; font-size: 1.5rem;">{{  $data['interest'] }}</div>
        </div>

        <!-- Body -->
        <div style="padding: 25px; line-height: 1.6;">
            @php
                $fields = [
                    'Name' => $data['name'] ?? '-',
                    'Email' => $data['email'] ?? '-',
                    'Phone' => $data['phone'] ?? '-',
                    'Interest' => $data['interest'] ?? '-',
                    'Message' => $data['message'] ?? '-',
                ];

                if (!empty($data['address'])) {
                    $fields['Address'] = $data['address'];
                }
                if (!empty($data['passport'])) {
                    $fields['Id / Passport'] = $data['passport'];
                }
                if (!empty($data['investment_amount'])) {
                    $fields['Investment Amount'] = $data['investment_amount'];
                }
            @endphp

            @foreach($fields as $label => $value)
                <div style="margin-bottom: 15px; display: flex; flex-wrap: wrap;">
                    <div style="flex: 0 0 150px; font-weight: bold; color: #333;">{{ $label }}:</div>
                    <div style="flex: 1; color: #555;">{{ $value }}</div>
                </div>
            @endforeach

        </div>

        <!-- Footer -->
        <div
            style="background-color: #f1f3f5; color: #6c757d; padding: 15px 25px; text-align: right; font-size: 0.875rem;">
            Sent on {{ \Carbon\Carbon::now()->format('F j, Y, g:i a') }}
        </div>
    </div>
</div>