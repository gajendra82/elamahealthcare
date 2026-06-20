<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Enquiry</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>New Contact Enquiry</h2>
    <p><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p><strong>Email:</strong> {{ $enquiry->email }}</p>
    @if($enquiry->phone)
        <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
    @endif
    @if($enquiry->subject)
        <p><strong>Subject:</strong> {{ $enquiry->subject }}</p>
    @endif
    <p><strong>Message:</strong></p>
    <p>{!! nl2br(e($enquiry->message)) !!}</p>
    <hr>
    <p style="font-size: 12px; color: #666;">Submitted on {{ $enquiry->created_at->format('d M Y, h:i A') }}</p>
</body>
</html>
