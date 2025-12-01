<?php
require_once __DIR__ . '/../../config.php';
include(ROOT_PATH . "/include/vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;

require_once(ROOT_PATH . "/include/config.php");
require_once(ROOT_PATH . "/include/Email/smtp.php");

class USER
{
    private $conn;
}

//TITLE NAME
class pageTitle
{
    public $dashboard = 'Dashboard';
    public function getDashboard()
    {
        return $this->dashboard;
    }
}

class emailMessage
{
    public function LoginMsg($full_name, $user_acctno, $APP_NAME, $APP_NUMBER, $APP_EMAIL, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
                <html>
                        <head>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                            <title>Login Attempted from New IP address</title>
                            <style>
                            /* -------------------------------------
                                GLOBAL RESETS
                            ------------------------------------- */
                            
                            /*All the styling goes here*/
                            
                            img {
                                border: none;
                                -ms-interpolation-mode: bicubic;
                                max-width: 100%; 
                            }
                        
                            body {
                                background-color: #f6f6f6;
                                font-family: sans-serif;
                                -webkit-font-smoothing: antialiased;
                                font-size: 14px;
                                line-height: 1.4;
                                margin: 0;
                                padding: 0;
                                -ms-text-size-adjust: 100%;
                                -webkit-text-size-adjust: 100%; 
                            }
                        
                            table {
                                border-collapse: separate;
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                width: 100%; }
                                table td {
                                font-family: sans-serif;
                                font-size: 14px;
                                vertical-align: top; 
                            }
                        
                            /* -------------------------------------
                                BODY & CONTAINER
                            ------------------------------------- */
                        
                            .body {
                                background-color: #f6f6f6;
                                width: 100%; 
                            }
                        
                            /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                            .container {
                                display: block;
                                margin: 0 auto !important;
                                /* makes it centered */
                                max-width: 580px;
                                padding: 10px;
                                width: 580px; 
                            }
                        
                            /* This should also be a block element, so that it will fill 100% of the .container */
                            .content {
                                box-sizing: border-box;
                                display: block;
                                margin: 0 auto;
                                max-width: 580px;
                                padding: 10px; 
                            }
                        
                            /* -------------------------------------
                                HEADER, FOOTER, MAIN
                            ------------------------------------- */
                            .main {
                                background: #ffffff;
                                border-radius: 3px;
                                width: 100%; 
                            }
                        
                            .wrapper {
                                box-sizing: border-box;
                                padding: 20px; 
                            }
                        
                            .content-block {
                                padding-bottom: 10px;
                                padding-top: 10px;
                            }
                        
                            .footer {
                                clear: both;
                                margin-top: 10px;
                                text-align: center;
                                width: 100%; 
                            }
                                .footer td,
                                .footer p,
                                .footer span,
                                .footer a {
                                color: #999999;
                                font-size: 12px;
                                text-align: center; 
                            }
                        
                            /* -------------------------------------
                                TYPOGRAPHY
                            ------------------------------------- */
                            h1,
                            h2,
                            h3,
                            h4 {
                                color: #000000;
                                font-family: sans-serif;
                                font-weight: 400;
                                line-height: 1.4;
                                margin: 0;
                                margin-bottom: 30px; 
                            }
                        
                            h1 {
                                font-size: 35px;
                                font-weight: 300;
                                text-align: center;
                                text-transform: capitalize; 
                            }
                        
                            p,
                            ul,
                            ol {
                                font-family: sans-serif;
                                font-size: 14px;
                                font-weight: normal;
                                margin: 0;
                                margin-bottom: 15px; 
                            }
                                p li,
                                ul li,
                                ol li {
                                list-style-position: inside;
                                margin-left: 5px; 
                            }
                        
                            a {
                                color: #3498db;
                                text-decoration: underline; 
                            }
                        
                            /* -------------------------------------
                                BUTTONS
                            ------------------------------------- */
                            .btn {
                                box-sizing: border-box;
                                width: 100%; }
                                .btn > tbody > tr > td {
                                padding-bottom: 15px; }
                                .btn table {
                                width: auto; 
                            }
                                .btn table td {
                                background-color: #ffffff;
                                border-radius: 5px;
                                text-align: center; 
                            }
                                .btn a {
                                background-color: #ffffff;
                                border: solid 1px #3498db;
                                border-radius: 5px;
                                box-sizing: border-box;
                                color: #3498db;
                                cursor: pointer;
                                display: inline-block;
                                font-size: 14px;
                                font-weight: bold;
                                margin: 0;
                                padding: 12px 25px;
                                text-decoration: none;
                                text-transform: capitalize; 
                            }
                        
                            .btn-primary table td {
                                background-color: #3498db; 
                            }
                        
                            .btn-primary a {
                                background-color: #3498db;
                                border-color: #3498db;
                                color: #ffffff; 
                            }
                        
                            /* -------------------------------------
                                OTHER STYLES THAT MIGHT BE USEFUL
                            ------------------------------------- */
                            .last {
                                margin-bottom: 0; 
                            }
                        
                            .first {
                                margin-top: 0; 
                            }
                        
                            .align-center {
                                text-align: center; 
                            }
                        
                            .align-right {
                                text-align: right; 
                            }
                        
                            .align-left {
                                text-align: left; 
                            }
                        
                            .clear {
                                clear: both; 
                            }
                        
                            .mt0 {
                                margin-top: 0; 
                            }
                        
                            .mb0 {
                                margin-bottom: 0; 
                            }
                        
                            .preheader {
                                color: transparent;
                                display: none;
                                height: 0;
                                max-height: 0;
                                max-width: 0;
                                opacity: 0;
                                overflow: hidden;
                                mso-hide: all;
                                visibility: hidden;
                                width: 0; 
                            }
                        
                            .powered-by a {
                                text-decoration: none; 
                            }
                        
                            hr {
                                border: 0;
                                border-bottom: 1px solid #f6f6f6;
                                margin: 20px 0; 
                            }
                        
                            /* -------------------------------------
                                RESPONSIVE AND MOBILE FRIENDLY STYLES
                            ------------------------------------- */
                            @media only screen and (max-width: 620px) {
                                table.body h1 {
                                font-size: 28px !important;
                                margin-bottom: 10px !important; 
                                }
                                table.body p,
                                table.body ul,
                                table.body ol,
                                table.body td,
                                table.body span,
                                table.body a {
                                font-size: 16px !important; 
                                }
                                table.body .wrapper,
                                table.body .article {
                                padding: 10px !important; 
                                }
                                table.body .content {
                                padding: 0 !important; 
                                }
                                table.body .container {
                                padding: 0 !important;
                                width: 100% !important; 
                                }
                                table.body .main {
                                border-left-width: 0 !important;
                                border-radius: 0 !important;
                                border-right-width: 0 !important; 
                                }
                                table.body .btn table {
                                width: 100% !important; 
                                }
                                table.body .btn a {
                                width: 100% !important; 
                                }
                                table.body .img-responsive {
                                height: auto !important;
                                max-width: 100% !important;
                                width: auto !important; 
                                }
                            }
                        
                            /* -------------------------------------
                                PRESERVE THESE STYLES IN THE HEAD
                            ------------------------------------- */
                            @media all {
                                .ExternalClass {
                                width: 100%; 
                                }
                                .ExternalClass,
                                .ExternalClass p,
                                .ExternalClass span,
                                .ExternalClass font,
                                .ExternalClass td,
                                .ExternalClass div {
                                line-height: 100%; 
                                }
                                .apple-link a {
                                color: inherit !important;
                                font-family: inherit !important;
                                font-size: inherit !important;
                                font-weight: inherit !important;
                                line-height: inherit !important;
                                text-decoration: none !important; 
                                }
                                #MessageViewBody a {
                                color: inherit;
                                text-decoration: none;
                                font-size: inherit;
                                font-family: inherit;
                                font-weight: inherit;
                                line-height: inherit;
                                }
                                .btn-primary table td:hover {
                                background-color: #34495e !important; 
                                }
                                .btn-primary a:hover {
                                background-color: #34495e !important;
                                border-color: #34495e !important; 
                                } 
                            }
                        
                            </style>
                        </head>
                        <body>
                            <span class='preheader'>Signin Notifications</span>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                            <tr>
                                <td>&nbsp;</td>
                                <td class='container'>
                                <div class='content'>
                        
                                    <table role='presentation' class='main'>
                        
                                    <tr>
                                        <td class='wrapper'>
                                        <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                            <tr>
                                            <td>
                                                <h2>Hello $full_name</h2>
                                                
                                                <p>You recently logged into your $APP_NAME with account no $user_acctno. If this was you, you're all set!<br>
                                                If this wasn't you, please contact support on <strong>$APP_NUMBER</strong> or send an email to <a href='mailtp:$APP_EMAIL' target='_blank'>$APP_EMAIL</a>
                                                 immediately to help secure your account.</p><br><br>


                                                 <p>All the best,<br>
                                                $APP_NAME,</p>

                                            </td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                        
                                    </table>
                                </div>

                                <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
                                </td>
                            </tr>
                            </table>
                        </body>
                </html>";
    }

    public function DepositMsg($full_name, $amount, $trans_type, $trans_status, $refrence_id, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Transaction Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Transaction Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Dear $full_name </h2>
                                    <p>Your $trans_type of  $acct_currency$amount is $trans_status with the refrence id #$refrence_id</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function WithdrawMsg($full_name, $amount, $trans_type, $trans_status, $refrence_id, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Transaction Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Transaction Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name</h2>
                                    <p>Your $trans_type of $acct_currency$amount is $trans_status with the refrence id #$refrence_id</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function WireMsg($full_name, $amount, $account_type, $trans_type, $refrence_id, $swift_code, $routine_number, $description, $bank_country, $bank_name, $trans_status, $account_number, $account_name, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Wire Transfer Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Wire Transfer Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                       <tr>
    <td class='wrapper' >
        <table role='presentation' border='0' cellpadding='0' cellspacing='0' style='margin:0 auto;'>
            <tr>
                <td>
                    <h1 style='color:#003366; text-align:center;'>$APP_NAME</h1>
                    <h2>Hi $full_name,</h2>
                    <p>
                        Your $trans_type of <strong>$acct_currency$amount</strong> to $bank_name, $bank_country is $trans_status.<br>
                        Recipient: $account_name <br>
                        Account No: $account_number <br>
                        Account Type: $account_type <br>
                        Description: $description <br>
                        Reference: #$refrence_id <br>
                        ###### $swift_code | $routine_number #####
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>

            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function RegisterMsg($full_name, $acct_no, $acct_status, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
        <html>
                <head>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                    <title>Hi $full_name, Welcome to $APP_NAME!</title>
                    <style>
                    /* -------------------------------------
                        GLOBAL RESETS
                    ------------------------------------- */
                    
                    /*All the styling goes here*/
                    
                    img {
                        border: none;
                        -ms-interpolation-mode: bicubic;
                        max-width: 100%; 
                    }
                
                    body {
                        background-color: #f6f6f6;
                        font-family: sans-serif;
                        -webkit-font-smoothing: antialiased;
                        font-size: 14px;
                        line-height: 1.4;
                        margin: 0;
                        padding: 0;
                        -ms-text-size-adjust: 100%;
                        -webkit-text-size-adjust: 100%; 
                    }
                
                    table {
                        border-collapse: separate;
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        width: 100%; }
                        table td {
                        font-family: sans-serif;
                        font-size: 14px;
                        vertical-align: top; 
                    }
                
                    /* -------------------------------------
                        BODY & CONTAINER
                    ------------------------------------- */
                
                    .body {
                        background-color: #f6f6f6;
                        width: 100%; 
                    }
                
                    /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                    .container {
                        display: block;
                        margin: 0 auto !important;
                        /* makes it centered */
                        max-width: 580px;
                        padding: 10px;
                        width: 580px; 
                    }
                
                    /* This should also be a block element, so that it will fill 100% of the .container */
                    .content {
                        box-sizing: border-box;
                        display: block;
                        margin: 0 auto;
                        max-width: 580px;
                        padding: 10px; 
                    }
                
                    /* -------------------------------------
                        HEADER, FOOTER, MAIN
                    ------------------------------------- */
                    .main {
                        background: #ffffff;
                        border-radius: 3px;
                        width: 100%; 
                    }
                
                    .wrapper {
                        box-sizing: border-box;
                        padding: 20px; 
                    }
                
                    .content-block {
                        padding-bottom: 10px;
                        padding-top: 10px;
                    }
                
                    .footer {
                        clear: both;
                        margin-top: 10px;
                        text-align: center;
                        width: 100%; 
                    }
                        .footer td,
                        .footer p,
                        .footer span,
                        .footer a {
                        color: #999999;
                        font-size: 12px;
                        text-align: center; 
                    }
                
                    /* -------------------------------------
                        TYPOGRAPHY
                    ------------------------------------- */
                    h1,
                    h2,
                    h3,
                    h4 {
                        color: #000000;
                        font-family: sans-serif;
                        font-weight: 400;
                        line-height: 1.4;
                        margin: 0;
                        margin-bottom: 30px; 
                    }
                
                    h1 {
                        font-size: 35px;
                        font-weight: 300;
                        text-align: center;
                        text-transform: capitalize; 
                    }
                
                    p,
                    ul,
                    ol {
                        font-family: sans-serif;
                        font-size: 14px;
                        font-weight: normal;
                        margin: 0;
                        margin-bottom: 15px; 
                    }
                        p li,
                        ul li,
                        ol li {
                        list-style-position: inside;
                        margin-left: 5px; 
                    }
                
                    a {
                        color: #3498db;
                        text-decoration: underline; 
                    }
                
                    /* -------------------------------------
                        BUTTONS
                    ------------------------------------- */
                    .btn {
                        box-sizing: border-box;
                        width: 100%; }
                        .btn > tbody > tr > td {
                        padding-bottom: 15px; }
                        .btn table {
                        width: auto; 
                    }
                        .btn table td {
                        background-color: #ffffff;
                        border-radius: 5px;
                        text-align: center; 
                    }
                        .btn a {
                        background-color: #ffffff;
                        border: solid 1px #3498db;
                        border-radius: 5px;
                        box-sizing: border-box;
                        color: #3498db;
                        cursor: pointer;
                        display: inline-block;
                        font-size: 14px;
                        font-weight: bold;
                        margin: 0;
                        padding: 12px 25px;
                        text-decoration: none;
                        text-transform: capitalize; 
                    }
                
                    .btn-primary table td {
                        background-color: #3498db; 
                    }
                
                    .btn-primary a {
                        background-color: #3498db;
                        border-color: #3498db;
                        color: #ffffff; 
                    }
                
                    /* -------------------------------------
                        OTHER STYLES THAT MIGHT BE USEFUL
                    ------------------------------------- */
                    .last {
                        margin-bottom: 0; 
                    }
                
                    .first {
                        margin-top: 0; 
                    }
                
                    .align-center {
                        text-align: center; 
                    }
                
                    .align-right {
                        text-align: right; 
                    }
                
                    .align-left {
                        text-align: left; 
                    }
                
                    .clear {
                        clear: both; 
                    }
                
                    .mt0 {
                        margin-top: 0; 
                    }
                
                    .mb0 {
                        margin-bottom: 0; 
                    }
                
                    .preheader {
                        color: transparent;
                        display: none;
                        height: 0;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                        mso-hide: all;
                        visibility: hidden;
                        width: 0; 
                    }
                
                    .powered-by a {
                        text-decoration: none; 
                    }
                
                    hr {
                        border: 0;
                        border-bottom: 1px solid #f6f6f6;
                        margin: 20px 0; 
                    }
                
                    /* -------------------------------------
                        RESPONSIVE AND MOBILE FRIENDLY STYLES
                    ------------------------------------- */
                    @media only screen and (max-width: 620px) {
                        table.body h1 {
                        font-size: 28px !important;
                        margin-bottom: 10px !important; 
                        }
                        table.body p,
                        table.body ul,
                        table.body ol,
                        table.body td,
                        table.body span,
                        table.body a {
                        font-size: 16px !important; 
                        }
                        table.body .wrapper,
                        table.body .article {
                        padding: 10px !important; 
                        }
                        table.body .content {
                        padding: 0 !important; 
                        }
                        table.body .container {
                        padding: 0 !important;
                        width: 100% !important; 
                        }
                        table.body .main {
                        border-left-width: 0 !important;
                        border-radius: 0 !important;
                        border-right-width: 0 !important; 
                        }
                        table.body .btn table {
                        width: 100% !important; 
                        }
                        table.body .btn a {
                        width: 100% !important; 
                        }
                        table.body .img-responsive {
                        height: auto !important;
                        max-width: 100% !important;
                        width: auto !important; 
                        }
                    }
                
                    /* -------------------------------------
                        PRESERVE THESE STYLES IN THE HEAD
                    ------------------------------------- */
                    @media all {
                        .ExternalClass {
                        width: 100%; 
                        }
                        .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                        line-height: 100%; 
                        }
                        .apple-link a {
                        color: inherit !important;
                        font-family: inherit !important;
                        font-size: inherit !important;
                        font-weight: inherit !important;
                        line-height: inherit !important;
                        text-decoration: none !important; 
                        }
                        #MessageViewBody a {
                        color: inherit;
                        text-decoration: none;
                        font-size: inherit;
                        font-family: inherit;
                        font-weight: inherit;
                        line-height: inherit;
                        }
                        .btn-primary table td:hover {
                        background-color: #34495e !important; 
                        }
                        .btn-primary a:hover {
                        background-color: #34495e !important;
                        border-color: #34495e !important; 
                        } 
                    }
                
                    </style>
                </head>
                <body>
                    <span class='preheader'>Welcome Email Notification</span>
                    <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                    <tr>
                        <td>&nbsp;</td>
                        <td class='container'>
                        <div class='content'>
                
                            <table role='presentation' class='main'>
                
                            <tr>
                                <td class='wrapper'>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                    <tr>
                                    <td>
                                    <h2>Dear $full_name,</h2>
                                    <p><strong>Welcome to $APP_NAME</strong>
                                    <<br><br><br>Thank you for registering at $APP_NAME.<br>
                                    <strong>$acct_no</strong> We are excited to see you create with us.<br><br>
                                    If you need any assitance, our support team is here to help. Do not hesitate to <a href='$APP_URL'>contact us</a>
                                    if you have any questions or concern.<br><br>
                                    Account Status: $acct_status</p>
                                    </td>
                                    </tr>
                                </table>
                                </td>
                            </tr>
                
                            </table></div>
                
                            <div class='footer'>
                                <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                    <td class='content-block'>
                                         <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                         <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                                </td>
                            </tr>
                            <tr>
                                <td class='content-block powered-by'>
                                    2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                                </td>
                            </tr>
                                </table>
                            </div>
        
                        </td>
                    </tr>
                    </table>
                </body>
        </html>";
    }

    public function ForgotMsg($full_name, $email, $user_acctno, $reset_token, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Password Reset Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Password Reset Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name,</h2>
                                    <p>we got a request on account with the account number: <strong>$user_acctno</strong> to reset Password! <br>Click the link below to get started: <br>
                                    <a href='$APP_URL/updatePassword.php?email=$email&reset_token=$reset_token'>reset password.</a></p><br><br>
                                    <p>Copy to browser<br>
                                    $APP_URL/updatePassword.php?email=$email&reset_token=$reset_token
                                    <br><br>This wasn't you? kindly ignore this request!
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function DomMsg($full_name, $amount, $account_number, $account_name, $account_type, $bank_country, $trans_type, $refrence_id, $trans_status, $acct_currency, $description, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Domestic Transfer Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Domestic Transfer Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                    <h1 style='color:#003366; text-align:center;'>$APP_NAME</h1>
                    <h2>Hi $full_name,</h2>
                    <p>
                        Your $trans_type of <strong>$acct_currency$amount</strong>  is $trans_status.<br>
                        Recipient: $account_name <br>
                        Account No: $account_number <br>
                        Account Type: $account_type <br>
                        Description: $description <br>
                        Reference: #$refrence_id <br> 
                    </p>
                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function pinRequest($full_name, $acct_otp, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>One-time Code Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>One-time Code Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name,</h2>
                                    <p>Kindly use <strong>$acct_otp</strong> to validate your One-Time Code.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function InterMsg($full_name, $amount, $account_number, $account_name, $refrence_id, $trans_type, $trans_status, $acct_currency, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Interbank Transfer Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Interbank Transfer Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                <h2>Hi $full_name,</h2>
                                <p>Your $trans_type of <strong>$acct_currency$amount</strong> to  $account_number, $account_name with the refrence id #$refrence_id is $trans_status.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function StockMsg($full_name, $amount, $account_name, $APP_NAME, $trans_type, $trans_status, $refrence_id, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Stock Purchase Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Stock Purchase Transaction</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name</h2>
                                    <p>Your $trans_type of <strong>$account_name - $$amount</strong> is $trans_status with theb refrence id #$refrence_id</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function LoanMsg($full_name, $amount, $user_acctno, $trans_type, $trans_status, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Loan Request Notification</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Loan Request Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name</h2>
                                    <p>Your $trans_type Request with the amount $$amount on your account $user_acctno is $trans_status.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function PasswordMsg($full_name, $user_acctno, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Password Change Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Password Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name,</h2>
                                    <p>We notice you made a password change to your account: $user_acctno.<br>
                                    If this was you, you're all set!<br>
                                    If this wasn't you, Please contact support immediately to help you secure your account!.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function PinMsg($full_name, $user_acctno, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Pin Change Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Pin Change Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                <h2>Hi $full_name,</h2>
                                <p>We notice you made a password change to your account: $user_acctno.<br>
                                If this was you, you're all set!<br>
                                If this wasn't you, Please contact support immediately to help you secure your account!.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function CardMsg($full_name, $card_name, $user_acctno, $amount, $card_status, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Card Request Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Card Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                        <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name,</h2>
                                    <p>You have been charged with a fee of $$amount for $card_name on account:  $user_acctno request and it is $card_status.</p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }

    public function TicketMsg($full_name, $user_acctno, $ticket_message, $ticket_status, $APP_NAME, $APP_URL, $SITE_ADDRESS)
    {
        return "<!doctype html>
    <html>
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'/>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Ticket Notifications</title>
                <style>
                /* -------------------------------------
                    GLOBAL RESETS
                ------------------------------------- */
                
                /*All the styling goes here*/
                
                img {
                    border: none;
                    -ms-interpolation-mode: bicubic;
                    max-width: 100%; 
                }
            
                body {
                    background-color: #f6f6f6;
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                    padding: 0;
                    -ms-text-size-adjust: 100%;
                    -webkit-text-size-adjust: 100%; 
                }
            
                table {
                    border-collapse: separate;
                    mso-table-lspace: 0pt;
                    mso-table-rspace: 0pt;
                    width: 100%; }
                    table td {
                    font-family: sans-serif;
                    font-size: 14px;
                    vertical-align: top; 
                }
            
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
            
                .body {
                    background-color: #f6f6f6;
                    width: 100%; 
                }
            
                /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
                .container {
                    display: block;
                    margin: 0 auto !important;
                    /* makes it centered */
                    max-width: 580px;
                    padding: 10px;
                    width: 580px; 
                }
            
                /* This should also be a block element, so that it will fill 100% of the .container */
                .content {
                    box-sizing: border-box;
                    display: block;
                    margin: 0 auto;
                    max-width: 580px;
                    padding: 10px; 
                }
            
                /* -------------------------------------
                    HEADER, FOOTER, MAIN
                ------------------------------------- */
                .main {
                    background: #ffffff;
                    border-radius: 3px;
                    width: 100%; 
                }
            
                .wrapper {
                    box-sizing: border-box;
                    padding: 20px; 
                }
            
                .content-block {
                    padding-bottom: 10px;
                    padding-top: 10px;
                }
            
                .footer {
                    clear: both;
                    margin-top: 10px;
                    text-align: center;
                    width: 100%; 
                }
                    .footer td,
                    .footer p,
                    .footer span,
                    .footer a {
                    color: #999999;
                    font-size: 12px;
                    text-align: center; 
                }
            
                /* -------------------------------------
                    TYPOGRAPHY
                ------------------------------------- */
                h1,
                h2,
                h3,
                h4 {
                    color: #000000;
                    font-family: sans-serif;
                    font-weight: 400;
                    line-height: 1.4;
                    margin: 0;
                    margin-bottom: 30px; 
                }
            
                h1 {
                    font-size: 35px;
                    font-weight: 300;
                    text-align: center;
                    text-transform: capitalize; 
                }
            
                p,
                ul,
                ol {
                    font-family: sans-serif;
                    font-size: 14px;
                    font-weight: normal;
                    margin: 0;
                    margin-bottom: 15px; 
                }
                    p li,
                    ul li,
                    ol li {
                    list-style-position: inside;
                    margin-left: 5px; 
                }
            
                a {
                    color: #3498db;
                    text-decoration: underline; 
                }
            
                /* -------------------------------------
                    BUTTONS
                ------------------------------------- */
                .btn {
                    box-sizing: border-box;
                    width: 100%; }
                    .btn > tbody > tr > td {
                    padding-bottom: 15px; }
                    .btn table {
                    width: auto; 
                }
                    .btn table td {
                    background-color: #ffffff;
                    border-radius: 5px;
                    text-align: center; 
                }
                    .btn a {
                    background-color: #ffffff;
                    border: solid 1px #3498db;
                    border-radius: 5px;
                    box-sizing: border-box;
                    color: #3498db;
                    cursor: pointer;
                    display: inline-block;
                    font-size: 14px;
                    font-weight: bold;
                    margin: 0;
                    padding: 12px 25px;
                    text-decoration: none;
                    text-transform: capitalize; 
                }
            
                .btn-primary table td {
                    background-color: #3498db; 
                }
            
                .btn-primary a {
                    background-color: #3498db;
                    border-color: #3498db;
                    color: #ffffff; 
                }
            
                /* -------------------------------------
                    OTHER STYLES THAT MIGHT BE USEFUL
                ------------------------------------- */
                .last {
                    margin-bottom: 0; 
                }
            
                .first {
                    margin-top: 0; 
                }
            
                .align-center {
                    text-align: center; 
                }
            
                .align-right {
                    text-align: right; 
                }
            
                .align-left {
                    text-align: left; 
                }
            
                .clear {
                    clear: both; 
                }
            
                .mt0 {
                    margin-top: 0; 
                }
            
                .mb0 {
                    margin-bottom: 0; 
                }
            
                .preheader {
                    color: transparent;
                    display: none;
                    height: 0;
                    max-height: 0;
                    max-width: 0;
                    opacity: 0;
                    overflow: hidden;
                    mso-hide: all;
                    visibility: hidden;
                    width: 0; 
                }
            
                .powered-by a {
                    text-decoration: none; 
                }
            
                hr {
                    border: 0;
                    border-bottom: 1px solid #f6f6f6;
                    margin: 20px 0; 
                }
            
                /* -------------------------------------
                    RESPONSIVE AND MOBILE FRIENDLY STYLES
                ------------------------------------- */
                @media only screen and (max-width: 620px) {
                    table.body h1 {
                    font-size: 28px !important;
                    margin-bottom: 10px !important; 
                    }
                    table.body p,
                    table.body ul,
                    table.body ol,
                    table.body td,
                    table.body span,
                    table.body a {
                    font-size: 16px !important; 
                    }
                    table.body .wrapper,
                    table.body .article {
                    padding: 10px !important; 
                    }
                    table.body .content {
                    padding: 0 !important; 
                    }
                    table.body .container {
                    padding: 0 !important;
                    width: 100% !important; 
                    }
                    table.body .main {
                    border-left-width: 0 !important;
                    border-radius: 0 !important;
                    border-right-width: 0 !important; 
                    }
                    table.body .btn table {
                    width: 100% !important; 
                    }
                    table.body .btn a {
                    width: 100% !important; 
                    }
                    table.body .img-responsive {
                    height: auto !important;
                    max-width: 100% !important;
                    width: auto !important; 
                    }
                }
            
                /* -------------------------------------
                    PRESERVE THESE STYLES IN THE HEAD
                ------------------------------------- */
                @media all {
                    .ExternalClass {
                    width: 100%; 
                    }
                    .ExternalClass,
                    .ExternalClass p,
                    .ExternalClass span,
                    .ExternalClass font,
                    .ExternalClass td,
                    .ExternalClass div {
                    line-height: 100%; 
                    }
                    .apple-link a {
                    color: inherit !important;
                    font-family: inherit !important;
                    font-size: inherit !important;
                    font-weight: inherit !important;
                    line-height: inherit !important;
                    text-decoration: none !important; 
                    }
                    #MessageViewBody a {
                    color: inherit;
                    text-decoration: none;
                    font-size: inherit;
                    font-family: inherit;
                    font-weight: inherit;
                    line-height: inherit;
                    }
                    .btn-primary table td:hover {
                    background-color: #34495e !important; 
                    }
                    .btn-primary a:hover {
                    background-color: #34495e !important;
                    border-color: #34495e !important; 
                    } 
                }
            
                </style>
            </head>
            <body>
                <span class='preheader'>Ticket Notifications</span>
                <table role='presentation' border='0' cellpadding='0' cellspacing='0' class='body'>
                <tr>
                    <td>&nbsp;</td>
                    <td class='container'>
                    <div class='content'>
            
                         <table role='presentation' class='main'>
            
                        <tr>
                            <td class='wrapper'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                                <tr>
                                <td>
                                    <h2>Hi $full_name,</h2>
                                    <p>Your Ticket Status on Account: $user_acctno is $ticket_status and been reviewed.<br><br><br>
                                    Message: <strong>$ticket_message</strong>
                                    </p>
                                </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
            
                        </table></div>
            
                        <div class='footer'>
                            <table role='presentation' border='0' cellpadding='0' cellspacing='0'>
                            <tr>
                                <td class='content-block'>
                                     <span class='apple-link'>$APP_NAME, $SITE_ADDRESS</span>
                                     <br> Don't like these emails? <a href='#'>Unsubscribe</a>.
                            </td>
                        </tr>
                        <tr>
                            <td class='content-block powered-by'>
                                2025 Copyright - <a href='$APP_URL'>$APP_NAME</a>.
                            </td>
                        </tr>
                            </table>
                        </div>
    
                    </td>
                </tr>
                </table>
            </body>
    </html>";
    }
}