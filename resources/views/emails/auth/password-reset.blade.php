<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $subject ?? 'Reset Your Password' }}</title>
    <style>
        /* Client-friendly, fully inlined-compatible email styles */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            margin: 0;
            padding: 0;
            width: 100%;
            background-color: #f4f6f8;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #1f2937;
        }
        table { border-collapse: collapse; }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 32px 16px;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #0e48c1 0%, #0c3ca1 100%);
            padding: 36px 40px;
            text-align: left;
        }
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
        }
        .logo-badge {
            width: 40px;
            height: 40px;
            background: #0e48c1;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .logo-badge svg { width: 24px; height: 24px; fill: #ffffff; }
        .logo-text {
            color: #ffffff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.02em;
        }
        .header-title {
            color: #ffffff;
            font-size: 26px;
            font-weight: 700;
            line-height: 1.25;
            margin-top: 24px;
        }
        .header-sub {
            color: #c7d6f5;
            font-size: 14px;
            font-weight: 500;
            margin-top: 8px;
            line-height: 1.5;
        }
        .body { padding: 40px; }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
        }
        .text {
            font-size: 15px;
            line-height: 1.7;
            color: #374151;
            margin-bottom: 16px;
        }
        .button-wrap { text-align: center; margin: 32px 0; }
        .button {
            display: inline-block;
            background-color: #0e48c1;
            color: #ffffff !important;
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            padding: 14px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(14, 72, 193, 0.25);
        }
        .meta {
            background-color: #f4f6f8;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px 20px;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
            margin: 24px 0;
        }
        .meta a { color: #0e48c1; font-weight: 600; word-break: break-all; }
        .meta-label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #9ca3af;
            margin-bottom: 6px;
        }
        .divider { border-top: 1px solid #eef0f3; margin: 28px 0; }
        .note { font-size: 13px; line-height: 1.6; color: #9ca3af; }
        .footer {
            padding: 28px 40px;
            background-color: #f8fafc;
            border-top: 1px solid #eef0f3;
            text-align: center;
        }
        .footer-brand {
            color: #0e48c1;
            font-size: 14px;
            font-weight: 700;
        }
        .footer-text {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.6;
            margin-top: 8px;
        }
        .footer-links { margin-top: 12px; }
        .footer-links a {
            color: #0e48c1;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            margin: 0 8px;
        }
        @media only screen and (max-width: 600px) {
            .header, .body, .footer { padding-left: 24px; padding-right: 24px; }
            .button { display: block; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div class="card">
                        <div class="header">
                            <div class="logo">
                                 <i class="fa-solid fa-envelope"></i>
                                <span class="logo-text">Scholar Metric</span>
                            </div>
                            <div class="header-title">Reset Your Password</div>
                            <div class="header-sub">Secure account recovery for the Scholar Metric portal.</div>
                        </div>

                        <div class="body">
                            @if (! empty($firstName))
                                <div class="greeting">Hello {{ $firstName }},</div>
                            @endif

                            <p class="text">
                                We received a request to reset the password for your Scholar Metric account
                                associated with <strong>{{ $email }}</strong>. Please click the button below to
                                choose a new password and secure your account.
                            </p>

                            <div class="button-wrap">
                                <a class="button" href="{{ $resetUrl }}" target="_blank" rel="noopener">Reset Password</a>
                            </div>

                            <div class="meta">
                                <span class="meta-label">Direct link</span>
                                If the button above does not work, copy and paste this URL into your browser:
                                <br><a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
                            </div>

                            <p class="note">
                                For your security, this reset link will expire in <strong>60 minutes</strong> from
                                the time it was requested. If you did not request a password reset, no further action
                                is required — you can safely ignore this email, and your password will remain unchanged.
                            </p>
                        </div>

                        <div class="footer">
                            <div class="footer-brand">Scholar Metric Academic Systems</div>
                            <div class="footer-text">
                                Protecting the integrity of institutional data through secure account management.<br>
                                Sent from {{ config('mail.from.address') }}
                            </div>
                            <div class="footer-links">
                                <a href="#">Privacy Policy</a>
                                <a href="#">Institutional Security</a>
                            </div>
                            <div class="footer-text" style="margin-top: 10px;">
                                &copy; {{ date('Y') }} Scholar Metric Academic Systems. All rights reserved.
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
