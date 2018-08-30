<div class="main-form">
  <form action="includes/resetpwd.inc.php" method="POST">
      <h2 class="form-title">Enter your Fire ID and E-mail</h2>
      <h3 class="form-subtitle">and you will receive an e-mail</h3>
      <?php
      if (!isset($_GET['reset'])){
        header("Location: ../index.php?login=?");
      }
      else {
        $resetCheck = $_GET['reset'];
        if ($resetCheck == "empty") {
          echo "<p class='error'>Please enter your information</p>";
        }
        elseif ($resetCheck == "error") {
          echo "<p class='error'>Invalid user</p>";
        }
        elseif ($resetCheck == "invalidemail") {
          echo "<p class='error'>Invalid E-mail</p>";
        }
        elseif ($resetCheck == "invalidfireid") {
          echo "<p class='error'>Invalid Fire ID; case sensitive!</p>";
        }
        elseif ($resetCheck == "success") {
          echo "<p class='alert'>Password reset e-mail has been sent!</p>";
        }
        elseif ($resetCheck == "failed") {
          echo "<p class='alert'>Password reset e-mail failed to send.</p>";
        }
      }

      ?>
      <input type="text" name="fireid" placeholder="Fire ID">
      <input type="text" name="email" placeholder="E-mail">
      <button class="login-btn" type="submit" name="reset">Reset</button>
      <div class="links">
        <h3><a href="index.php">RETURN TO LOGIN</a></h3>

      </div>

  </form>
</div>
