<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <title>Emailer</title>
    <!-- ======================================================================== -->
    <link rel="icon" type="{{ url('/assets/admin/') }}/images/png" sizes="16x16" href="images/favicon.ico" />
    <!-- Bootstrap CSS -->


    <!--common header footer script end-->
    <style type="text/css">
        .listed-btn a { color: #fff; display: block; font-size: 18px; letter-spacing: 0.4px;background-color:#8f4799;
            margin: 0 auto; max-width: 204px; padding: 9px 4px; height: initial; text-align: center; text-transform: lowercase; text-decoration: none; width: 100%;box-shadow: 0 5px 10px 0 rgba(55, 94, 246, .2);
            border-radius:50px;}
            .listed-btn a:hover{background-color:#8f4799;}
            .logo-bg{padding: 10px 20px 3px;width:100px;}
        </style>
</head>


    <body style="background:#f1f1f1; margin:0px; padding:0px; font-size:12px; font-family:'roboto', sans-serif; line-height:21px; color:#666; text-align:justify;">
        <div style="max-width:630px;width:100%;margin:0 auto;">
            <div style="padding:0px 15px;margin-top: 30px;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="border:1px solid #e5e5e5;">
                            <table style="margin-bottom: 0;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr >
                                    <td style=" color: #333;font-size: 15px; text-align: center;">
                                        <table style="margin-bottom: 0;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="text-align:center;background-color:#8f4799;">
                                                    <a href="{{ url('/') }}"><img src="{{ url('/assets/admin/') }}/images/logo.png" class="logo-bg" alt="logo"/></a>
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height="20"></td>
                                </tr>
                                <tr><td style="color: rgb(51, 51, 51); text-align: center; font-size: 19px; line-height: 24px; padding-top: 3px;">Welcome To {{config('app.project.name')}}</td></tr>
                                <tr><td style="color: #333333;font-size: 15px;padding-top: 3px;text-align: center;">Forgot Password</td></tr>

                                <tr>
                                    <td height="40"></td>
                                </tr>
                                <tr>
                                    <td style="color: #333333; font-size: 16px; padding: 0 30px;">
                                        Hello <span style="color:#8f4799;font-family: 'Latomedium',sans-serif;">{{ $username ?? '' }},</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color: #545454;font-size: 15px;padding: 12px 30px;">
                                        You recently requested for reset your password for {{config('app.project.name')}} project account. Click below button to reset it.
                                    </td>
                                </tr>

                                <tr>
                                    <td height="20"></td>
                                </tr>

                                <tr><td class="listed-btn">{{ $link ?? '' }}</td></tr>
                                <tr>
                                    <td height="40"></td>
                                </tr>
                                <tr>
                                    <td style="color: #333333; font-size: 16px; padding: 0 30px;">
                                        Thanks &amp; Regards,
                                    </td>
                                </tr>

                                <tr>
                                    <td style="color: #8f4799;  font-size: 15px; padding: 0 30px;">
                                        {{config('app.project.name')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>                                    
                                <tr>
                                    <td>
                                        <table style="margin-bottom: 0;" width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="font-size:13px;background-color:#8f4799;text-align: center; color: rgb(255, 255, 255); padding: 12px;">
                                                    Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}" style="color:#dabeff;">{{config('app.project.name')}}</a>. All Rights Reserved.  <a href="#" style="color:#dabeff;">Terms &amp; Conditions</a>
                                                </td>

                                            </tr>
                                        </table>
                                    </td>             
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </table>
            </div>      
        </div>       
    </body>
</html>