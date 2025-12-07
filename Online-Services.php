<?php include "config.php"
?>

<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8">

<head>


    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                layout: google.translate.TranslateElement.InlineLayout.SIMPLE
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="translate.google.com/translate_a/fa0d8a0d8.txt?cb=googleTranslateElementInit"></script>



    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">


    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="manifest.json">
    <link rel="mask-icon" href="safari-pinned-tab.svg" color="#001789">
    <link rel="shortcut icon" href="faviconbcfe.ico?v=22">
    <meta name="msapplication-TileColor" content="#001789">
    <meta name="theme-color" content="#001789">

    <link href="css.css?family=Didact+Gothic|Open+Sans:400,700" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/font-awesome-4.7.0-min.css">
    <link type="text/css" rel="stylesheet" href="css/animate.css">
    <link type="text/css" rel="stylesheet" href="css/fiserv.css">
    <link href="css/slideshow6654.css?v1" rel="stylesheet">
    <link href="css/nav.css" rel="stylesheet">
    <link href="css/nav-home.css" rel="stylesheet">
    <link href="weather/weather.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/style6654.css?v1">
    <link type="text/plain" rel="author" href="humans.txt">
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <title>Online Services | <?php echo $name; ?> <?php echo $country; ?></title>
    <meta name="description" content="Online Services | <?php echo $name; ?> <?php echo $country; ?>">
    <meta name="keywords" content="">
</head>

