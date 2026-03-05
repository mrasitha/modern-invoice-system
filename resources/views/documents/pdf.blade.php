<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; font-size: 14px; }
        .invoice-header { margin-bottom: 50px; }
        .invoice-header table { width: 100%; }
        .title { font-size: 28px; font-weight: bold; color: #4318ff; }
        .info-table { width: 100%; margin-bottom: 30px; border-collapse: collapse; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th { background-color: #f4f7fe; padding: 12px; text-align: left; color: #8e98aa; font-size: 12px; }
        .items-table td { padding: 12px; border-bottom: 1px solid #eee; }
        .total-section { margin-top: 30px; text-align: right; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 10px; background: #eee; }
    </style>
</head>
<body>
    <div class="invoice-header">
        <table>
            <tr>
                <td>
                    <div class="title">{{ strtoupper($document->type) }}</div>
                    <p>#{{ $document->doc_number }}</p>
                </td>
                <td style="text-align: right;">
                    <strong>Your Company Name</strong><br>
                    123, Business Road, Colombo<br>
                    Email: hello@yourcompany.com
                </td>
            </tr>
        </table>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <p style="color: #8e98aa; margin-bottom: 5px;">BILL TO:</p>
                <strong>{{ $document->project->client_name }}</strong><br>
                Project: {{ $document->project->name }}
            </td>
            <td style="text-align: right;">
                <p style="color: #8e98aa; margin-bottom: 5px;">DATE ISSUED:</p>
                <strong>{{ $document->created_at->format('Y-m-d') }}</strong><br>
                Mode: {{ ucfirst($document->billing_mode) }}
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th style="text-align: center;">QTY</th>
                <th style="text-align: right;">UNIT PRICE</th>
                <th style="text-align: right;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($document->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td style="text-align: center;">{{ $item->qty }}</td>
                <td style="text-align: right;">LKR {{ number_format($item->unit_price, 2) }}</td>
                <td style="text-align: right;">LKR {{ number_format($item->qty * $item->unit_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <p style="font-size: 18px;">Grand Total: <strong style="color: #4318ff;">LKR {{ number_format($document->total_amount, 2) }}</strong></p>
    </div>

    <div style="margin-top: 100px; font-size: 12px; color: #8e98aa; text-align: center;">
        Thank you for your business! This is a computer-generated document.
    </div>
</body>
</html>