<?php

use PHPMailer\PHPMailer\PHPMailer;


// MESSAGE & EMAIL CONFIGURATION FOR SCRIPT
class message
{
  // private $conn;
  public function send_mail($email, $message, $subject)
  {
    require_once __DIR__ . '/../../config.php';
    require_once(ROOT_PATH . "/include/config.php");
    $conn = dbConnect();
    $sql = "SELECT * FROM smtp_setting WHERE id ='1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($rowsmtp = $stmt->fetch(PDO::FETCH_ASSOC)) {

      $smtp_host = $rowsmtp["host"];
      $smtp_username = $rowsmtp["username"];
      $smtp_password = $rowsmtp["password"];
      $smtp_port = $rowsmtp["port"];
      $display_name = $rowsmtp["display_name"];
      $smtp_auth = $rowsmtp["smtp_auth"];
    }
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = true;
    $mail->CharSet = "UTF-8";
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->SMTPSecure = $smtp_auth;
    $mail->Port = $smtp_port;
    $mail->setFrom($smtp_username, $display_name);
    $mail->addReplyTo($smtp_username, $display_name);
    $mail->addAddress($email);
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->MsgHTML($message);
    // $mail->Send();
    if (!$mail->Send()) {
      return 0;
    } else {
      return 1;
    }
  }
}
