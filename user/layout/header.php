<?php
// Start output buffering and session
if (session_status() === PHP_SESSION_NONE) {
    ob_start();
    session_start();
}

require_once __DIR__ . '/../../config.php';
require_once(ROOT_PATH . "/include/Function.php");

// Ensure login
if (empty($_SESSION['acct_no'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = userDetails('id');

// Optional session timeout (30 min)
if (isset($_SESSION["name"])) {
    if ((time() - ($_SESSION['last_login_timestamp'] ?? 0)) > 1800) {
        header("Location: logout.php");
        exit;
    } else {
        $_SESSION['last_login_timestamp'] = time();
    }
}

// ----------- Fetch settings safely -----------
$defaults = [
    'theme_version' => 'light',
    'primary_color' => 'color_1',
    'navigation_header' => 'color_1',
    'header_bg' => 'color_1',
    'sidebar_bg' => 'color_1',
    'sidebar_text' => 'color_1',
    'sidebar_img_bg' => null,
    'theme_layout' => 'vertical',
    'header_position' => 'static',
    'sidebar_style' => 'full',
    'sidebar_position' => 'static',
    'container_layout' => 'wide',
    'typography' => 'roboto',
    'image' => 'favicon.png',
    'tawk' => '',
    'translate' => ''
];

try {
    $stmt = $conn->prepare("SELECT * FROM settings WHERE id = 1 LIMIT 1");
    $stmt->execute();
    $page = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$page) {
        // Insert defaults if missing
        $insert_sql = "INSERT INTO settings (id, theme_version, primary_color, navigation_header, header_bg, sidebar_bg, sidebar_text, sidebar_img_bg, theme_layout, header_position, sidebar_style, sidebar_position, container_layout, typography, image, tawk, translate)
                       VALUES (1, :theme_version, :primary_color, :navigation_header, :header_bg, :sidebar_bg, :sidebar_text, :sidebar_img_bg, :theme_layout, :header_position, :sidebar_style, :sidebar_position, :container_layout, :typography, :image, :tawk, :translate)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->execute(array_map(fn($v) => $v, $defaults));

        $stmt = $conn->prepare("SELECT * FROM settings WHERE id = 1 LIMIT 1");
        $stmt->execute();
        $page = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} catch (Exception $e) {
    // DB error fallback
    $page = $defaults;
}

// -------- Color map and primary color --------
$colorMap = [
    'color_1' => '#eeeeeeff',
    'color_2' => '#143b64',
    'color_3' => '#1EAAE7',
    'color_4' => '#4527a0',
    'color_5' => '#c62828',
    'color_6' => '#283593',
    'color_7' => '#7356f1',
    'color_8' => '#3695eb',
    'color_9' => '#00838f',
    'color_10' => '#ff8f16',
    'color_11' => '#6673fd',
    'color_12' => '#2a2a2a',
    'color_13' => '#1367c8',
    'color_14' => '#ed0b4c',
    'color_15' => '#4cb32b'
];

$primary_key = $page['primary_color'] ?? $defaults['primary_color'];
$primary_hex = $colorMap[$primary_key] ?? '#1EAAE7';

function adjustColor($hex, $percent)
{
    $hex = ltrim($hex, '#');
    $r = max(0, min(255, hexdec(substr($hex, 0, 2)) + $percent));
    $g = max(0, min(255, hexdec(substr($hex, 2, 2)) + $percent));
    $b = max(0, min(255, hexdec(substr($hex, 4, 2)) + $percent));
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT) . str_pad(dechex($g), 2, '0', STR_PAD_LEFT) . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

function hexToRgba($hex, $opacity)
{
    $hex = ltrim($hex, '#');
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "rgba($r,$g,$b,$opacity)";
}

$primary_hover = adjustColor($primary_hex, -30);
$primary_dark = adjustColor($primary_hex, -60);

// -------- Build body attributes safely --------
$body_attributes = [
    'data-theme-version' => $page['theme_version'] ?? $defaults['theme_version'],
    'data-primary' => $page['primary_color'] ?? $defaults['primary_color'],
    'data-nav-headerbg' => $page['navigation_header'] ?? $defaults['navigation_header'],
    'data-headerbg' => $page['header_bg'] ?? $defaults['header_bg'],
    'data-sidebarbg' => $page['sidebar_bg'] ?? $defaults['sidebar_bg'],
    'data-sidebartext' => $page['sidebar_text'] ?? $defaults['sidebar_text'],
    'data-layout' => $page['theme_layout'] ?? $defaults['theme_layout'],
    'data-header-position' => $page['header_position'] ?? $defaults['header_position'],
    'data-sidebar-style' => $page['sidebar_style'] ?? $defaults['sidebar_style'],
    'data-sidebar-position' => $page['sidebar_position'] ?? $defaults['sidebar_position'],
    'data-container' => $page['container_layout'] ?? $defaults['container_layout'],
    'data-typography' => $page['typography'] ?? $defaults['typography']
];

$body_attr_string = '';
foreach ($body_attributes as $k => $v) {
    $body_attr_string .= ' ' . $k . '="' . htmlspecialchars($v, ENT_QUOTES) . '"';
}

// -------- Optional: load other utilities like original header --------
$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();
$sendSms = new twilioController();
$current_page_clean = strtolower(trim($current_page));
$profile_pages = ['profile', 'settings-profile', 'settings-pin', 'settings-password'];
?>

<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $page['url_name'] ?> - <?= htmlspecialchars($page_title ?? 'Dashboard') ?>
        </title>
        <link rel="shortcut icon" href="<?= $web_url ?>/admin/assets/images/logo/<?= $page['favicon'] ?>"
            type="image/x-icon" />

        <!-- dynamic CSS variables based on primary color -->
        <style>
        :root {
            --primary: <?=$primary_hex ?>;
            --primary-hover: <?=$primary_hover ?>;
            --primary-dark: <?=$primary_dark ?>;
            --rgba-primary-1: <?=hexToRgba($primary_hex, 0.1) ?>;
            --rgba-primary-2: <?=hexToRgba($primary_hex, 0.2) ?>;
            --rgba-primary-3: <?=hexToRgba($primary_hex, 0.3) ?>;
            --rgba-primary-4: <?=hexToRgba($primary_hex, 0.4) ?>;
            --rgba-primary-5: <?=hexToRgba($primary_hex, 0.5) ?>;
        }

        .brand-title {
            line-height: 1;
        }

        .header-right .header-profile .dropdown-menu {

            margin-top: 10em;
        }

        <?php if ( !empty($page['sidebar_img_bg'])): ?>.deznav,
        .nav-header {
            background: url('<?= htmlspecialchars($page['sidebar_img_bg'], ENT_QUOTES) ?>') !important;
            background-size: cover !important;
        }

        <?php endif;
        ?>
        </style>
        <style>
        /* -----------------------------
   FIX SIDEBAR BACKGROUND COLOR
------------------------------ */
        <?php if ( !empty($page['sidebar_bg']) && empty($page['sidebar_img_bg'])): ?>.deznav {
            background: var(--sidebar-bg) !important;
        }

        <?php endif;
        ?>

        /* -----------------------------
   FIX SIDEBAR TEXT COLOR
------------------------------ */
        <?php if ( !empty($page['sidebar_text'])): ?>.deznav,
        .deznav .nav-text,
        .deznav a,
        .deznav .metismenu a {
            color: var(--sidebar-text) !important;
        }

        .deznav .metismenu a:hover,
        .deznav .metismenu a:focus,
        .deznav .metismenu .active>a {
            color: var(--sidebar-text) !important;
        }

        <?php endif;
        ?>

        /* -----------------------------
   CSS VARIABLES FOR SIDEBAR COLORS
------------------------------ */
        :root {
            --sidebar-bg: <?=isset($colorMap[$page['sidebar_bg']]) ? $colorMap[$page['sidebar_bg']]: '#ffffff'?>;
            --sidebar-text: <?=isset($colorMap[$page['sidebar_text']]) ? $colorMap[$page['sidebar_text']]: '#333333'?>;
        }
        </style>
        <style>
        /* MOBILE SIDEBAR OVERLAY + STICKY FOOTER */
        @media (max-width: 767px) {

            /* Footer styling */
            .sidebar-mobile-footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                height: 60px;
                display: flex;
                justify-content: space-around;
                align-items: center;
                background-color: var(--sidebar-bg) !important;
                color: var(--sidebar-text) !important;
                border-top: 1px solid rgba(0, 0, 0, 0.1);
            }

            .sidebar-mobile-footer .footer-item {
                flex: 1;
                text-align: center;
                color: var(--sidebar-text) !important;
                text-decoration: none;
                font-size: 0.8rem;
            }

            .sidebar-mobile-footer .footer-item i {
                display: block;
                font-size: 1.2rem;
                margin-bottom: 2px;
            }

            .sidebar-mobile-footer .footer-item.active {
                color: var(--primary) !important;
            }


        }

        /* Hide overlay sidebar on desktop */
        @media (min-width: 768px) {


            .sidebar-mobile-footer {
                display: none;
            }
        }
        </style>

        <!-- External CSS -->
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/jqvmap.min.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/chartist.min.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/owl.carousel.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/style.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/animate.min.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/aos.min.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?= $web_url ?>/user/assets/css/metisMenu.min.css">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    </head>
    <body<?= $body_attr_string ?>>

        <!-- Preloader -->
        <div id="preloader">
            <div class="sk-three-bounce">
                <div class="sk-child sk-bounce1"></div>
                <div class="sk-child sk-bounce2"></div>
                <div class="sk-child sk-bounce3"></div>
            </div>
        </div>

        <!-- Main Wrapper -->
        <div id="main-wrapper">

            <!-- Nav Header -->
            <div class="nav-header">
                <a href="dashboard.php" class="brand-logo">
                    <img class="logo-abbr"
                        src="<?= $web_url ?>/admin/assets/images/logo/<?= htmlspecialchars($page['favicon'] ?? 'favicon.png', ENT_QUOTES) ?>"
                        alt="">
                    <img class="logo-compact"
                        src="<?= $web_url ?>/admin/assets/images/logo/<?= htmlspecialchars($page['favicon'] ?? 'favicon.png', ENT_QUOTES) ?>"
                        alt="">
                    <p class="brand-title"><?= $page['url_name'] ?></p>

                </a>

                <div class="nav-control">
                    <div class="hamburger"><span class="line"></span><span class="line"></span><span
                            class="line"></span></div>
                </div>
            </div>
            <!--**********************************
            Header start
        ***********************************-->
            <div class="header">
                <div class="header-content">
                    <nav class="navbar navbar-expand">
                        <div class="collapse navbar-collapse justify-content-between">
                            <div class="header-left">
                                <div class="dashboard_bar">
                                    Dashboard
                                </div>
                            </div>
                            <ul class="navbar-nav header-right">
                                <!-- <li class="nav-item">
                                <div class="d-flex weather-detail">
                                    <span><i class="las la-cloud"></i>21</span>
                                    Medan, IDN
                                </div>
                            </li>-->
                                <li class="nav-item">
                                    <div class="d-flex weather-detail">
                                        <span><i class="fas fa-calendar-alt me-2"></i><?php echo date('j M'); ?></span>
                                        <?php
                                    $ip = $_SERVER['REMOTE_ADDR'];
                                    $data = json_decode(file_get_contents("http://ip-api.com/json/" . $ip));

                                    if ($data && $data->status === "success") {
                                        echo $data->city;
                                    } else {
                                        echo $country;
                                    }
                                    ?>

                                    </div>
                                </li>
                                <style>
                                /* Styling for the container holding the icon and the dropdown */
                                .translate-group {
                                    display: flex;
                                    /* Aligns children (icon and wrapper) in a row */
                                    align-items: center;
                                    /* Vertically centers the icon and the dropdown */
                                    gap: 5px;
                                    /* Adds a small space between the icon and the dropdown */
                                }

                                /* Styling for the icon */
                                .translate-icon {
                                    color: #0e335aff;
                                    /* Blue color */
                                    font-size: 1em;
                                    /* Make the icon slightly larger */
                                }

                                /* Existing styling for the dropdown wrapper */
                                .gtranslate_wrapper {
                                    /* Set a maximum width for the entire container */
                                    max-width: 80px;

                                    /* Ensure it doesn't try to fill its parent element unless necessary */
                                    width: fit-content;
                                    /* Optional: Ensure the contents fit well */
                                    overflow: hidden;
                                }

                                /* Styling the select element inside the wrapper */
                                .gtranslate_wrapper select {
                                    width: 100%;
                                    /* Make the select box fill the limited wrapper width */
                                    box-sizing: border-box;
                                    /* Include padding and border in the element's total width */
                                }
                                </style>
                                <!-- Translate Section -->
                                <li class="nav-item">
                                    <div class="translate-group">
                                        <i class="fas fa-language translate-icon"></i>
                                        <?php echo $translate ?>
                                    </div>
                                </li>

                                <li class="nav-item dropdown header-profile">

                                    <a class="nav-link" id="customDropdownTrigger" href="#" role="button"
                                        aria-expanded="false">
                                        <div class="header-info">
                                            <span class="text-black"><strong><?= $fullName ?></strong></span>
                                            <p class="fs-12 mb-0">Customer</p>
                                        </div>

                                        <?php
                                    // PHP LOGIC FOR IMAGE DISPLAY
                                    $user_image = $row['acct_image'];
                                    $image_folder = $web_url . "/assets/user/profile/";
                                    $default_image = "default.png";

                                    if (!empty($user_image) && file_exists(ROOT_PATH . "/assets/user/profile/" . $user_image)) {
                                        $image_to_display = $image_folder . $user_image;
                                    } else {
                                        $image_to_display = $image_folder . $default_image;
                                    }
                                    ?>

                                        <img src="<?= $image_to_display ?>" width="40" alt="Profile Image" />
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" id="customDropdownMenu"> <a
                                            href="profile.php" class="dropdown-item ai-icon">
                                            <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                                                width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            <span class="ms-2">Profile</span>
                                        </a>

                                        <a href="logout.php" class="dropdown-item ai-icon">
                                            <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                                                width="18" height="18" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                                <polyline points="16 17 21 12 16 7"></polyline>
                                                <line x1="21" y1="12" x2="9" y2="12"></line>
                                            </svg>
                                            <span class="ms-2">Logout</span>
                                        </a>

                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

            <!--**********************************
            Sidebar start
        ***********************************-->
            <div
                class="deznav <?= htmlspecialchars($page['sidebar_bg']) ?> <?= htmlspecialchars($page['sidebar_text']) ?>">

                <div class="deznav-scroll">
                    <ul class="metismenu" id="menu">
                        <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                                <i class="fas fa-tachometer-alt"></i>
                                <span class="nav-text">Dashboard</span>
                            </a>
                            <ul aria-expanded="false">
                                <li><a href="dashboard.php"
                                        class="<?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>"><i
                                            class="fas fa-chart-line"></i> <small>My Account
                                        </small></a>
                                </li>
                                <li><a href="transactions.php"
                                        class="<?php echo ($current_page == 'transactions') ? 'active' : ''; ?>"><i
                                            class="fas fa-history"></i>
                                        <small>Transactions</small></a>
                                </li>
                            </ul>
                        </li>

                        <li><a href="deposit.php"
                                class="ai-icon <?php echo ($current_page == 'deposit') ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-plus-circle"></i>
                                <span class="nav-text">Deposit</span>
                            </a>
                        </li>

                        <li><a href="transfer.php"
                                class="ai-icon <?php echo ($current_page == 'transfer') ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-paper-plane"></i>
                                <span class="nav-text">Transfer</span>
                            </a>
                        </li>

                        <li><a href="card.php" class="ai-icon <?php echo ($current_page == 'card') ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-credit-card"></i>
                                <span class="nav-text">My Cards</span>
                            </a>
                        </li>

                        <li><a href="loan.php" class="ai-icon <?php echo ($current_page == 'loan') ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-hand-holding-usd"></i>
                                <span class="nav-text">Loans</span>
                            </a>
                        </li>

                        <li>
                            <a href="profile.php"
                                class="ai-icon <?php echo in_array($current_page, ['settings', 'settings-profile', 'settings-pin', 'settings-password']) ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-user-circle"></i>
                                <span class="nav-text">Profile</span>
                            </a>
                        </li>


                        <!--  <li><a href="settings.php"
                            class="ai-icon <?php echo ($current_page == 'settings') ? 'active' : ''; ?>"
                            aria-expanded="false">
                            <i class="fas fa-cogs"></i>
                            <span class="nav-text">Settings</span>
                        </a>
                    </li>
                                -->
                        <li><a href="support.php"
                                class="ai-icon <?php echo ($current_page == 'support') ? 'active' : ''; ?>"
                                aria-expanded="false">
                                <i class="fas fa-question-circle"></i>
                                <span class="nav-text">Support</span>
                            </a>
                        </li>
                        <li><a href="logout.php" class="ai-icon" aria-expanded="false">
                                <i class="fas fa-sign-out-alt"></i>
                                <span class="nav-text">Exit</span>
                            </a>
                        </li>
                    </ul>

                    <div class="copyright">
                        <p><strong><?= $page['url_name'] ?></strong> © <?= date('Y') ?> All Rights Reserved</p>
                    </div>
                </div>



            </div>

            <!--**********************************
            Content body start
        ***********************************-->
            <div class="content-body">
                <div class="container-fluid">