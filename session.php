<?php
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1100)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time
    session_destroy();
    header('Location:./login.php');
    echo "Timeout";	// destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp



    // // Turn off all error reporting
    // error_reporting(0);
    // // Report simple running errors
    // error_reporting(E_ERROR | E_WARNING | E_PARSE);
    // // Reporting E_NOTICE can be good too (to report uninitialized variables or catch variable name misspellings ...)
    // error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    // // Report all errors except E_NOTICE
    // error_reporting(E_ALL & ~E_NOTICE);
    // // Report all PHP errors (see changelog)
    // error_reporting(E_ALL);
    // // Report all PHP errors
    // error_reporting(-1);
    // // Same as error_reporting(E_ALL);
    // ini_set('error_reporting', E_ALL);