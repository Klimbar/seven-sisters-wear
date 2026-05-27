<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #8B2323; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9f9f9; }
        .otp-code { font-size: 36px; font-weight: bold; letter-spacing: 8px; color: #8B2323; text-align: center; padding: 20px; background: white; border: 2px dashed #8B2323; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ asset('images/logo.webp') }}" alt="Seven Sisters Wear" height="48" style="margin-bottom: 10px;">
        <p>Email Verification</p>
    </div>

    <div class="content">
        <p>Dear {{ $name }},</p>

        <p>Thank you for registering with <strong>Seven Sisters Wear</strong>! Please use the following OTP to verify your email address:</p>

        <div class="otp-code">{{ $otp }}</div>

        <p>This code will expire in <strong>10 minutes</strong>.</p>

        <p>If you did not create an account, please ignore this email.</p>

        <p>Thank you for joining <strong>Seven Sisters Wear</strong>!</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Seven Sisters Wear. All rights reserved.</p>
        <p>This is an automated email. Please do not reply.</p>
    </div>
</body>
</html>
