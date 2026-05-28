<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Ticket Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body style="margin:0; font-family: 'Inter', Arial, sans-serif; background-color:#f8f9fa; color: #1a1a1a;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 20px;">
        <tr>
            <td align="center">

                <table width="600"
                    style="background:#ffffff; border-radius:12px; border: 1px solid #e5e7eb; overflow:hidden;">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding: 40px 40px 20px 40px;">
                            <div
                                style="background-color: #026cdf; color: white; display: inline-block; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.05em;">
                                Order Bevestigd
                            </div>
                            <h1
                                style="margin:0; font-size: 28px; font-weight: 700; color: #000000; letter-spacing: -0.02em;">
                                Je bent erbij, {{ $ticket->user->name }}!
                            </h1>
                            <p style="margin:10px 0 0; color: #6b7280; font-size: 16px;">Bedankt voor je reservering via
                                Eventify.</p>
                        </td>
                    </tr>

                    <!-- BODY -->
                    <tr>
                        <td style="padding: 20px 40px 40px 40px;">

                            <!-- Main Ticket Card Appearance -->
                            <div
                                style="border: 1px solid #edf2f7; border-radius: 12px; padding: 24px; background-color: #ffffff;">
                                <h2
                                    style="margin-top:0; font-size: 18px; font-weight: 700; border-bottom: 2px solid #f3f4f6; padding-bottom: 12px;">
                                    {{ $ticket->event->name ?? 'Event Details' }}
                                </h2>

                                <table width="100%" style="margin-top: 15px;">
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #6b7280; font-size: 14px; width: 100px;">
                                            Datum</td>
                                        <td style="padding-bottom: 8px; font-weight: 600; font-size: 14px;">
                                            {{ \Carbon\Carbon::parse($ticket->event->datetime)->format('D, M j, Y') }}
                                            om {{ \Carbon\Carbon::parse($ticket->event->datetime)->format('H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #6b7280; font-size: 14px;">Locatie</td>
                                        <td style="padding-bottom: 8px; font-weight: 600; font-size: 14px;">
                                            {{ $ticket->event->venue->name ?? 'TBA' }} —
                                            {{ $ticket->event->venue->city ?? '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 8px; color: #6b7280; font-size: 14px;">Type</td>
                                        <td style="padding-bottom: 8px; font-weight: 600; font-size: 14px;">
                                            @if ($ticket->rank === 'VIP')
                                                <span style="background-color: #fbbf24; color: #78350f; padding: 2px 8px; border-radius: 4px; font-weight: 700;">VIP</span>
                                            @elseif ($ticket->rank === 'seated')
                                                Zittend
                                            @else
                                                Standaard
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <div
                                    style="margin-top: 20px; background-color: #f9fafb; border-radius: 8px; padding: 15px; text-align: center;">
                                    <span
                                        style="display: block; font-size: 11px; text-transform: uppercase; color: #9ca3af; margin-bottom: 4px;">Ticketnummer</span>
                                    <span
                                        style="font-family: monospace; font-size: 18px; font-weight: 700; color: #026cdf;">{{ $ticket->ticket_number }}</span>
                                </div>
                            </div>

                            <!-- User Info Section -->
                            <h3
                                style="margin: 30px 0 15px; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">
                                Koper gegevens</h3>
                            <table width="100%" style="font-size: 14px; line-height: 1.6;">
                                <tr>
                                    <td style="color: #6b7280;">Naam:</td>
                                    <td align="right"><strong>{{ $ticket->user->name }}</strong></td>
                                </tr>
                                @if ($ticket->rank === 'VIP')
                                    <tr>
                                        <td style="color: #6b7280;">Standaard prijs:</td>
                                        <td align="right"><strong style="text-decoration: line-through; color: #9ca3af;">€{{ number_format($ticket->event->entry_price, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280;">VIP prijs (2x):</td>
                                        <td align="right"><strong style="color: #026cdf; font-size: 16px;">€{{ number_format($ticket->price, 2) }}</strong></td>
                                    </tr>
                                @elseif ($ticket->rank === 'seated')
                                    <tr>
                                        <td style="color: #6b7280;">Standaard prijs:</td>
                                        <td align="right"><strong style="text-decoration: line-through; color: #9ca3af;">€{{ number_format($ticket->event->entry_price, 2) }}</strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #6b7280;">Zittend (0,75x):</td>
                                        <td align="right"><strong style="color: #10b981;">€{{ number_format($ticket->price, 2) }}</strong></td>
                                    </tr>
                                @else
                                    <tr>
                                        <td style="color: #6b7280;">Totaalprijs:</td>
                                        <td align="right"><strong>€{{ number_format($ticket->price, 2) }}</strong></td>
                                    </tr>
                                @endif
                            </table>

                            <div style="margin-top: 35px; text-align: center;">
                                <p style="font-size: 14px; color: #4b5563;">
                                    Dit is je officiële toegangsbewijs. Toon deze mail bij de ingang.
                                </p>
                                <a href="#"
                                    style="display: inline-block; background-color: #026cdf; color: white; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 10px;">Bekijk
                                    in je account</a>
                            </div>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="background:#f9fafb; padding:25px; text-align:center; font-size:12px; color:#9ca3af; border-top: 1px solid #e5e7eb;">
                            © {{ date('Y') }} Eventify — Alle rechten voorbehouden<br>
                            <span style="display: inline-block; margin-top: 10px;">Vragen? Neem contact op met onze
                                support.</span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
