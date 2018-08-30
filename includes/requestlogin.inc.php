<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {

  include_once 'dbh.inc.php';

  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $fireid = mysqli_real_escape_string($conn, $_POST['fireid']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

  //error handlers
  //check for empty fieldset
  if (empty($first) || empty($last) || empty($email) || empty($fireid) || empty($pwd)) {
    header("Location: ../index.php?form=empty");
    exit();
  } else {
    //check if name input characters are valid
      if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
        header("Location: ../index.php?form=invalid");
        exit();
      } else {
        //check if email is valid
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?form=invalidemail&first=$first&last=$last&fireid=$fireid");
            exit();
          } else {
            //check correct fire id format
              if (!preg_match("/^[A-Z][A-Z]\d{4}$/", $fireid)) {
                header("Location: ../index.php?form=invalidfireid");
                exit();
              } else {
                $sql = "SELECT * FROM members WHERE user_fireid='$fireid'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                //check if user is taken
                if ($resultCheck > 0) {
                  header("Location: ../index.php?form=usertaken");
                  exit();
                } else {
                  //check if password and confirm password fields match
                    if ($pwd != $_POST['confpwd']) {
                      header("Location: ../index.php?form=password");
                      exit();
                    } else {
                      //hasing Password
                      $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
                      //insert the user into the database
                      $sql = "INSERT INTO members (user_first, user_last, user_email, user_fireid, user_pwd) VALUES ('$first', '$last', '$email', '$fireid', '$hashedPwd');";

                      mysqli_query($conn, $sql);

                      header("Location: ../index.php?form=success");

                      //send e-mail notification to admn.bfdintranet@gmail.com for account activation request
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
                          $mail->addAddress('admn.bfdintranet@gmail.com');                // Add a recipient

                          //Content
                          $body = "
                            <p>Received new account activation request:</p>

                            <p>First name:  $first</p>

                            <p>Last name: $last</p>

                            <p>Fire ID: $fireid</p>

                            <p>Please log in to the BFD intranet admin account to verify this user.</p><br/>

                            <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                            <p>Bethesda FD Administrator</p>
                            ";

                          $mail->isHTML(true);                                  // Set email format to HTML
                          $mail->Subject = "[BFD Member's Portal] New Account Request: $fireid";
                          $mail->Body    = $body;
                          $mail->AltBody = strip_tags($body);

                          $mail->send();

                      } catch (Exception $e) {
                        header("Location: ../index.php?form=error");
                        $mail->ErrorInfo;
                      }


                      exit();
                      }
                    }
                }
              }
          }
        }
      }
      else {
        header("Location: ../index.php?form=error");
        exit();
      }
