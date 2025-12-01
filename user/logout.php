<?php
session_start();
// include_once("/include/Function.php");

unset($_SESSION['acct_no'], $_SESSION['acct_email'], $_SESSION['wire_transfer'], $_SESSION['dom-transfer'], $_SESSION['login']);
setcookie('firstVisit');

header("Location:../login.php");
exit();