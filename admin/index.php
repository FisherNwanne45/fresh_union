<?php
require_once __DIR__ . '/../config.php';
require_once(ROOT_PATH . "/admin/include/adminloginFunction.php");
require_once(ROOT_PATH . "/admin/include/session.php");

if (@$_SESSION['admin']) {
    header('Location:./dashboard.php');
}

if (@!$_SESSION['admin']) {
    header('Location:./login.php');
}
