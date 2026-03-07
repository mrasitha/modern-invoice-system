<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', sans-serif; color: #2d3436; font-size: 10px; margin: 0; padding: 0; background: #fff; }
        
        /* Soft Curved Background Graphic */
        .header-bg {
            position: absolute;
            top: -50px; right: -50px;
            width: 300px; height: 300px;
            background: #4318ff;
            border-radius: 50%;
            opacity: 0.04;
            z-index: -1;
        }

        .container { padding: 40px; position: relative; }

        /* Header */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .logo-area { width: 60%; vertical-align: middle; }
        .invoice-info-area { width: 40%; text-align: right; vertical-align: top; }

        .logo-img { max-height: 55px; margin-bottom: 10px; }
        .company-name { font-size: 16px; font-weight: bold; color: #4318ff; margin-bottom: 3px; }
        .company-sub { font-size: 8.5px; color: #718096; line-height: 1.4; }

        .invoice-label { font-size: 30px; font-weight: 900; color: #1a202c; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .ref-badge { 
            display: inline-block; 
            background: #4318ff; 
            color: #fff; 
            padding: 4px 12px; 
            border-radius: 20px; 
            font-weight: bold; 
            margin-top: 5px; 
            font-size: 9px;
        }

        /* Billing Section - Compact & Curved */
        .billing-grid { 
            width: 100%; 
            margin-bottom: 30px; 
            background: #f8fafc; 
            padding: 20px; 
            border-radius: 15px; 
        }
        .billing-grid td { width: 33%; vertical-align: top; }
        .small-label { font-size: 8px; color: #a0aec0; text-transform: uppercase; font-weight: bold; margin-bottom: 8px; display: block; }
        .val-text { font-size: 11px; font-weight: bold; color: #2d3436; }

        /* Icon Style */
        .icon-img { width: 10px; height: 10px; vertical-align: middle; margin-right: 5px; }

        /* Items Table */
        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th { 
            padding: 10px 15px; 
            text-align: left; 
            font-size: 8.5px; 
            color: #718096; 
            border-bottom: 1px solid #edf2f7;
            text-transform: uppercase;
        }
        .items-table td { padding: 10px 15px; border-bottom: 1px solid #f8fafc; vertical-align: top; }
        
        .desc-text { font-weight: bold; color: #2d3436; font-size: 10.5px; margin-bottom: 2px; }
        .desc-sub { color: #718096; font-size: 9px; line-height: 1.3; }

        /* Total Section */
        .summary-wrapper { width: 100%; margin-top: 25px; }
        .summary-table { float: right; width: 200px; border-collapse: collapse; }
        .summary-table td { padding: 5px 0; }
        .total-amount { font-size: 15px; color: #4318ff; font-weight: 900; }

        /* Payment Card - Curved */
        .bottom-section { margin-top: 40px; page-break-inside: avoid; }
        .payment-card { 
            background: #f4f7fe; 
            padding: 15px; 
            border-radius: 12px; 
            /* border: 1px solid #4318ff; */
        }
        
        .footer-text { position: fixed; bottom: 20px; width: 100%; text-align: center; color: #cbd5e0; font-size: 8px; }
    </style>
</head>
<body>
    <div class="header-bg"></div>
    
    <div class="container">
        <table class="header-table">
            <tr>
                <td class="logo-area">
                    @if(isset($settings['business_logo']))
                        <img src="{{ public_path('storage/' . $settings['business_logo']) }}" class="logo-img">
                    @endif
                    <div class="company-name">{{ $settings['business_name'] ?? 'Your Company' }}</div>
                    <div class="company-sub">
                        {!! nl2br(e($settings['business_address'] ?? '')) !!}<br>
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0MzE4ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNNCA0aDE2YzEuMSAwIDIgLjkgMiAydjEyYzAgMS4xLS45IDItMiAyaC0xNmMtMS4xIDAtMi0uOS0yLTJWNmMwLTEuMS45LTIgMi0yek0yMiA2bC0xMCA3TDQgNiIvPjwvc3ZnPg==" class="icon-img"> {{ $settings['business_email'] ?? '-' }}
                    </div>
                </td>
                <td class="invoice-info-area">
                    <h1 class="invoice-label">{{ $document->type }}</h1>
                    <div class="ref-badge">#{{ $document->doc_number }}</div>
                    <div style="margin-top: 10px; color: #718096; font-size: 9px;">
                        <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM3MTgwOTYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cmVjdCB4PSIzIiB5PSI0IiB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHJ4PSIyIiByeT0iMiIvPjxwYXRoIGQ9Ik0xNiAydjRNOCAydjRNOTMgMTBoMTgiLz48L3N2Zz4=" class="icon-img"> Issued: <strong>{{ $document->created_at->format('d M, Y') }}</strong><br>
                        Status: <span style="color: #4318ff; font-weight: bold;">{{ strtoupper($document->status) }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="billing-grid">
            <table style="width: 100%;">
                <tr>
                    <td>
                        <span class="small-label">
                            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0MzE4ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMjAgMjF2LTJhNCA0IDAgMCAwLTQtNGgtNGE0IDQgMCAwIDAtNCAydjJNMTIgN2E0IDQgMCAxIDAgMC04IDQgNCAwIDAgMCAwIDhaIi8+PC9zdmc+" class="icon-img"> Bill To
                        </span>
                        <div class="val-text">{{ $document->project->client_name }}</div>
                        <div style="color: #718096; font-size: 9px;">{{ $document->project->name }}</div>
                    </td>
                    <td>
                        <span class="small-label">
                            <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0MzE4ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cmVjdCB4PSIzIiB5PSI1IiB3aWR0aD0iMTgiIGhlaWdodD0iMTQiIHJ4PSIyIi8+PHBhdGggZD0iTTMgMTBoMTgiLz48L3N2Zz4=" class="icon-img"> Mode
                        </span>
                        <div class="val-text">{{ ucfirst($document->billing_mode) }}</div>
                        <div style="color: #718096; font-size: 9px;">Standard Payment</div>
                    </td>
                    <td style="text-align: right;">
                        <span class="small-label">Due Amount</span>
                        <div style="font-size: 16px; font-weight: 900; color: #4318ff;">LKR {{ number_format($document->total_amount, 2) }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 60%;">Description</th>
                    <th style="width: 10%; text-align: center;">Qty</th>
                    <th style="width: 15%; text-align: right;">Rate</th>
                    <th style="width: 15%; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($document->items as $item)
                <tr>
                    <td>
                        <div class="desc-text">{{ $item->description }}</div>
                        <div class="desc-sub">Project deliverables and services.</div>
                    </td>
                    <td style="text-align: center; vertical-align: middle;">{{ $item->qty }}</td>
                    <td style="text-align: right; vertical-align: middle;">{{ number_format($item->unit_price, 2) }}</td>
                    <td style="text-align: right; vertical-align: middle; font-weight: bold;">{{ number_format($item->qty * $item->unit_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td style="color: #a0aec0; font-size: 9px;">Subtotal</td>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($document->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; font-weight: bold; font-size: 11px;">Total Amount</td>
                    <td style="padding-top: 10px; text-align: right;" class="total-amount">LKR {{ number_format($document->total_amount, 2) }}</td>
                </tr>
            </table>
            <div style="clear: both;"></div>
        </div>

        @if(!empty($settings['payment_terms']))
        <div class="bottom-section">
            <div class="payment-card">
                <div style="font-weight: bold; color: #4318ff; margin-bottom: 8px; font-size: 9px; text-transform: uppercase;">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyNCIgaGVpZ2h0PSIyNCIgdmlld0JveD0iMCAwIDI0IDI0IiBmaWxsPSJub25lIiBzdHJva2U9IiM0MzE4ZmYiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2UtbGluZWpvaW49InJvdW5kIj48cGF0aCBkPSJNMTAuNiA0LjhMMTggMTJsLTcuNCA3LjJNMCAwdjI0aDI0VjBIMHoiLz48L3N2Zz4=" class="icon-img" style="width:8px;"> Payment Instructions
                </div>
                <div style="line-height: 1.5; color: #4a5568; font-size: 9px;">{!! nl2br(e($settings['payment_terms'])) !!}</div>
            </div>
        </div>
        @endif
    </div>

    <div class="footer-text">
        {{ $settings['business_name'] ?? '' }} | {{ $settings['business_reg'] ?? 'N/A' }} | Computer Generated Document
    </div>
</body>
</html>