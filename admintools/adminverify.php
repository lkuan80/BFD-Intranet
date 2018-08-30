<section class="section section--menu">
  <div class="menu menu--bagot">
    <ul class="menu__list">
      <li class="menu__item"><a href="admin.php?dashboard" class="menu__link">Dashboard</a></li>
      <li class="menu__item menu__item--current"><a href="admin.php?verify=display" class="menu__link">Verify Users
          <?php //counter shows number of unverified users requesting login
             include_once 'includes/dbh.inc.php';
             $sql = "SELECT * FROM members WHERE user_accesslvl=0";
             $result = mysqli_query($conn, $sql);
             $resultRows = mysqli_num_rows($result);

             if ($resultRows > 0) {
               echo " (".$resultRows.")";
             } else {
               echo "";
             }
           ?>
       </a>
      </li>
      <li class="menu__item"><a href="admin.php?manage=display" class="menu__link">Manage Users</a></li>
      <li class="menu__item"><a href="admin.php?blogs" class="menu__link">Approve Blogs</a></li>

    </ul>
  </div>
</section>

<!--Javascript for in page navigation-->
<script src="js/classie.js"></script>
<script>
(function() {
[].slice.call(document.querySelectorAll('.menu')).forEach(function(menu) {
  var menuItems = menu.querySelectorAll('.menu__link'),
    setCurrent = function(ev) {

      var item = ev.target.parentNode; // li

      // return if already current
      if (classie.has(item, 'menu__item--current')) {
        return false;
      }
      // remove current
      classie.remove(menu.querySelector('.menu__item--current'), 'menu__item--current');
      // set current
      classie.add(item, 'menu__item--current');
    };

  [].slice.call(menuItems).forEach(function(el) {
    el.addEventListener('click', setCurrent);

  });
});

})(window);
</script>
<!--/in page navigation-->


<section class="main-wrapper">

<div class="content">
<h2>Unverified Users:</h2><br/>
<p>Click on the 'Verify User' button to open the 'User Verification Form.' Review the user's information, including Fire ID, name, and e-mail. Then, select the users' web portal access level, IECS Rank, Duty Crew, and Qualifications. Upon verifying the information and activating the account, the user will receive an e-mail notification.</p>
<br/>
<?php
/*alert messages from user verification form*/ 
if (isset($_GET['alert'])) {
  $verifyCheck = $_GET['alert'];

  if ($verifyCheck == "empty") {
    echo "<p class='error'>Error: Empty fields</p>";
  } elseif ($verifyCheck == "invalid") {
    echo "<p class='error'>Error: Invalid characters in fields</p>";
  } elseif ($verifyCheck == "invalidemail") {
    echo "<p class='error'>Error: Invalid E-mail</p>";
  } elseif ($verifyCheck == "invalidfireid") {
    echo "<p class='error'>Error: Invalid Fire ID format</p>";
  } elseif ($verifyCheck == "usertaken") {
    echo "<p class='error'>Error: User Fire ID already exists</p>";
  } elseif ($verifyCheck == "error") {
    echo "<p class='error'>Error: An Error has occurred</p>";
  } elseif ($verifyCheck == "verified") {
    echo "<p class='error'>Verified: User account ".$_GET['fireid']."'s information verified, updated, and activated.</p>";
  } elseif ($verifyCheck == "userdeleted") {
    echo "<p class='error'>Deleted: User account ".$_GET['fireid']." has been deleted.</p>";
  }
}
 ?>
<br/>

  <?php
  include_once 'includes/dbh.inc.php';
  $sql = "SELECT * FROM members WHERE user_accesslvl=0";
  $result = mysqli_query($conn, $sql);
  $resultRows = mysqli_num_rows($result);

  if ($resultRows > 0) {
    echo "<div class='users-display'>";

    while ($row = mysqli_fetch_assoc($result)) {
      $fireid = $row['user_fireid'];
      $firstname = $row['user_first'];
      $lastname = $row['user_last'];
      $access = $row['user_accesslvl'];
      ?>
        <div class="user-row">
          <span class="user-id">
            <h3>Fire ID: <?php echo $fireid?></h3>
            <h3>Name: <?php echo $firstname." ".$lastname?></h3>
          </span>
          <span class="user-btn">
            <form action="admin.php?verify=verifyuser" method="POST">
              <input type="hidden" name="fireid" value="<?php echo $fireid ?>"></input>
              <input type="hidden" name="access" value="<?php echo $access ?>"></input>
              <button type="submit" name="verifyuser-btn">Verify User</button>
            </form>
          </span>
        </div>

    <?php
        }
        echo "</div>"; //end div unverified-display
      } else {
        echo "<div class='users-display'><h1>No users to display</h1></div>";
      }
    ?>

  </div><!--/content-->

  </section><!--/main-wrapper-->
