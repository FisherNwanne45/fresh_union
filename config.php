<?php
define('ROOT_PATH', __DIR__);
// Include the configuration file to establish a database connection
require_once ROOT_PATH . '/include/config.php';
//require_once ROOT_PATH . '/courtagetrust/include/config.php';

// Initialize variables
$name = '';
$addr = '';
$addr2 = '';
$addr3 = '';
$phone = '';
$phone2 = '';
$phone3 = '';
$url = '';
$email = '';
$email2 = '';
$email3 = '';
$country = '';
$country2 = '';
$country3 = '';
$officer = '';
$officer2 = '';
$officer3 = '';
$curr = '';
$login = '';
$translate = '';
$footertext = 'Equal Housing Lender | Equal Opportunity Employer | Member FDIC';
$slidertext = 'Your Gateway to Financial Privacy and Security';
$sliderBOLD = 'Secure Future, Beyond Borders';
$register = '';
$livechat = '';

try {
    // Connect to the database using the PDO connection function
    $conn = dbConnect();

    // Fetch data from the users table (assuming there's a specific ID for the user you want)
    $userId = 1; // Replace with the actual ID or condition
    $query = "SELECT url_name, url_link, url_address, url_tel, image, favicon, url_email, translate, country, currency, login, register, tawk FROM settings WHERE id = :id";

    // Prepare the query
    $stmt = $conn->prepare($query);
    // Bind the userId parameter
    $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
    // Execute the query
    $stmt->execute();

    // Fetch the result and assign data to variables
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $name = $row['url_name'];
        $addr = $row['url_address'];
        $phone = $row['url_tel'];
        $image = $row['image'];
        $favicon = $row['favicon'];
        $email = $row['url_email'];
        $emailParts = explode('@', $email);
        $domain = $emailParts[1];
        $email2 = 'credit@' . $domain;
        $email3 = 'support@' . $domain;
        $url = $row['url_link'];
        // $url = 'https://' . $domain;
        $country = $row['country'];
        $curr = $row['currency'];
        $login = $url . '/login';
        $register = $url . '/opening';
        $livechat = $row['tawk'];
        $translate = $row['translate'];
        $mapLink = "https://www.google.com/maps?q=" . urlencode($addr);
        $mapLink2 = "https://www.google.com/maps?q=" . urlencode($addr2);
        $mapLink3 = "https://www.google.com/maps?q=" . urlencode($addr3);
    } else {
        echo "No user found with ID: $userId";
    }

    // Close the connection (PDO does this automatically when the script ends)
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
