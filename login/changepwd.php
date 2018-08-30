<?php
  include_once 'includes/dbh.inc.php';

  $codeCheck = $_GET['code'];
  $fireidCheck = $_GET['fireid'];
  $sql = "SELECT * FROM members WHERE user_fireid='$fireidCheck' AND pwd_reset='$codeCheck'";
  $result = mysqli_query($conn, $sql);

  while ($row = mysqli_fetch_assoc($result)) {
    $code = $row['pwd_reset'];
    $fireid = $row['user_fireid'];


  if (isset($_GET['code']) && $codeCheck == $code && $codeCheck !=0 && $fireidCheck == $fireid) {
    ?>
              <div class='main-form'>
                <form action='includes/changepwd.inc.php' method='POST'>
                  <h2 class='form-title'>Enter a new password</h2>
                  <h3 class='form-subtitle'>User Fire ID: <?php echo $fireid;?></h3>
                  <?php
                  if (isset($_GET['changePwd'])) {
                    $changePwdCheck = $_GET['changePwd'];
                    if ($changePwdCheck == "empty") {
                      echo "<p class='error'>Please enter your new password</p>";
                    }
                    elseif ($changePwdCheck == "error") {
                      echo "<p class='error'>Your password did not match!</p>";
                    }
                  }

                  ?>
                  <input type='hidden' name='fireid' value=<?php echo "'".$fireid."'";?>>
                  <input type='hidden' name='code' value=<?php echo "'".$code."'";?>>
                  <input type='password' name='newpwd' placeholder='New password'>
                  <input type='password' name='confnewpwd' placeholder='Confirm password'>
                  <button class='login-btn' type='submit' name='changepwd'>Change Password</button>
                  <div class='links'>
                    <h3><a href='index.php'>RETURN TO LOGIN</a></h3>
                  </div>
                </form>
              </div>
<?php
}  else {

      if (isset($_GET['code']) && $codeCheck == $code && $fireidCheck == $fireid) {
        if (isset($_GET['changePwd'])) {
          $changePwdCheck = $_GET['changePwd'];
          if ($changePwdCheck == "success") {
            ?>
            <div class="main-form">
                  <h2 class="login-title">Your password has been changed</h2>
                  <h3 class="form-subtitle">Return to the login page and login with your new password</h3>
                  <div class='links'>
                    <h3><a href='index.php'>RETURN TO LOGIN</a></h3>
                  </div>
              </div>
              <?php
              }
            } else {
                header("Location: ../index.php?login");
                exit();
            }
          } else {
              header("Location: ../index.php?login");
              exit();
            }

  }

}

  ?>