<body class="" id="top">
    <!-- Segment Pixel - AL - <?php echo $name; ?> - Site - DO NOT MODIFY -->
    <img src="seg.gif?add=4701443&amp;t=2" width="1" height="1" class="visuallyhidden" alt="">
    <!-- End of Segment Pixel -->


    <!--<div id="notice-android" class="notice appbanner">
        <div style="position:relative">
            <div class="noticeHtml inner-content">
                <div class="apps">
                    <a class="app personal" href="">
                        <div class="sb-icon"><img src="images/App-Icon-Android.png" alt="Google Play Personal App Icon"></div>
                        <div class="sb-text">
                            <span class="sb-app-name">TouchBanking</span>
                            <span class="sb-app-company">FMDC, Inc.</span>
                            <span class="sb-app-store"><span class="sb-price">FREE</span> In Google Play</span>
                        </div>
                        <div class="sb-button">View</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="notice-iphone" class="notice appbanner">
        <div style="position:relative">
            <div class="noticeHtml inner-content">
                <div class="apps">
                    <a class="app personal" href="">
                        <div class="sb-icon"><img src="images/App-Icon-iPhone.jpg" alt="Apple Personal iphone App Icon"></div>
                        <div class="sb-text">
                            <span class="sb-app-name">TouchBanking</span>
                            <span class="sb-app-company">FMDC, Inc.</span>
                            <span class="sb-app-store"><span class="sb-price">FREE</span> In iTunes</span>
                        </div>
                        <div class="sb-button">View</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="notice" class="notice">
        <div style="position: relative">
            <div class="noticeHtml">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td>
                                <p>For the health and safety of our customers and employees, please continue to use our Drive-Up Window service at all branches.&nbsp; Lobby visits by appointment only.&nbsp; Thank you.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    -->
    <div class="page">
        <header>
            <nav id="primary">
                <div class="inner-content">
                    <div>
                        <a href="index.php" class="mobile-logo">

                            <img src="<?php echo $url; ?>/admin/assets/images/logo/<?php echo $image; ?>" alt=" <?php echo $name; ?> Logo"><span class="visuallyhidden"> <?php echo $name; ?> Logo</span></a>
                        <div>
                            <a href="javascript:void(0)" id="loginopen" class="Button1 fa-lock login-button"><span>Login</span></a>
                            <a href="javascript:void(0)" id="menuopen" class="fa-bars"><span class="visuallyhidden">Menu</span></a>
                        </div>
                    </div>

                    <div id="toolbar-wrapper">
                        <ul id="toolbar" class="animated dsm slideInRight">

                            <li class="">
                                <a href="Contact-Us.php">
                                    <i class="toolbar-section fa fa-phone"></i>
                                    Call Us</a>
                            </li>
                            <li class="">
                                <a href="mailto: <?php echo $email; ?>">
                                    <i class="toolbar-section fa fa-envelope"></i>
                                    Email Us</a>
                            </li>
                            <li>
                                <a href="Branch-Locations.php">
                                    <i class="toolbar-section fa fa-map-marker"></i>
                                    Find Us</a>
                            </li>
                            <li class="">
                                <a href="Mortgage-Team.php#Apply-Now">
                                    <i class="toolbar-section fa fa-home"></i>
                                    Apply Now</a>
                            </li>
                            <li class="">
                                <a href="https://www.facebook.com/">
                                    <i class="toolbar-section fa fa-facebook"></i>
                                    Like Us</a>
                            </li>

                            <li class="weather-panel">
                                <div class="weather-trigger">
                                    <i class="toolbar-section fa fa-cloud"></i>
                                </div>
                                <div id="widgetcontentWeather" class="promocontent">
                                    <div id="weather"></div>
                                </div>
                            </li>
                        </ul>
                    </div> <!--/toolbar-wrapper-->
                    <ul>

                        <li id="logo"><a href="index.php"><img src="<?php echo $url; ?>/admin/assets/images/logo/<?php echo $image; ?>" alt=" <?php echo $name; ?> Logo"></a></li>
                        <li>
                            <a href="javascript:void(0)"><span>Deposit</span> Accounts</a>
                            <div>
                                <div>
                                    <ul>
                                        <li><a href="Checking.php">Checking</a></li>
                                        <li><a href="Savings.php">Savings</a></li>
                                        <li><a href="Catastrophe-Savings.php">Catastrophe Savings</a></li>
                                        <li><a href="CD-IRA.php">Certificate of Deposit</a></li>
                                        <li><a href="CD-IRA.php#IRA">Individual Retirement Account</a></li>
                                        <li><a href="Business-Checking.php">Business Checking</a></li>
                                        <li><a href="Rates.php">Interest Rates</a></li>
                                    </ul>
                                </div>

                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><span>Mortgage</span> Lending</a>
                            <div>
                                <div>
                                    <ul>
                                        <li><a href="Construction.php">Construction Loan</a></li>
                                        <li><a href="Mortgage-Loans.php">Mortgage Loans</a></li>
                                        <li><a href="Mortgage-Team.php">Meet The Team</a></li>
                                        <li><a href="Mortgage-Team.php#Apply-Now">Apply Now</a></li>
                                        <li><a href="Calculators.php">Calculators</a></li>
                                    </ul>
                                </div>

                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><span>Account</span> Services</a>
                            <div>
                                <div>
                                    <h3>Online Services</h3>
                                    <ul>
                                        <li><a href="Online-Services.php">Online Banking</a></li>
                                        <li><a href="Online-Services.php#AlliedAlerts">AlliedAlerts</a></li>
                                        <li><a href="Online-Services.php#eStatements">Estatements</a></li>
                                        <li><a href="Online-Services.php#Mobile-Banking">Mobile Banking</a></li>
                                        <li><a href="Online-Services.php#Bill-Pay">Bill Pay</a></li>
                                        <li><a href="Online-Services.php#TransferNow">TransferNow</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h3>Card Services</h3>
                                    <ul>
                                        <li><a href="Card-Services.php">CardValet</a></li>
                                        <li><a href="Card-Services.php#ATM-Cash-Card">ATM Cash Card</a></li>
                                        <li><a href="Card-Services.php#Debit-Card">Personalized Debit Card</a></li>
                                        <li><a href="Credit-Cards.php">Credit Cards</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h3>Additional Services</h3>
                                    <ul>
                                        <li><a href="Additional-Services.php">Safe Deposit Box</a></li>
                                        <li><a href="Additional-Services.php#Telephone-Banking">Telephone Banking</a></li>
                                        <li><a href="Additional-Services.php#Lost-Card">Lost or Stolen Card</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="javascript:void(0)"><span>About</span> Us</a>
                            <div>
                                <div>
                                    <ul>
                                        <li><a href="Contact-Us.php">Contact Us</a></li>
                                        <li><a href="Branch-Locations.php">Branch Locations</a></li>
                                        <li><a href="Our-Legacy.php">Our Legacy</a></li>
                                        <li><a href="We-Care.php">Because You’re First With Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>



                        <div></br>
                            <li><?php echo $translate ?></li>
                        </div>
                    </ul>

                </div>
            </nav>
        </header>


        <!-- main is required to evaluate the article length. -->
        <main>
            <table class="Subsection-Table" style="background-image: url('images/ContentImageHandler904c.jpg');">
                <tbody>
                    <tr>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="50%">
                                            <h1>Online Services</h1>
                                            <h3>A simple and convenient way to manage your finances.</h3>
                                            <p><a title="Learn More " class="Button1" href="firstwithus/Online-Education.php">Learn More </a></p>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2>Online Banking</h2>
                            <p>Online Banking is a convenient way for you to check balances, view transaction history, transfer money and pay bills using your computer or tablet.&nbsp;&nbsp;Registering for Online Banking is easy. To register, have your account number handy and click the ENROLL NOW link below.</p>
                            <p><a class="Button1" href="opening.php">ENROLL NOW</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2><a id="AlliedAlerts"></a>AlliedAlerts</h2>
                            <p>Sign up for AlliedAlerts to stay notified of unusual account activity or every day transactions the moment they happen.&nbsp; Missed a loan Payment?&nbsp; You know about it.&nbsp; A deposit is made to your account?&nbsp; You know about it.&nbsp; Waiting for a check to clear?&nbsp; You know about it.</p>
                            <p>With AlliedAlerts, you can stay on top of your account activity and get notified when there's possible fraud.&nbsp; You can receive the alerts by text or email.&nbsp; Log in to online banking today to enroll.&nbsp; Choose your alerts and how you want to receive them!</p>
                            <p>&nbsp;</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2><a id="eStatements"></a>eStatements</h2>
                            <p>eStatements are an easy way to view your monthly statement through Online Banking, instead of receiving your paper statement in the mail. We&rsquo;ll email you a notification when your checking account statement is available to view. It's Safe, Secure, Simple and best of all, FREE!</p>
                            <h3>Get Started</h3>
                            <ol>
                                <li>Sign in to Online Banking on a desktop, laptop or tablet</li>
                                <li>On the Homepage, click &lsquo;Checking Account&rsquo;</li>
                                <li>Click &lsquo;Documents&rsquo; above Account Information</li>
                                <li>Accept the disclosure agreement by entering the confirmation code in the PDF document. Click &lsquo;I Agree&rsquo;</li>
                                <li>Select which checking accounts to receive eStatements and click &lsquo;Next&rsquo;</li>
                                <li>Click &lsquo;Enroll&rsquo;</li>
                                <li>Click &lsquo;View Statement&rsquo; to view current statement or click &lsquo;View History&rsquo; to view previous statements</li>
                            </ol>
                            <p><a class="Button1" href="Online-Education.php">Learn More</a></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2><a id="Mobile-Banking"></a>Mobile Banking</h2>
                            <p>Access your accounts 24/7 anytime, anywhere with <?php echo $name; ?> &rsquo;s FREE TouchBanking app! Check balances, view transaction history, transfer money and pay bills from the palm of your hand.</p>
                            <ol>
                                <li>Download the TouchBanking App in your cell phones app store</li>
                                <li>Use the app code GoMobile0443</li>
                                <li>If you are registered with Online Banking, enter your username and password to login</li>
                                <li>If you do not have an Online Banking username and password, click &lsquo;Enroll Now&rsquo; to register</li>
                            </ol>
                            <p class="Disclaimer">*Message and Data rates may apply with Mobile Banking</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2><a id="Bill-Pay"></a>Bill Pay</h2>
                            <p>Buying stamps and writing checks to pay bills is&nbsp; thing of the past.&nbsp; Simplify the process and pay all your bills in one place with <?php echo $name; ?> 's Bill Pay.</p>
                            <ul>
                                <li>Make one-time payments or schedule recurring payments</li>
                                <li>View payment history and set payment reminders</li>
                                <li>Available in Mobile Banking</li>
                                <li>Send money to friends and family with <img src="images/ContentImageHandler508e.png?ImageId=127283" alt="Popmoney" width="95" height="26" border="0"></li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="Subsection-Table">
                <tbody>
                    <tr>
                        <td>
                            <h2><a id="TransferNow"></a>TransferNow</h2>
                            <p>An easy and secure way to transfer funds between financial institutions.</p>
                            <ul>
                                <li>Transfer between your accounts at <?php echo $name; ?> and your accounts at other financial institutions</li>
                                <li>Pay your <?php echo $name; ?> loan from your personal account at another bank</li>
                                <li>Next day and standard transfer options available</li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
        <script>
            //404 script if the article is blank
            var main = document.getElementsByTagName('main')[0];
            if (main.innerHTML.length < 5) {
                window.location.href = 'Error-404.php'; //Use the 404 error article name
            }
        </script>
        <footer>
            <div class="inner-content">
                <div>
                    <h3>About Us</h3>
                    <ul>
                        <li><a href="Contact-Us.php">Contact Us</a></li>
                        <li><a href="Our-Legacy.php">Our Legacy</a></li>
                        <li><a href="Contact-Us.php">Job Opportunities</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Tools & Resources</h3>
                    <ul>
                        <li><a href="Additional-Services.php#Lost-Card">Report a Lost or Stolen Card</a></li>
                        <li><a href="Privacy%20Policy5954.pdf?documentId=57416">Privacy Policy</a></li>
                        <li><a href="Security.php">Security Statement</a></li>
                        <li><a href="Online-Education.php">Online Education Center</a></li>
                        <li><a href="Online-Education.php#Helpful-Links">Helpful Links</a></li>
                        <li><a href="Calculators.php">Calculators</a></li>
                    </ul>
                </div>
                <div>
                    <h3>Get Started</h3>
                    <ul>
                        <li><a href="Mortgage-Team.php#Apply-Now">Mortgage Application</a></li>
                        <li><a href="opening.php" target="_blank">New Account Application</a></li>
                        <li><a href="opening.php" target="_blank">Switch Kit</a></li>
                    </ul>
                </div>
                <div class="awards">
                    <img src="images/logo-best-places-to-work-mississippi.png" alt="Best Places to Work in <?php echo $country; ?> Award"> <img src="images/logo-american-banker-2018.png" alt="American Banker Best Bank to Work For Award 2018">
                </div>
                <?php echo $livechat; ?>
                <div class="copyright">
                    <p>
                        Copyright ©
                        <script language="JavaScript" type="text/javascript">
                            now = new Date
                            theYear = now.getYear()
                            if (theYear < 1900)
                                theYear = theYear + 1900
                            document.write(theYear)
                        </script> <?php echo $name; ?>. All Rights Reserved.
                    </p>
                    <div id="logos">
                        <p><!--<i class="icon-fdic"></i><i class="icon-ehl"></i> --></p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <a href="#top" id="gototop" class="fa fa-chevron-up downscale"><span class="visuallyhidden">Back to Top</span></a>
    <script type="text/javascript" src="js/vendor/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/fiserv-plugins.js"></script>
    <script src="js/slideshow.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script type="text/javascript">
        var links = document.getElementsByTagName("a");
        for (var i = 0; i < links.length; i++) {
            if (links[i].href.match(/speedbump/i) && links[i].href.match(/\?link\=/i) && !links[i].target) {
                links[i].target = '_blank';
            }
        }
    </script>
</body>

<!-- /Online-Services by ], Wed, 25 Nov 2020 05:02:21 GMT -->

</html>