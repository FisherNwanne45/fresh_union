<?php
ob_start();
session_start();

require_once(__DIR__ . "/../include/Function/Function.php");
// require_once(ROOT_PATH . "/include/Function.php");
//require __DIR__."/../include/loginFunction.php";
// require_once __DIR__."/../session.php";
// require_once("/include/UserFunction.php");


$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$tawk = $page['tawk'];
$translate = $page['translate'];
$title = $page['url_name'];

$pageTitle = $title;
$BANK_PHONE = $page['url_tel'];

$sitecountry = $page['country'];

$sitename = $page['url_name'];
$shortname = $page['url_name'];
$money = $page['currency'];
$visapicture = $page['url_name'];
$sitephone = $page['url_tel'];
$siteaddress = $page['url_address'];

$query = $conn->query("SELECT * FROM sliders WHERE status = 1 ORDER BY id");
$slider_data = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array


$viesConn = "SELECT * FROM users";
$stmt = $conn->prepare($viesConn);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);



$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();

?>


<!doctype html>
<html>
<script>
    document.onkeydown = function(e) {
        if (event.keyCode == 123) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'I'.charCodeAt(0) || e.keyCode == 'i'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'C'.charCodeAt(0) || e.keyCode == 'c'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && e.shiftKey && (e.keyCode == 'J'.charCodeAt(0) || e.keyCode == 'j'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'U'.charCodeAt(0) || e.keyCode == 'u'.charCodeAt(0))) {
            return false;
        }
        if (e.ctrlKey && (e.keyCode == 'S'.charCodeAt(0) || e.keyCode == 's'.charCodeAt(0))) {
            return false;
        }
    }
</script>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <script>
        const Uss = JSON.parse(atob('eyJQbGF0Zm9ybSI6IkZDQ1VCIn0='));
    </script>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= $pageName ?> | <?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageTitle ?> is licensed by the WB">

    <!-- CSS here -->
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/animate.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/swiper-bundle.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/slick.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/font-awesome-pro.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/flaticon.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/spacing.css">
    <link rel="stylesheet" href="uss-modules/uss-bank/bank-home/assets/css/main.css">

    <link rel="shortcut icon" type="image/x-icon" href="favicon.png">

    <style>
        .preloader {
            background-position: center;
            background-repeat: no-repeat;
            background-image: url(<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>);
            background-size: 120px 40px;
        }
    </style>

    <meta name='viewport' content='width=device-width, initial-scale=1.0' data-rc='viewport'>
    <link rel='stylesheet' href='uss-core/assets/css/bootstrap.min.css' data-rc='bootstrap'>
    <link rel='stylesheet' href='uss-core/assets/vendor/bootstrap-icons/bootstrap-icons.css' data-rc='bs-icon'>
    <link rel='stylesheet' href='uss-core/assets/css/animate.min.css' data-rc='animate'>
    <link rel='stylesheet' href='uss-core/assets/vendor/glightbox/glightbox.min.css' data-rc='glightbox'>
    <link rel='stylesheet' href='uss-core/assets/vendor/toastr/toastr.min.css' data-rc='toastr'>
    <link rel='stylesheet' href='uss-core/assets/css/font-size.min.css' data-rc='font-size'>
    <link rel='stylesheet' href='uss-core/assets/css/main.css' data-rc='main-css'>
    <style>
        /* Remove underline from all anchor tags */
        a {
            text-decoration: none;
        }

        /* Specific class or ID for removing underline */
        .no-underline {
            text-decoration: none;
        }
    </style>
</head>

<body class="uss">

    <!-- pre loader area start -->
    <div id="loading">
        <div id="loading-center">
            <div class="preloader"></div>
        </div>
    </div>
    <!-- pre loader area end -->


    <!-- back to top start -->
    <div class="back-to-top-wrapper">
        <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
    <!-- back to top end -->


    <!-- search area start -->
    <div class="search-area">
        <div class="search-inner p-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="search-wrapper">
                            <div class="search-close">
                                <button class="search-close-btn">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                            <div class="search-content pt-35">
                                <h3 class="heading text-center mb-30">Hi! How can we help You?</h3>
                                <div class="d-flex justify-content-center px-5">
                                    <div class="search w-100 p-relative">
                                        <input type="text" class="search-input" placeholder="Search...">
                                        <button class="search-icon">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-overlay"></div>
    <!-- search area end -->


    <!-- offcanvas area start -->
    <div class="offcanvas__area">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__close">
                <button class="offcanvas__close-btn offcanvas-close-btn">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-50 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo logo">
                        <a href="index.php">
                            <img src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>" alt="logo"
                                height='50px'>
                        </a>
                    </div>
                </div>

                <div class="tp-main-menu-mobile fix d-xl-none mb-40"></div>

            </div>
        </div>
    </div>
    <div class="body-overlay"></div>
    <!-- offcanvas area end -->


    <!-- header area start -->
    <header id="header-sticky" class="tp-header-area p-relative">
        <div class="tp-header-box p-relative">
            <div class="tp-header-logo p-relative">
                <span class="tp-header-logo-bg"></span>
                <a href="index.php">
                    <img src="<?= $web_url ?>/admin/assets/images/logo/<?= $page['image'] ?>" alt="" height='50px'>
                </a>
            </div>
            <div class="tp-header-wrapper-inner header__sticky p-relative">
                <div class="tp-header-main-menu d-flex align-items-center justify-content-between">
                    <div class="tp-main-menu d-none d-xl-block">
                        <nav class="tp-main-menu-content">
                            <ul>
                                <li class='has-dropdown'><a href='javascript:void(0)'>Banking</a>
                                    <ul class='submenu'>
                                        <li class=''><a href='personal.php'>personal banking</a></li>
                                        <li class=''><a href='corporate.php'>corporate banking</a></li>
                                    </ul>
                                </li>
                                <li class='active'><a href='deposits.php'>Deposits</a></li>
                                <li class=''><a href='credits.php'>Credits</a></li>
                                <li class=''><a href='cards.php'>Cards</a></li>
                                <li class=''><a href='investments.php'>Investments</a></li>
                                <li class=''><a href='loans.php'>Loans</a></li>
                                <li class=''><a href='insurance.php'>Insurance</a></li>
                                <li class='has-dropdown'><a href='javascript:void(0)'>Account</a>
                                    <ul class='submenu'>
                                        <li class=''><a href='../login.php'>sign in</a></li>
                                        <li class=''><a href='../opening.php'>sign up</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="tp-header-main-right d-flex align-items-center justify-content-xl-end">
                        <div class="tp-header-contact d-xl-flex align-items-center d-none">
                            <div class="tp-header-contact-search search-open-btn d-none d-xxl-block">
                                <span><i class="fa-solid fa-magnifying-glass"></i></span>
                            </div>

                        </div>
                        <div class="tp-header-sticky-hamburger d-xl-none offcanvas-open-btn">
                            <button class="hamburger-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-header-btn">

                <!------- GET A QUOTE --------->
                <a class="tp-btn d-none d-xl-block" href="../login.php">
                    E-BANKING <i class="fa fa-lock"></i>
                </a>
                <!-------- / GET A QUOTE ------>

                <div class="tp-header-main-right-hamburger-btn d-xl-none offcanvas-open-btn">
                    <button class="hamburger-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>

            </div>
        </div>
    </header>
    <!-- header area end -->