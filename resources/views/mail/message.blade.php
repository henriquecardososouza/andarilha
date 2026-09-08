@extends("mail.layout")

@section("subject", $subject)

@section("preheader", $preheader)

@section("content")
    <p style="margin:0 0 6px; font-size:11px; font-weight:700; letter-spacing:0.18em; text-transform:uppercase; color:#c65a1e;">
        {{ $eyebrow }}
    </p>

    <h1 style="margin:0; font-family:'Archivo','Helvetica Neue',Helvetica,Arial,sans-serif; font-size:23px; line-height:1.25; font-weight:800; letter-spacing:-0.01em; color:#12161f;">
        {{ $heading }}
    </h1>

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td style="padding:18px 0 22px;">
                <div style="height:2px; width:46px; background-color:#c65a1e; font-size:0; line-height:0;">&nbsp;</div>
            </td>
        </tr>
    </table>

    @foreach ($paragraphs as $paragraph)
        <p style="margin:0 0 16px; font-size:15px; line-height:1.75; color:#5b6472;">{{ $paragraph }}</p>
    @endforeach

    @if ($details)
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="margin:10px 0 6px; background-color:#faf8f5; border:1px solid #eeeae3; border-radius:12px;">
            @foreach ($details as $detail)
                <tr>
                    <td style="padding:14px 20px;{{ $loop->last ? '' : ' border-bottom:1px solid #f1ede7;' }}">
                        <span style="display:block; font-size:10px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:#a8afb9;">{{ $detail['label'] }}</span>
                        <span style="display:block; margin-top:5px; font-size:15px; color:{{ $detail['strong'] ?? false ? '#c65a1e' : '#12161f' }}; font-weight:{{ $detail['strong'] ?? false ? '700' : '400' }};">{{ $detail['value'] }}</span>
                    </td>
                </tr>
            @endforeach
        </table>
    @endif

    @if ($action)
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-top:24px;">
            <tr>
                <td align="center" style="background-color:#c65a1e; border-radius:10px;">
                    <a href="{{ $action['url'] }}"
                       style="display:inline-block; padding:16px 34px; font-size:12px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:#ffffff; text-decoration:none; font-family:'Archivo','Helvetica Neue',Helvetica,Arial,sans-serif;">
                        {{ $action['label'] }}
                    </a>
                </td>
            </tr>
        </table>
    @endif

    @if ($note)
        <p style="margin:26px 0 0; font-size:13px; line-height:1.7; color:#8a919c;">{{ $note }}</p>
    @endif

    @if ($action)
        <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td style="padding:28px 0 0;">
                    <div style="height:1px; background-color:#eeeae3; font-size:0; line-height:0;">&nbsp;</div>
                </td>
            </tr>
        </table>

        <p style="margin:24px 0 10px; font-size:12px; line-height:1.7; color:#98a0ab;">
            {{ __('admin.mail.fallback') }}
        </p>

        <p style="margin:0; font-size:12px; line-height:1.7; word-break:break-all;">
            <a href="{{ $action['url'] }}" style="color:#a4491a; text-decoration:underline;">{{ $action['url'] }}</a>
        </p>
    @endif
@endsection

@section("footnote", $footnote)
