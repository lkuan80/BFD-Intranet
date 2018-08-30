<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['manage-submit'])) {

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
  $committee = $_POST['committee'];
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
    header("Location: ../admin.php?manage=display&alert=empty");
    exit();
  } else {
    //check if name input characters are valid
      if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
        header("Location: ../admin.php?manage=display&alert=invalid");
        exit();
      } else {
        //check if email is valid
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../admin.php?manage=display&alert=invalidemail");
            exit();
          } else {
            //check correct fire id format
              if (!preg_match("/^[A-Z][A-Z]\d{4}$/", $fireid)) {
                header("Location: ../admin.php?manage=display&alert=invalidfireid");
                exit();
              } else {
                //check if posted fire id is different than db fire id; check if edited fire id is taken
                if ($fireid != $dbfireid) {

                      $sql = "SELECT * FROM members WHERE user_fireid='$fireid'";
                      $result = mysqli_query($conn, $sql);
                      $resultCheck = mysqli_num_rows($result);

                      if ($resultCheck > 0) {
                        header("Location: ../admin.php?manage=display&alert=usertaken");
                        exit();
                      }
                        else {
                        //update members table with verified access level, verified fire id, first name, last name, and email
                        $sql = "UPDATE members SET user_first='$first', user_last='$last', user_email='$email', user_fireid='$fireid', user_accesslvl='$access' WHERE user_fireid='$dbfireid';";
                        mysqli_query($conn, $sql);

                            //update profile table
                            $sql = "UPDATE profile SET user_fireid='$fireid', fire_ems='$fireems', iecs_rank='$iecsrank', duty='$duty', committee='$committee' WHERE user_fireid='$dbfireid'";
                            mysqli_query($conn, $sql);
                            //insert into qualifications table
                            $sql = "UPDATE qualifications
                                    SET user_fireid='$fireid', emsobserve='$emsobserve', fireobserve='$fireobserve', emt='$emt', paramedic='$paramedic', engineff='$engineff', truckff='$truckff', ambdriver='$ambdriver', engdriver='$engdriver', truckdriver='$truckdriver', engineoic='$engineoic', truckoic='$truckoic', chief='$chief'
                                    WHERE user_fireid='$dbfireid'";
                            mysqli_query($conn, $sql);

                            header("Location: ../admin.php?manage=display&alert=updated&fireid=$fireid");

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

                                  <p>Your Bethesda Fire Department Members' Portal Account has recently been updated.</p>

                                  <p>Log in to your account with your Fire ID ($fireid) and password to see the changes.</p><br/>

                                  <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                                  <p>Thank you,</p>
                                  <p>Bethesda FD Administrator</p>
                                  ";

                                $mail->isHTML(true);                                  // Set email format to HTML
                                $mail->Subject = "[BFD Member's Portal] Account Updated: $fireid";
                                $mail->Body    = $body;
                                $mail->AltBody = strip_tags($body);

                                $mail->send();

                            } catch (Exception $e) {
                              header("Location: ../admin.php?manage=display&alert=error");
                              $mail->ErrorInfo;
                            }
                            exit();
                          }

                } else {
                    //verified fire id == current db fire id, no check needed, proceed with updating user account
                    //update members table with verified fire id, first name, last name, and email
                    $sql = "UPDATE members SET user_first='$first', user_last='$last', user_email='$email', user_fireid='$fireid', user_accesslvl='$access' WHERE user_fireid='$dbfireid';";
                    mysqli_query($conn, $sql);

                        //update user in profile table and qualifications table
                        $sql = "UPDATE profile SET user_fireid='$fireid', fire_ems='$fireems', iecs_rank='$iecsrank', duty='$duty', committee='$committee' WHERE user_fireid='$dbfireid'";
                        mysqli_query($conn, $sql);
                        //insert into qualifications table
                        $sql = "UPDATE qualifications
                                SET user_fireid='$fireid', emsobserve='$emsobserve', fireobserve='$fireobserve', emt='$emt', paramedic='$paramedic', engineff='$engineff', truckff='$truckff', ambdriver='$ambdriver', engdriver='$engdriver', truckdriver='$truckdriver', engineoic='$engineoic', truckoic='$truckoic', chief='$chief'
                                WHERE user_fireid='$dbfireid'";
                        mysqli_query($conn, $sql);

                        header("Location: ../admin.php?manage=display&alert=updated&fireid=$fireid");

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

                              <p>Your Bethesda Fire Department Members' Portal Account has recently been updated.</p>

                              <p>Log in to your account with your Fire ID ($fireid) and password to see the changes.</p><br/>

                              <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

                              <p>Thank you,</p>
                              <p>Bethesda FD Administrator</p>
                              ";

                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = "[BFD Member's Portal] Account Updated: $fireid";
                            $mail->Body    = $body;
                            $mail->AltBody = strip_tags($body);

                            $mail->send();

                        } catch (Exception $e) {
                          header("Location: ../admin.php?manage=display&alert=error");
                          $mail->ErrorInfo;
                        }
                        exit();

                    }
                      header("Location: ../admin.php?manage=display&alert=error");
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

      header("Location: ../admin.php?manage=display&alert=userdeleted&fireid=$deleteuser");
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

            <p>Your Bethesda Fire Department Members' Portal Account has been deleted; the Bethesda Fire Department's Members Portal is reserved for current members of the Bethesda Fire Department, only.</p>

            <p>If this is a mistake, please contact the Bethesda Fire Department Web Portal Administrator at admn.bfdintranet@gmail.com.</p>

            <p>This is an auto-generated e-mail. Do not reply to this e-mail.</p><br/>

            <p>Best,</p>
            <p>Bethesda FD Administrator</p>
            ";

          $mail->isHTML(true);                                  // Set email format to HTML
          $mail->Subject = "[BFD Member's Portal] Account Deleted: $deleteuser";
          $mail->Body    = $body;
          $mail->AltBody = strip_tags($body);

          $mail->send();

      } catch (Exception $e) {
        header("Location: ../admin.php?manage=display&alert=error");
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
