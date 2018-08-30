<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['verify-submit'])) {

  include_once 'dbh.inc.php';

//variables for members table
  $dbfireid = $_POST['dbfireid']; //this is the fire id currently in the db prior to verification
  $fireid = mysqli_real_escape_string($conn, $_POST['fireid']); //this is the verified and posted fireid from verify-form input field; could be same as original db fireid or could be changed
  $first = mysqli_real_escape_string($conn, $_POST['firstname']);
  $last = mysqli_real_escape_string($conn, $_POST['lastname']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $access = $_POST['accesslvl'];
//variables for profile table
  $fireems = $_POST['fireems'];
  $iecsrank = $_POST['rank'];
  $duty = $_POST['duty'];
//variables for qualifications table
  $emsobserve = $_POST['emsobserve'];
  $fireobserve = $_POST['fireobserve'];
  $emt = $_POST['emt'];
  $paramedic = $_POST['paramedic'];
  $engineff = $_POST['engineff'];
  $truckff = $_POST['truckff'];
  $ambdriver = $_POST['ambdriver'];
  $engdriver = $_POST['engdriver'];
  $truckdriver = $_POST['truckdriver'];
  $engineoic = $_POST['engineoic'];
  $truckoic = $_POST['truckoic'];
  $chief = $_POST['chief'];

  //error handlers
  //check for empty fieldset
  if (empty($first) || empty($last) || empty($email) || empty($fireid)) {
    header("Location: ../admin.php?verify=display&alert=empty");
    exit();
  } else {
    //check if name input characters are valid
      if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
        header("Location: ../admin.php?verify=display&alert=invalid");
        exit();
      } else {
        //check if email is valid
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../admin.php?verify=display&alert=invalidemail");
            exit();
          } else {
            //check correct fire id format
              if (!preg_match("/^[A-Z][A-Z]\d{4}$/", $fireid)) {
                header("Location: ../admin.php?verify=display&alert=invalidfireid");
                exit();
              } else {
                //check if posted fire id is different than db fire id; check if edited fire id is taken
                if ($fireid != $dbfireid) {

                      $sql = "SELECT * FROM members WHERE user_fireid='$fireid'";
                      $result = mysqli_query($conn, $sql);
                      $resultCheck = mysqli_num_rows($result);

                      if ($resultCheck > 0) {
                        header("Location: ../admin.php?verify=display&alert=usertaken");
                        exit();
                      }
                        else {
                        //update members table with verified access level, verified fire id, first name, last name, and email
                        $sql = "UPDATE members SET user_first='$first', user_last='$last', user_email='$email', user_fireid='$fireid', user_accesslvl='$access' WHERE user_fireid='$dbfireid';";
                        mysqli_query($conn, $sql);

                        //insert/create verified user into profile table and qualifications table

                            //insert into profile table
                            $sql = "INSERT INTO profile (user_fireid, fire_ems, iecs_rank, duty) VALUES ('$fireid', '$fireems', '$iecsrank', '$duty')";
                            mysqli_query($conn, $sql);
                            //insert into qualifications table
                            $sql = "INSERT INTO qualifications VALUES ('$fireid', '$emsobserve', '$fireobserve', '$emt', '$paramedic', '$engineff', '$truckff', '$ambdriver', '$engdriver', '$truckdriver', '$engineoic', '$truckoic', '$chief')";
                            mysqli_query($conn, $sql);

                            header("Location: ../admin.php?verify=display&alert=verified&fireid=$fireid");

                            //send e-mail notification of account activation
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
                                $mail->addAddress($email);                // Add a recipient

                                //Content
                                $body = "
                                  <p>Dear $first $last,</p>

                                  <p>Your Bethesda Fire Department Members' Portal Account has been verified and activated.</p>

                                  <p>You may now log in to your account with your Fire ID ($fireid) and password</p><br/>

                                  <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                                  <p>Thank you,</p>
                                  <p>Bethesda FD Administrator</p>
                                  ";

                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = "[BFD Member's Portal] Account Verified: $fireid";
                                $mail->Body    = $body;
                                $mail->AltBody = strip_tags($body);

                                $mail->send();

                            } catch (Exception $e) {
                              header("Location: ../admin.php?verify=display&alert=error");
                              $mail->ErrorInfo;
                            }
                            exit();
                          }

                } else {
                    //verified fire id == current db fire id, no check needed, proceed with verification and activation
                    //update members table with verified access level, verified fire id, first name, last name, and email
                    $sql = "UPDATE members SET user_first='$first', user_last='$last', user_email='$email', user_fireid='$fireid', user_accesslvl='$access' WHERE user_fireid='$dbfireid';";
                    mysqli_query($conn, $sql);

                        //insert/create verified user into profile table and qualifications table

                        //insert into profile table
                        $sql = "INSERT INTO profile (user_fireid, fire_ems, iecs_rank, duty) VALUES ('$fireid', '$fireems', '$iecsrank', '$duty')";
                        mysqli_query($conn, $sql);
                        //insert into qualifications table
                        $sql = "INSERT INTO qualifications VALUES ('$fireid', '$emsobserve', '$fireobserve', '$emt', '$paramedic', '$engineff', '$truckff', '$ambdriver', '$engdriver', '$truckdriver', '$engineoic', '$truckoic', '$chief')";
                        mysqli_query($conn, $sql);

                        header("Location: ../admin.php?verify=display&alert=verified&fireid=$fireid");

                        //send e-mail notification of account activation
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
                            $mail->addAddress($email);                // Add a recipient

                            //Content
                            $body = "
                              <p>Dear $first $last,</p>

                              <p>Your Bethesda Fire Department Members' Portal Account has been verified and activated.</p>

                              <p>You may now log in to your account with your Fire ID ($fireid) and password</p><br/>

                              <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                              <p>Thank you,</p>
                              <p>Bethesda FD Administrator</p>
                              ";

                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = "[BFD Member's Portal] Account Verified: $fireid";
                            $mail->Body    = $body;
                            $mail->AltBody = strip_tags($body);

                            $mail->send();

                        } catch (Exception $e) {
                          header("Location: ../admin.php?verify=display&alert=error");
                          $mail->ErrorInfo;
                        }
                        exit();

                    }
                      header("Location: ../admin.php?verify=display&alert=error");
                      exit();

            }
          }
        }
      }
    } //deleting an unverified user account
    elseif (isset($_GET['del_user'])) {

      include_once 'dbh.inc.php';
      $deleteuser = $_GET['del_user'];
      $sql = "SELECT * FROM members WHERE user_fireid='$deleteuser'";
      $result = mysqli_query($conn, $sql);
      $row = mysqli_fetch_assoc($result);
      $first = $row['user_first'];
      $last = $row['user_last'];
      $email = $row['user_email'];

      header("Location: ../admin.php?verify=display&alert=userdeleted&fireid=$deleteuser");
      //send e-mail notification of account activation
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
          $mail->addAddress($email);                // Add a recipient

          //Content
          $body = "
            <p>Dear $first $last,</p>

            <p>Your request for a Bethesda Fire Department Members' Portal Account has been denied; the Bethesda Fire Department's Members Portal is reserved for members of the Bethesda Fire Department, only.</p>

            <p>As a result, the unverified account you requested is now deleted.</p>

            <p>If you would like to become a member of the Bethesda Fire Department, please learn more about us on our website, contact us, or submit an application at http://www.bethesdafire.org.</p><br/>

            <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

            <p>Thank you,</p>
            <p>Bethesda FD Administrator</p>
            ";

          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = "[BFD Member's Portal] Account Verification Denied: $deleteuser";
          $mail->Body    = $body;
          $mail->AltBody = strip_tags($body);

          $mail->send();

      } catch (Exception $e) {
        header("Location: ../admin.php?verify=display&alert=error");
        $mail->ErrorInfo;
      }

      $sql = "DELETE FROM members WHERE user_fireid='$deleteuser'";
      mysqli_query($conn, $sql);
      $sql = "DELETE FROM profile WHERE user_fireid='$deleteuser'";
      mysqli_query($conn, $sql);
      $sql = "DELETE FROM qualifications WHERE user_fireid='$deleteuser'";
      mysqli_query($conn, $sql);
      exit();
    }
