<?php
ob_start();
session_start();
require_once(ROOT_PATH . "/admin/include/adminloginFunction.php");
require_once(ROOT_PATH . "/admin/include/session.php");
require_once(ROOT_PATH . "/admin/include/adminClass.php");

// Ofofonobs Developer WhatsAPP +2348114313795
if (!$_SESSION['admin']) {
    header("location:./login");
    die;
}





$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['url_name'];

$pageTitle = $title;
$BANK_PHONE = $page['url_tel'];

$currency = $page['currency'];

$email_message = new message();
$sendMail = new emailMessage();

$sql = "SELECT * FROM admin WHERE id ='1'";
$data = $conn->prepare($sql);
$data->execute();

$admin = $data->fetch(PDO::FETCH_ASSOC);
$adminName = $admin['firstname'] . " " . $admin['lastname'];

$sql4 = "SELECT * FROM users WHERE id=id";
$stmt = $conn->prepare($sql4);
$stmt->execute();
$row_count = $stmt->rowCount();
$row = $stmt->fetch(PDO::FETCH_ASSOC);


$fullName = $row['firstname'] . " " . $row['lastname'];

//USER STATUS
function userStatus($row)
{
    if ($row['acct_status'] === 'active') {
        return 'ACTIVE';
    }

    if ($row['acct_status'] === 'hold') {
        return 'LOGIN DISABLED';
    }
    if ($row['acct_status'] === 'suspend') {
        return 'TRANSFER PAUSED';
    }
}


$userStatus = userStatus($row);




?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= $pageName  ?> - <?= $pageTitle ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <!-- Favicon icon -->
        <link rel="shortcut icon" href="<?= $web_url ?>/admin/assets/images/logo/<?= $page['favicon'] ?>"
            type="image/x-icon" />

        <!-- DataTables -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/dist/css/skins/_all-skins.min.css">

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/dist/css/skins/_all-skins.min.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/morris.js/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?= $web_url ?>/admin/assets/bower_components/jvectormap/jquery-jvectormap.css">
        <!-- Date Picker -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
        <!-- Daterange picker -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet"
            href="<?= $web_url ?>/admin/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
            integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.css"
            integrity="sha512-DIW4FkYTOxjCqRt7oS9BFO+nVOwDL4bzukDyDtMO7crjUZhwpyrWBFroq+IqRe6VnJkTpRAS6nhDvf0w+wHmxg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="<?= $web_url ?>/assets/user/js/vendor/jquery/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
            integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="./dashboard.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><?= $pageTitle ?></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?= $web_url ?>/assets/user/profile/<?= $admin['adminimage'] ?>"
                                        class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?= $adminName ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="<?= $web_url ?>/assets/user/profile/<?= $admin['adminimage'] ?>"
                                            class="img-circle" alt="User Image">

                                        <p>
                                            <?= $adminName ?>
                                            <small> </small>
                                        </p>
                                    </li>

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="./edit-profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="./logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?= $web_url ?>/assets/user/profile/<?= $admin['adminimage'] ?>"
                                class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?= $adminName ?></p>
                            <a href="#" target="_blank"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        <li><a href="./dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>

                        <li class="header">MANAGE USER</li>
                        <li><a href="./users.php"><i class="fa fa-user"></i> <span>All Users</span></a></li>

                        <li><a href="./createuser.php"><i class="fa fa-user"></i> <span>Create New Users</span></a></li>

                        <li class="header">FUNDING</li>
                        <li><a href="./fundings.php"><i class="fa fa-paper-plane-o"></i> <span>Credit/Debit
                                    User</span></a></li>





                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Bank Transactions</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="./inter-trans.php"><i class="fa fa-circle-o"></i> Interbank
                                        Transactions</a></li>
                                <li><a href="./wire-trans.php"><i class="fa fa-circle-o"></i> Wire Transfer
                                        Transactions</a></li>
                                <li><a href="./domestic-trans.php"><i class="fa fa-circle-o"></i> Domestic
                                        Transactions</a></li>
                                <li><a href="./credit-trans.php"><i class="fa fa-circle-o"></i> Credit Transactions</a>
                                </li>
                                <li><a href="./debit-trans.php"><i class="fa fa-circle-o"></i> Debit Transactions</a>
                                </li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Crypto Deposit </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="./deposit.php"><i class="fa fa-circle-o"></i>Approved Deposit</a></li>
                                <li><a href="./pending-deposit.php"><i class="fa fa-circle-o"></i>Pending Deposit</a>
                                </li>
                                <li><a href="./failed-deposit.php"><i class="fa fa-circle-o"></i>Rejected Deposit</a>
                                </li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Crypto Withdrawal </span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="./withdrawal.php"><i class="fa fa-circle-o"></i>Approved Withdrawal</a>
                                </li>
                                <li><a href="./pending-withdrawal.php"><i class="fa fa-circle-o"></i>Pending
                                        Withdrawal</a></li>
                                <li><a href="./failed-withdrawal.php"><i class="fa fa-circle-o"></i>Rejected
                                        Withdrawal</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-list-alt"></i> <span>Stocks/Loan</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="./stocks.php"><i class="fa fa-paper-plane-o"></i> <span>Add
                                            Stocks</span></a></li>
                                <li><a href="./stocks-trans.php"><i class="fa fa-circle-o"></i> Stocks Transactions</a>
                                </li>
                                <li><a href="./loan-trans.php"><i class="fa fa-circle-o"></i> Loan transactions</a></li>
                            </ul>
                        </li>

                        <li><a href="./cards.php"><i class="fa fa-credit-card"></i> <span>All Virtual Cards</span></a>
                        </li>


                        <li class="header">SETTINGS & PROFILE</li>
                        <li>
                            <a href="./setting.php" style="background-color:#003366; color:white;">
                                <i class="fa fa-cog"></i> <span>GENERAL SETTINGS</span>
                            </a>
                        </li>

                        <li><a href="./messages.php"><i class="fa fa-comments-o"></i> <span>Tickets</span></a></li>
                        <li><a href="./edit-profile.php"><i class="fa fa-user-o"></i> <span>Edit Profile</span></a></li>
                        <li><a href="./payments.php"><i class="fa fa-paper-plane-o"></i> <span>Digital
                                    Payment</span></a></li>
                        <li><a href="./smtp_settings.php"><i class="fa fa-cog"></i> <span>SMTP Settings</span></a></li>



                        <li><a href="./logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>