<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <p>You are receiving this email because a password reset request has been made.</p>
    <p>Click the button below to set a new password:</p>
    <p><a href="{{ route('password.reset.manual') }}" style="display:inline-block;padding:10px 16px;background:#2d3748;color:#ffffff;text-decoration:none;border-radius:4px;">Reset Password</a></p>
    <p>If the button doesn't work, use the following link:</p>
    <p><a href="{{ route('password.reset.manual') }}">{{ route('password.reset.manual') }}</a></p>
    <p>Your email address: {{ $email }}</p>
    <p>Token: <strong>{{ $token }}</strong></p>
    <p>If you did not request this, you can ignore this email.</p>
</body>
</html>
