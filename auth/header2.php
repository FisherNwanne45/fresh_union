<?php
ob_start();
session_start();
require_once __DIR__ . '/../config.php';
require_once(ROOT_PATH . "/include/config.php");
require_once(ROOT_PATH . "/include/Function/Function.php");
require_once ROOT_PATH . "/include/SMS/twilioController.php";


$message = new message();

require_once(ROOT_PATH . "/session.php");
// require_once("/include/Function.php");

$sql = "SELECT * FROM settings WHERE id ='1'";
$stmt = $conn->prepare($sql);
$stmt->execute();

$page = $stmt->fetch(PDO::FETCH_ASSOC);

$title = $page['url_name'];

$pageTitle = $title;
$BANK_PHONE = $page['url_tel'];
$tawk = $page['tawk'];
$translate = $page['translate'];


$viesConn = "SELECT * FROM users";
$stmt = $conn->prepare($viesConn);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);



$title = new pageTitle();
$email_message = new message();
$sendMail = new emailMessage();
$sendSms = new twilioController();

?>

<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title> <?= $pageName  ?> - <?= $pageTitle ?> </title>
    <meta name="description" content="<?= $pageTitle ?> Mobile Banking">
    <meta name="keywords" content="bootstrap, wallet, banking, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/logo/favicon.png">
    <link rel="stylesheet" href="<?= $web_url ?>/assets/panel/css/style3.css">
    <link rel="manifest" href="__manifest.json">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>



</head>

<body>

    <!-- loader -->
    <!-- <div id="loader">
        <img src="assets/img/loading-icon.png" alt="icon" class="loading-icon">
    </div> -->
    <!-- * loader -->
    <div id="loader">
        <span class="spinner-grow spinner-grow-sm me-05" role="status" aria-hidden="true"
            class="loading-icon"></span>
        Loading...
    </div>