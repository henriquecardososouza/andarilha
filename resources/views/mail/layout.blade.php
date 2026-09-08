<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>@yield("subject", __('landing.brand.name'))</title>
</head>
<body style="margin:0; padding:0; width:100%; background-color:#f2efea; color:#12161f; -webkit-font-smoothing:antialiased; font-family:'Instrument Sans','Helvetica Neue',Helvetica,Arial,sans-serif;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent; height:0; width:0;">
        @yield("preheader")
    </div>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color:#f2efea;">
        <tr>
            <td align="center" style="padding:40px 16px;">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="560" style="width:560px; max-width:100%;">
                    <tr>
                        <td align="center" style="padding-bottom:28px;">
                            <img src="{{ asset('assets/logo.png') }}"
                                 width="210"
                                 alt="{{ __('landing.brand.name') }}: {{ __('landing.brand.slogan') }}"
                                 style="display:block; width:210px; max-width:70%; height:auto; border:0;">
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#ffffff; border:1px solid #e8e4dd; border-radius:16px; padding:40px 40px 36px;">
                            @yield("content")
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:26px 24px 0;">
                            <p style="margin:0; font-size:12px; line-height:1.7; color:#98a0ab;">
                                {{ __('landing.brand.name') }}: {{ __('landing.brand.slogan') }}
                            </p>
                            <p style="margin:8px 0 0; font-size:12px; line-height:1.7; color:#b0b6bf;">
                                @yield("footnote")
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
