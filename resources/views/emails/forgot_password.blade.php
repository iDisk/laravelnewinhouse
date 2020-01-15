<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
         
        </style>
    </head>
    <body>
        <div style="margin: 0 auto; padding: 20px 10px; background-color: #fff;">
        <table align="center" style="background-color:#f1f3f4;border:0 none;border-collapse:collapse;margin:0 auto;max-width:600px;padding:0" cellpadding="0" cellspacing="0" width="100%">
            <tbody>
                <tr style="border-collapse:collapse;font-family:Roboto,sans-serif;padding:0">
                    <td>
                    <table style="border:0 none;border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">

                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding: 15px 0;border:2px solid #f1f3f4;" align="center" bgcolor="#ffffff" valign="top" width="100%" dir="ltr">
                                <table style="border:0 none;border-collapse:collapse" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                        <tr>
                                            <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding-left: 10px;" valign="top" width="50%"><img alt="Google" src="{{ url('assets/images/logo_espacios.png') }}" style="border:0 none;height: 45px;max-width:auto;width:auto;" border="0" width="auto" height="30"></td>
                                            <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding-right:20px;text-align:right" valign="top" width="50%"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding:20px">
                                     <table style="background-color: #fff; color: #5f6368;">
                                        <tr>
                                            <td style="border-collapse:collapse;color:#5f6368;font-family:Google Sans,Roboto,Helvetica,Arial,sans-serif;font-size:24px;line-height:32px;padding:10px 30px;" align="center">
                                                @lang('sistema.forgot_password_mail.welcome_msg')
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding:15px 30px 25px 30px;font-size:16px;line-height:26px">
                                                    <p style="margin: 0px 0px 10px 0px;">@lang('sistema.forgot_password_mail.hello') {{ $mail_data['user'] }},</p>
                                                    @lang('sistema.forgot_password_mail.link_msg1')<br>
                                                    @lang('sistema.forgot_password_mail.link_msg2')<br>
                                            </td>
                                        <tr>
                                        <tr>
                                            <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding:0px 30px 25px 30px;font-size:15px;line-height:24px">
                                                    URL : <a style="text-decoration: none; color: #1155cc;" href="{{ $mail_data['url'] }}">{{ $mail_data['url'] }}</a><br>
                                            </td>
                                        <tr>
                                        </tr>
                                            <td style="border-collapse:collapse;font-family:Roboto,sans-serif;padding:0px 30px 25px 30px;font-size:16px;line-height:26px">
                                                @lang('sistema.forgot_password_mail.see_you')<br>
                                                <strong>@lang('sistema.forgot_password_mail.team')</strong>
                                            </td>
                                        </tr>
                                     </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                </tr>
            </tbody>
        </table>

    </body>
</html>