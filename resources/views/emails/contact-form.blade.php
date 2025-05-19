<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4f46e5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
        }
        .content {
            background-color: #f9fafb;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>New Contact Form Message</h1>
    </div>

    <div class="content">
        <p><strong>From:</strong> {{ $name }} ({{ $email }})</p>
        
        @if(isset($phone) && $phone)
        <p><strong>Phone:</strong> {{ $phone }}</p>
        @endif
        
        <p><strong>Message:</strong></p>
        <p>{{ $messageContent }}</p>
    </div>

    <div class="footer">
        <p>This email was sent from the contact form on CT ZONE website.</p>
    </div>
</body>
</html> 