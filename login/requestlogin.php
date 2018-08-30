<div class="requestform">

    <form action="includes/requestlogin.inc.php" method="POST">

      <h2 class="form-title">Fill out the form below</h2>
      <h3 class="form-subtitle">and we will verify your membership</h3>

          <?php
          if (isset($_GET['first'])) {
            $first = $_GET['first'];
            echo '<input type="text" name="first" placeholder="First Name" value="'.$first.'">';
          }
          else {
            echo '<input type="text" name="first" placeholder="First Name">';
          }
          if (isset($_GET['last'])) {
            $last = $_GET['last'];
            echo '<input type="text" name="last" placeholder="Last Name" value="'.$last.'">';
          }
          else {
            echo '<input type="text" name="last" placeholder="Last Name">';
          }
           ?>

        <input type="email" name="email" placeholder="E-mail">

          <?php
            if (isset($_GET['fireid'])) {
              $fireid = $_GET['fireid'];
              echo '<input type="text" name="fireid" placeholder="Fire ID" value="'.$fireid.'">';
            }
            else {
              echo '<input type="text" name="fireid" placeholder="Fire ID">';
            }
            ?>

        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="confpwd" placeholder="Confirm Password">
        <button class="submit-btn" type="submit" name="submit">Submit</button>
        <div class="links">
          <h3><a href="index.php">RETURN TO LOGIN</a></h3>
        </div>
    </form>

    <?php

        if (!isset($_GET['form'])) {
            header("Location: ../index.php?login=?");
        }
          else {
            $formCheck = $_GET['form'];

            if ($formCheck == "empty") {
              echo "<p class='error'>Please fill in all of the fields</p>";
            }
            elseif ($formCheck == "invalid") {
              echo "<p class='error'>Invalid entry in field</p>";
            }
            elseif ($formCheck == "invalidemail") {
              echo "<p class='error'>Invalid e-mail entry</p>";
            }
            elseif ($formCheck == "invalidfireid") {
              echo "<p class='error'>Invalid Fire ID; use all caps!</p>";
            }
            elseif ($formCheck == "usertaken") {
              echo "<p class='error'>User already exists</p>";
            }
            elseif ($formCheck == "success") {
              echo "<p class='alert'>Your entry has been received!</p>";
            }
            elseif ($formCheck == "error") {
              echo "<p class='error'>An error has occured!</p>";
            }
            elseif ($formCheck == "password") {
              echo "<p class='error'>Password did not match!</p>";
            }
        }
     ?>

  </div>
