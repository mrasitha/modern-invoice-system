<div style="font-family: sans-serif; padding: 20px; color: #2d3436; line-height: 1.6;">
    <h2 style="color: #4318ff;">Thank You for Your Payment!</h2>
    <p>Hi {{ $document->project->client_name }},</p>
    <p>We have successfully received your payment for <strong>{{ $document->doc_number }}</strong> regarding the project <strong>{{ $document->project->name }}</strong>.</p>
    
    <div style="background: #f8fafc; padding: 15px; border-radius: 10px; margin: 20px 0;">
        <p style="margin: 0;">Amount Paid: <strong>LKR {{ number_format($document->total_amount, 2) }}</strong></p>
        <p style="margin: 0;">Status: <span style="color: #27ae60; font-weight: bold;">PAID</span></p>
    </div>

    <p>We have attached the paid invoice PDF for your records. We appreciate your business and look forward to working with you again!</p>
    
    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    <p style="font-size: 12px; color: #a0aec0;">Best Regards,<br>Management Team</p>
</div>