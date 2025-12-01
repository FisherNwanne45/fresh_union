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
$logo = $page['image'];
$favicon = $page['favicon'];
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