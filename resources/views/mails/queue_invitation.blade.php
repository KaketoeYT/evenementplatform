<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
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
                                Queue Update
                            </div>
                            <h1
                                style="margin:0; font-size: 28px; font-weight: 700; color: #000000; letter-spacing: -0.02em;">
                                Good news!
                            </h1>
                            <p style="margin:10px 0 0; color: #6b7280; font-size: 16px;">
                                There is an available spot for an event on your wishlist.
                            </p>
                        </td>
                    </tr>

                    <!-- EVENT CARD -->
                    <tr>
                        <td style="padding: 0 40px 20px 40px;">
                            <div
                                style="border: 1px solid #edf2f7; border-radius: 12px; padding: 24px; background-color: #fcfcfd; border-left: 4px solid #026cdf;">
                                <h2 style="margin:0 0 10px 0; font-size: 18px; font-weight: 700;">
                                    {{ $event->title }}
                                </h2>
                                <p style="margin:0; color: #4b5563; font-size: 14px;">
                                    Because you were on the waiting list, you now have the first chance to claim this ticket.
                                    Be quick!
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- ACTION -->
                    <tr>
                        <td style="padding: 20px 40px 40px 40px; text-align: center;">
                            <a href="{{ $url }}"
                                style="display: inline-block; background-color: #026cdf; color: white; padding: 16px 32px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 16px; box-shadow: 0 4px 6px rgba(2, 108, 223, 0.2);">
                                Yes, I want this ticket!
                            </a>

                            <p style="margin-top: 25px; color: #9ca3af; font-size: 12px; line-height: 1.5;">
                                <strong>Important:</strong> This link is only valid for <strong>24 hours</strong>.<br>
                                If you don't respond, your chance will be lost and the invitation will go to the next person in line.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td
                            style="background:#f9fafb; padding:25px; text-align:center; font-size:12px; color:#9ca3af; border-top: 1px solid #e5e7eb;">
                            © {{ date('Y') }} Eventify — All rights reserved<br>
                            <span style="display: inline-block; margin-top: 10px;">Questions? Contact our
                                support.</span>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>

