<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Career Application</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>New Career Application</h2>
    <p><strong>Position:</strong> {{ $application->careerJob?->title ?? 'N/A' }}</p>
    <p><strong>Name:</strong> {{ $application->name }}</p>
    <p><strong>Email:</strong> {{ $application->email }}</p>
    @if($application->phone)
        <p><strong>Phone:</strong> {{ $application->phone }}</p>
    @endif
    @if($application->cover_letter)
        <p><strong>Cover Letter:</strong></p>
        <p>{!! nl2br(e($application->cover_letter)) !!}</p>
    @endif
    <p>Resume is attached to this email.</p>
    <hr>
    <p style="font-size: 12px; color: #666;">Submitted on {{ $application->created_at->format('d M Y, h:i A') }}</p>
</body>
</html>
