<!DOCTYPE html>
<html>
    <head>
        <title>Cancel Subscription</title>
        <style>
            .main{width: 100%;background: #575757;padding-top:50px;padding-bottom: 50px;}
            .table{
                border: 0;
                width: 80%;
                background-color: #fff;
                border-radius: 5px;
                font-family: arial;
            }
            table tbody tr td{
                padding:0 20px 10px 20px;
            }
            .td-logo{
                text-align: center;
            }
            .td-logo{
                text-align: center;
            }
            .h3{
                padding: 0px;
                margin-bottom:3px;
                color: black;
                font-weight:normal;
                font:15px normal Helvetica,Arial,sans-serif;
                color:black;
            }
            .p1{
                background-color:#fff;font:15px normal Helvetica,Arial,sans-serif;color:black;line-height: 1.6em;
            }
            .p2{
                background-color:#fff;font:15px normal Helvetica,Arial,sans-serif;color:black;line-height: 1.6em;
            }
            .plan-btn{
                text-decoration: none;color: black;background: #3bfbe8;padding: 5px;border-radius: 4px;box-shadow: 3px 3px 5px grey;
            }
            .btn{
                border-radius: 2px;
                padding: 6px 14px;
            }
            .btn-primary{
                background-color: #F27F00;
                border: 1px solid #f18814;
                color: #fff;
                text-decoration: none;
            }
        </style>
    </head>
    <body>
        <div class="main">
            <table class="table" cellspacing="5" align="center">
                <tbody>
                    <tr>
                        <td class="td-logo" align="center">
                            <img src="{{ url($settings->company_statement_logo) }}" height="50px" width="auto"><br/>
                        </td>
                    </tr>
                    <tr style="">
                        <td style="color: black;text-align: left;font-size: 16px;">
                            <p class="h3" style="font-size: 16px;">                                
                                ¡Hola!, {{ $user_name or 'User' }}
                            </p>
                        </td>
                    </tr>                                    
                    <tr style="color: black;">
                        <td  style="font-size: 16px;padding-bottom:15px;">
                            <p>@lang('sistema.trade_report.email_content1') {{  $period }}</p>
                            <div style="font-size: 14px;border-top: 2px solid #c0c0c0;border-bottom: 2px solid #c0c0c0;">
                                <p><b>@lang('sistema.trade_report.email_content2')</b></p>
                                <p>@lang('sistema.trade_report.email_content3')</p>
                                <p>@lang('sistema.trade_report.email_content4')</p>
                            </div>
                        </td>
                    </tr>                                                       
                    <tr style="color: black;">
                        <td style="font-size: 16px;padding-bottom:0px;">{{ $settings->admin_name }}</td>
                    </tr>                                        
                    <tr style="color: black;">
                        <td style="font-size: 16px;padding-bottom:0px;">
                            <a style="color: black;text-decoration: none;" href="{{ $settings->website_url }}" class="text-muted">{{ $settings->website_url }}</a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr style="">
                        <td>
                            <p style="background: #F3C575;padding: 10px;display: block;margin-top: 15px;"></p>
                        </td>
                    </tr>                    
                </tfoot>
            </table>
        </div>
    </body>
</html>