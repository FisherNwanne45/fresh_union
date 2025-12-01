<?php
// Change Bank Name
define("WEB_TITLE", "First Sterling Capital Bank");
// Change Web URL https://domain.com or https://sud.domain.com  with No Ending splash "/"
define("WEB_URL", "http://localhost/fresh_union");
// Change Your Website Email
define("WEB_EMAIL", "info@1ststerlingplc.com");
// Change Your Website Phone Number
define("WEB_PHONE", " ");

// Do not Edit
$web_url = WEB_URL;
$web_title = WEB_TITLE;
$web_phone = WEB_PHONE;
$web_email = WEB_EMAIL;
// Do not Edit


// Set database Below
function dbConnect()
{
    $servername = "localhost";
    //Change Database Username "root"
    $username = "root";
    //Change Database Password ""
    $password = "";
    //Change Database ""
    $database = "union";
    //Do not edit... That's all
    $dns = "mysql:host=$servername;dbname=$database";

    try {
        $conn = new PDO($dns, $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
//return dbConnect();

function inputValidation($value): string
{
    return trim(htmlspecialchars(htmlentities($value)));
}