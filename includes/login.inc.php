<?php

session_start();

if (isset($_POST['login'])) {

  include_once 'dbh.inc.php';

  $fireid = mysqli_real_escape_string($conn, $_POST['fireid']);
  $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

//error handlers
//check if inputs are empty
  if (empty($fireid) || empty($pwd)) {
    header("Location: ../index.php?login=empty");
    exit();
  } else {
    //check if user exists
      $sql = "SELECT * FROM members WHERE user_fireid='$fireid'";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
        if($resultCheck < 1) {
          header("Location: ../index.php?login=error");
          exit();
        } else {
          //check correct fireID case format
          if (!preg_match("/^[A-Z][A-Z]\d{4}$/", $fireid)) {
            header("Location: ../index.php?login=invalidfireid");
            exit();
          } else {
            if ($row = mysqli_fetch_assoc($result)) {
              //de-hashing password
              $hashedPwdCheck = password_verify($pwd, $row['user_pwd']);
              if ($hashedPwdCheck == false) {
                header("Location: ../index.php?login=error");
                exit();
              } elseif ($hashedPwdCheck == true) {
                  //log in the user here
                  $_SESSION['u_first'] = $row['user_first'];
                  $_SESSION['u_last'] = $row['user_last'];
                  $_SESSION['u_email'] = $row['user_email'];
                  $_SESSION['u_fireid'] = $row['user_fireid'];
                  $_SESSION['u_accesslvl'] = $row['user_accesslvl'];
                  $_SESSION['u_pwd_reset'] = $row['pwd_reset'];

                  header("Location: ../home.php?login=success");
                  exit();
              }
            }
          }
        }
  }

} else {
    header("Location: ../index.php?login=error");
    exit();
}
