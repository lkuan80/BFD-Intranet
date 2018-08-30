<div class="main-form">
  <form action="includes/login.inc.php" method="POST">
      <h2 class="login-title">Bethesda FD Members' Portal</h2>
      <?php
      if (!isset($_GET['login'])){
        echo "<p></p>";
      }
      else {
        $loginCheck = $_GET['login'];
        if ($loginCheck == "empty") {
          echo "<p class='error'>Please enter your login</p>";

        }
        elseif ($loginCheck == "error") {
          echo "<p class='error'>Invalid login</p>";

        }
        elseif ($loginCheck == "invalidfireid") {
          echo "<p class='error'>Invalid Fire ID; case sensitive!</p>";

        }
      }

      ?>
      <input type="text" name="fireid" placeholder="Fire ID">
      <input type="password" name="pwd" placeholder="Password">
      <button class="login-btn" type="submit" name="login">Login</button>
      <div class="links">
        <h3><a href="index.php?form=requestlogin">REQUEST LOGIN</a></h3>
        <h3><a href="index.php?reset=password">RESET PASSWORD</a></h3>
      </div>

  </form>
</div>
