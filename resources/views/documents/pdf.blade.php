<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 13px; margin: 0; padding: 0; }
        .container { padding: 30px; }
        .invoice-header { border-bottom: 2px solid #f4f7fe; padding-bottom: 20px; margin-bottom: 30px; }
        .title { font-size: 24px; font-weight: bold; color: #4318ff; margin: 0; }
        .status-badge { background: #f4f7fe; color: #4318ff; padding: 5px 10px; border-radius: 5px; font-size: 10px; text-transform: uppercase; }
        
        .table-split { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        .table-split td { width: 50%; vertical-align: top; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th { background-color: #4318ff; color: #ffffff; padding: 12px; text-align: left; font-size: 11px; }
        .items-table td { padding: 12px; border-bottom: 1px solid #f4f7fe; }
        
        .total-section { float: right; width: 250px; margin-top: 30px; }
        .total-row { display: table; width: 100%; margin-bottom: 5px; }
        .total-label { display: table-cell; color: #8e98aa; }
        .total-value { display: table-cell; text-align: right; font-weight: bold; }
        
        .footer { position: fixed; bottom: 30px; width: 100%; text-align: center; font-size: 10px; color: #8e98aa; border-top: 1px solid #eee; padding-top: 15px; }
        .bank-details { background: #f9f9f9; padding: 15px; border-radius: 10px; margin-top: 50px; font-size: 11px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice-header">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 150px;">
                        @if(isset($settings['business_logo']))
                            <img src="{{ public_path('storage/' . $settings['business_logo']) }}" style="max-width: 120px; max-height: 80px;">
                        @else
                            <h1 class="title">{{ strtoupper($document->type) }}</h1>
                        @endif
                    </td>
                    <td>
                        <h1 class="title">{{ strtoupper($document->type) }}</h1>
                        <span class="status-badge">{{ $document->status }}</span>
                        <p style="margin-top: 10px;">Ref: <strong>#{{ $document->doc_number }}</strong></p>
                    </td>
                    <td style="text-align: right;">
                        <strong style="font-size: 16px;">{{ $settings['business_name'] ?? 'Your Business' }}</strong><br>
                        <span style="color: #666;">
                            {!! nl2br(e($settings['business_address'] ?? 'Address Not Set')) !!}<br>
                            Tel: {{ $settings['business_phone'] ?? '-' }}<br>
                            Email: {{ $settings['business_email'] ?? '-' }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <table class="table-split">
            <tr>
                <td>
                    <p style="color: #8e98aa; margin-bottom: 5px; font-size: 11px;">BILL TO:</p>
                    <strong style="font-size: 15px;">{{ $document->project->client_name }}</strong><br>
                    Project: {{ $document->project->name }}
                </td>
                <td style="text-align: right;">
                    <p style="color: #8e98aa; margin-bottom: 5px; font-size: 11px;">DATE ISSUED:</p>
                    <strong>{{ $document->created_at->format('M d, Y') }}</strong><br>
                    Payment Mode: {{ ucfirst($document->billing_mode) }}
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>DESCRIPTION</th>
                    <th style="text-align: center;">QTY</th>
                    <th style="text-align: right;">UNIT PRICE</th>
                    <th style="text-align: right;">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td style="text-align: center;">{{ $item->qty }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right;">{{ number_format($item->qty * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row" style="font-size: 18px; color: #4318ff; border-top: 2px solid #4318ff; padding-top: 10px;">
                <div class="total-label">Grand Total</div>
                <div class="total-value">LKR {{ number_format($document->total_amount, 2) }}</div>
            </div>
        </div>

        <div style="clear: both;"></div>

        @if(!empty($settings['payment_terms']))
        <div class="bank-details">
            <strong style="color: #4318ff;">Payment Information & Terms:</strong><br>
            <p style="margin-top: 5px;">{!! nl2br(e($settings['payment_terms'])) !!}</p>
        </div>
        @endif

        <div class="footer">
            Thank you for choosing {{ $settings['business_name'] ?? 'us' }}.<br>
            Registered No: {{ $settings['business_reg'] ?? 'N/A' }} | Generated on {{ date('Y-m-d H:i') }}
        </div>
    </div>
</body>
</html>