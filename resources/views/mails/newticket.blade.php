<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket Confirmation</title>
</head>

<body style="margin:0; font-family: Arial, sans-serif; background-color:#f4f4f4;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 20px;">
        <tr>
            <td align="center">

                <table width="600"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1);">

                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea, #764ba2); color:white; padding:20px;">
                            <h1 style="margin:0;">🎟️ Ticket Bevestiging</h1>
                            <p style="margin:5px 0 0;">Bedankt voor je reservering!</p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding:20px;">

                            <h2 style="margin-top:0;">Hallo {{ $ticket->user->name }},</h2>

                            <p>Je ticket is succesvol aangemaakt. Hieronder vind je alle details:</p>

                            <!-- Ticket Info -->
                            <h3>🎫 Ticket Details</h3>
                            <table width="100%" style="border-collapse: collapse;">
                                <tr>
                                    <td><strong>Ticketnummer:</strong></td>
                                    <td>{{ $ticket->ticket_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Type:</strong></td>
                                    <td>{{ $ticket->rank }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Prijs:</strong></td>
                                    <td>€{{ $ticket->price }}</td>
                                </tr>
                            </table>

                            <hr>

                            <!-- Event Info -->
                            <h3>📅 Event Info</h3>
                            <table width="100%">
                                <tr>
                                    <td><strong>Event:</strong></td>
                                    <td>{{ $ticket->event->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Datum:</strong></td>
                                    <td>{{ $ticket->event->datetime ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Locatie:</strong></td>
                                    <td>{{ $ticket->event->venue->name ?? 'N/A' }}</td>
                                </tr>
                            </table>

                            <hr>

                            <!-- User Info -->
                            <h3>👤 Jouw Gegevens</h3>
                            <table width="100%">
                                <tr>
                                    <td><strong>Naam:</strong></td>
                                    <td>{{ $ticket->user->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $ticket->user->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Telefoon:</strong></td>
                                    <td>{{ $ticket->user->phonenumber }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Adres:</strong></td>
                                    <td>
                                        {{ $ticket->user->street }},
                                        {{ $ticket->user->zipcode }},
                                        {{ $ticket->user->city }},
                                        {{ $ticket->user->country }}
                                    </td>
                                </tr>
                            </table>

                            <hr>

                            <p style="margin-top:20px;">
                                👉 Bewaar deze mail goed. Dit is je toegangsbewijs.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#f0f0f0; padding:15px; text-align:center; font-size:12px; color:#777;">
                            © {{ date('Y') }} Your App — Alle rechten voorbehouden
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
