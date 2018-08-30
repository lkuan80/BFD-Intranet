<div class="main-form">

      <h2 class="form-title">Unauthorized Access</h2>

      <?php
      if (!isset($_GET['unauthorized'])){
        header("Location: ../index.php?login=?");
      }
      else {
        $unauthCheck = $_GET ['unauthorized'];

        if ($unauthCheck == "unauthorizedaccess") {
          echo "<h3 class='form-subtitle'>You must be a member of Bethesda Fire Department to gain access beyond this page.<br/><br/>If you are a current member, please submit a request for login.</h3>";

        }
        elseif ($unauthCheck == "verification") {
          echo "<h3 class='form-subtitle'>Your account has not yet been verified by a BFD Administrator.<br/><br/>Please reach out to a BFD administrator for access.</h3>";

        }
        elseif ($unauthCheck == "password") {
          echo "<h3 class='form-subtitle'>Your account password needs to be reset.<br/><br/>Please check your email and reset your password in order to regain access beyond this page.</h3>";

        }
        elseif ($unauthCheck == "unauthorized") {
          echo "<h3 class='form-subtitle'>You are not authorized to access this page.</h3>";

        }
      }

      ?>

      <div class="links">
        <h3><a href="index.php?form=requestlogin">REQUEST LOGIN</a></h3>
        <h3><a href="index.php">RETURN TO LOGIN</a></h3>
      </div>

  </form>
</div>
