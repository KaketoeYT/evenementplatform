<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Wachtwoord resetten</title>
</head>
<body>
    <p>Je ontvangt deze e-mail omdat er een verzoek is gedaan om je wachtwoord te resetten.</p>
    <p>Klik op de knop hieronder om een nieuw wachtwoord in te stellen:</p>
    <p><a href="{{ route('password.reset.manual') }}" style="display:inline-block;padding:10px 16px;background:#2d3748;color:#ffffff;text-decoration:none;border-radius:4px;">Reset wachtwoord</a></p>
    <p>Als de knop niet werkt, gebruik dan de volgende link:</p>
    <p><a href="{{ route('password.reset.manual') }}">{{ route('password.reset.manual') }}</a></p>
    <p>Je e-mailadres: {{ $email }}</p>
    <p>Token: <strong>{{ $token }}</strong></p>
    <p>Als je dit niet hebt aangevraagd, kun je deze e-mail negeren.</p>
</body>
</html>
