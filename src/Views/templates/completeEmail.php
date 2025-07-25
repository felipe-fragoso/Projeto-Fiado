<?php
    ob_start();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title></title>
        <!--[if !mso]><!-- -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<![endif]-->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style type="text/css">
            #outlook a {
                padding: 0;
            }

            .ReadMsgBody {
                width: 100%;
            }

            .ExternalClass {
                width: 100%;
            }

            .ExternalClass * {
                line-height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                -webkit-text-size-adjust: 100%;
                -ms-text-size-adjust: 100%;
            }

            /* stylelint-disable */
            table,
            td {
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
            }
        </style>
        <!--[if !mso]><!-->
        <style type="text/css">
            @media only screen and (max-width:480px) {
                @-ms-viewport {
                    width: 320px;
                }

                @viewport {
                    width: 320px;
                }
            }
        </style>
        <!--<![endif]-->
        <!--[if mso]><xml>  <o:OfficeDocumentSettings>    <o:AllowPNG/>    <o:PixelsPerInch>96</o:PixelsPerInch>  </o:OfficeDocumentSettings></xml><![endif]-->
        <!--[if lte mso 11]><style type="text/css">  .outlook-group-fix {    width:100% !important;  }</style><![endif]-->
        <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"
            type="text/css">
        <style type="text/css">
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap');
        </style>
        <!--<![endif]-->
        <style type="text/css">
            @media only screen and (max-width:595px) {
                .container {
                    width: 100% !important;
                }

                .button {
                    display: block !important;
                    width: auto !important;
                }
            }
        </style>
    </head>

    <body style="font-family: 'Inter', sans-serif; background: #E5E5E5;">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#F6FAFB">
            <tbody>
                <tr>
                    <td valign="top" align="center">
                        <table class="container" width="600" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td
                                        style="padding:48px 0 30px 0; text-align: center; font-size: 14px; color: #4C83EE;">
                                        <?=$companyName?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="main-content" style="padding: 48px 30px 40px; color: #000000;"
                                        bgcolor="#ffffff">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding: 0 0 24px 0; font-size: 18px; line-height: 150%; font-weight: bold; color: #000000; letter-spacing: 0.01em;">
                                                        Olá <strong><?=$username?></strong>,
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                                        Obrigado por se registrar em nosso site! Para garantir seu
                                                        acesso completo, é necessário concluir seu cadastro.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 0 0 16px 0; font-size: 14px; line-height: 150%; font-weight: 700; color: #000000; letter-spacing: 0.01em;">
                                                        Clique no link abaixo para definir sua senha e finalizar seu
                                                        perfil:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0 0 24px 0;">
                                                        <a class="button" href="<?=$link?>" title="Completar cadastro"
                                                            style="width: 100%; background: #22D172; text-decoration: none; display: inline-block; padding: 10px 0; color: #fff; font-size: 14px; line-height: 21px; text-align: center; font-weight: bold; border-radius: 7px;">
                                                            Completar Cadastro
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 0 0 10px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                                        Se você não realizou esse registro, ignore este email.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 0 0 60px 0; font-size: 14px; line-height: 150%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                                        Caso tenha dúvidas, nossa equipe está pronta para ajudar!
                                                        <a href="mailto:<?=$supportEmail?>"><?=$supportEmail?></a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding: 0 0 16px;">
                                                        <span
                                                            style="display: block; width: 117px; border-bottom: 1px solid #8B949F;"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="font-size: 14px; line-height: 170%; font-weight: 400; color: #000000; letter-spacing: 0.01em;">
                                                        Atenciosamente,<br><strong><?=$companyName?></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 24px 0 48px; font-size: 0px;">
                                        <!--[if mso | IE]>      <table role="presentation" border="0" cellpadding="0" cellspacing="0">        <tr>          <td style="vertical-align:top;width:300px;">      <![endif]-->
                                        <div class="outlook-group-fix"
                                            style="padding: 0 0 20px 0; vertical-align: top; display: inline-block; text-align: center; width:100%;">
                                            <span
                                                style="padding: 0; font-size: 11px; line-height: 15px; font-weight: normal; color: #8B949F;">
                                                <?=$companyLegalName?><br /><?=$companyAddress?>
                                            </span>
                                        </div>
                                        <!--[if mso | IE]>      </td></tr></table>      <![endif]-->
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
<?php
    return [
        'body' => ob_get_clean(),
        'altBody' => "Olá {$username},

Obrigado por se registrar em nosso site! Para garantir seu acesso completo, é necessário concluir seu cadastro.
Clique no link abaixo para definir sua senha e finalizar seu perfil:

{$link}

Se você não realizou esse registro, ignore este email.
Caso tenha dúvidas, nossa equipe está pronta para ajudar! {$supportEmail}

Atenciosamente,
{$companyName}

{$companyLegalName}
{$companyAddress}",
];