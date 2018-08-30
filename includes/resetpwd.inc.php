<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['reset'])) {

include_once 'dbh.inc.php';

$fireid = mysqli_real_escape_string($conn, $_POST['fireid']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

//check if inputs are empty
  if (empty($fireid) || empty($email)) {
    header("Location: ../index.php?reset=empty");
    exit();
  } else {
    //check correct fire ID format
    if (!preg_match("/^[A-Z][A-Z]\d{4}$/", $fireid)) {
      header("Location: ../index.php?reset=invalidfireid");
      exit();
    } else {
      //Check correct email address format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          header("Location: ../index.php?reset=invalidemail");
          exit();
        } else {
          //check if user exists
            $sql = "SELECT * FROM members WHERE user_fireid='$fireid' AND user_email='$email'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
              if($resultCheck < 1) {
                header("Location: ../index.php?reset=error");
                exit();
              } elseif($resultCheck != 0) {
                header("Location: ../index.php?reset=success");   //header must be included before PHPMailer in order to work

                while ($row = mysqli_fetch_assoc($result)) {
                  $code = rand(10000,1000000);
                  $first = $row['user_first'];
                  $last = $row['user_last'];

                  //Load Composer's autoloader
                  require '../vendor/autoload.php';

                  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                  try {
                      //Server settings
                      $mail->SMTPDebug = 2;                                 // Enable verbose debug output
                      $mail->isSMTP();                                      // Set mailer to use SMTP
                      $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
                      $mail->SMTPAuth = true;                               // Enable SMTP authentication
                      $mail->Username = 'admn.bfdintranet@gmail.com';                 // SMTP username
                      $mail->Password = 'Admin#0601!';                           // SMTP password
                      $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                      $mail->Port = 465;                                    // TCP port to connect to

                      //Recipients
                      $mail->setFrom('no-reply@bethesdafire.org');
                      $mail->addAddress($row['user_email']);                // Add a recipient

                      //Content
                      $body = "
                        <p>Dear $first $last,</p>

                        <p>You are receiving this e-mail because you or someone else has requested to reset your password.</p>

                        <p>Please use the link below to change your password:<br/>
                        <strong>http://localhost/bfdintranet/index.php?code=$code&fireid=$fireid</strong></p>

                        <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                        <p>Thank you,</p>
                        <p>Bethesda FD Administrator</p>
                        ";

                      $mail->isHTML(true);                                  // Set email format to HTML
                      $mail->Subject = "[BFD Member's Portal] Password Reset";
                      $mail->Body    = $body;
                      $mail->AltBody = strip_tags($body);

                      $mail->send();

                  } catch (Exception $e) {
                    header("Location: ../index.php?reset=failed");
                    $mail->ErrorInfo;
                  }
                $sql = "UPDATE members SET pwd_reset='$code' WHERE user_fireid='$fireid'";
                mysqli_query($conn, $sql);
                }

              }

      }
    }
  }
} else {
  header("Location: ../index.php");
  exit();
}

 ?>
