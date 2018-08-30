<?php

if (isset($_POST['changepwd'])) {

  include_once 'dbh.inc.php';

  $newPwd = $_POST['newpwd'];
  $confNewPwd = $_POST['confnewpwd'];
  $fireid =  $_POST['fireid'];
  $code = $_POST['code'];

  if (empty($newPwd) || empty($confNewPwd)) {
    header("Location: ../index.php?code=$code&fireid=$fireid&changePwd=empty");
    exit();
  } else {
    if ($newPwd == $confNewPwd) {
      //hash new password
      $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);

      $sql = "UPDATE members SET user_pwd='$hashedPwd', pwd_reset='0' WHERE user_fireid='$fireid'";
      mysqli_query($conn, $sql);

      header("Location: ../index.php?code=0&fireid=$fireid&changePwd=success");
    }
      else {
        header("Location: ../index.php?code=$code&fireid=$fireid&changePwd=error");
        exit();
      }
  }

} else {
  header("Location: ../index.php");
  exit();
}



?>
