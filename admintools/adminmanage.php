<section class="section section--menu">
  <div class="menu menu--bagot">
    <ul class="menu__list">
      <li class="menu__item"><a href="admin.php?dashboard" class="menu__link">Dashboard</a></li>
      <li class="menu__item"><a href="admin.php?verify=display" class="menu__link">Verify Users
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
      <li class="menu__item menu__item--current"><a href="admin.php?manage=display" class="menu__link">Manage Users</a></li>
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


<section class="main-wrapper" id="wrapper-adminmanage">

<div class="content">
  <h2>Verified Users in Database:</h2><br/>
  <p>Click on the 'Manage User' button to open the 'User Manager Form.' Review the user's information--including Fire ID, name, and e-mail--check the 'verify' boxes, and then submit the changes for the user account. An e-mail notification will be sent to the user for any submitted changes.</p>
  <br/><br/>
  <h2>Search:</h2><br/>
  <form id="manage-search" action="admin.php?manage=display" method="POST">
    <label for="fireid">Fire ID:</label>
    <input type="text" id="fireid" name="fireid"><br/><br/>
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname"><br/><br/>
    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname"><br/><br/>
    <button class="manage-search-btn" type="submit" name="manage-search-btn">Search User</button><br/><br/>
  </form>

  <?php
  /*alert return messages from user manager form*/
  if (isset($_GET['alert'])) {
    $manageCheck = $_GET['alert'];

    if ($manageCheck == "empty") {
      echo "<p class='error'>Error: Empty fields</p>";
    } elseif ($manageCheck == "invalid") {
      echo "<p class='error'>Error: Invalid characters in fields</p>";
    } elseif ($manageCheck == "invalidemail") {
      echo "<p class='error'>Error: Invalid E-mail</p>";
    } elseif ($manageCheck == "invalidfireid") {
      echo "<p class='error'>Error: Invalid Fire ID format</p>";
    } elseif ($manageCheck == "usertaken") {
      echo "<p class='error'>Error: User Fire ID already exists</p>";
    } elseif ($manageCheck == "error") {
      echo "<p class='error'>Error: An Error has occurred</p>";
    } elseif ($manageCheck == "updated") {
      echo "<p class='error'>Updated: User account ".$_GET['fireid']."'s information has been updated.</p>";
    } elseif ($manageCheck == "userdeleted") {
      echo "<p class='error'>Deleted: User account ".$_GET['fireid']." has been deleted.</p>";
    }
  }
  /**/
  if (isset($_POST['manage-search-btn'])) {
    $searchFireId = $_POST['fireid'];
    $searchFirst = $_POST['firstname'];
    $searchLast = $_POST['lastname'];

    if (empty($searchFireId) && empty($searchFirst) && empty($searchLast)) {
      echo "<p class='error'>Search Fields Empty: Please enter a Fire ID, first name, or last name into the search fields.</p>";
    }
  }
   ?>
  <br/>

    <?php

    include_once 'includes/dbh.inc.php';

    if (isset($_POST['manage-search-btn']) && (!empty($searchFireId) && !empty($searchFirst) && !empty($searchLast))) {
      /*Search for match all fields*/
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND (user_fireid='$searchFireId' AND user_first='$searchFirst' AND user_last='$searchLast') ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by fire id only*/
    elseif (isset($_POST['manage-search-btn']) && (!empty($searchFireId) && empty($searchFirst) && empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND user_fireid='$searchFireId' ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by first name only*/
    elseif (isset($_POST['manage-search-btn']) && (empty($searchFireId) && !empty($searchFirst) && empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND user_first='$searchFirst' ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by last name only*/
    elseif (isset($_POST['manage-search-btn']) && (empty($searchFireId) && empty($searchFirst) && !empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND user_last='$searchLast' ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by fire id or first name only*/
    elseif (isset($_POST['manage-search-btn']) && (!empty($searchFireId) && !empty($searchFirst) && empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND (user_fireid='$searchFireId' AND user_first='$searchFirst') ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by fire id or last name*/
    elseif (isset($_POST['manage-search-btn']) && (!empty($searchFireId) && empty($searchFirst) && !empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND (user_fireid='$searchFireId' AND user_last='$searchLast') ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    } /*Search by first name or last name*/
    elseif (isset($_POST['manage-search-btn']) && (empty($searchFireId) && !empty($searchFirst) && !empty($searchLast))) {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 AND (user_first='$searchFirst' AND user_last='$searchLast') ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    }
    else {
      $sql = "SELECT * FROM members WHERE user_accesslvl>0 ORDER BY user_fireid;";
      $result = mysqli_query($conn, $sql);
      $resultRows = mysqli_num_rows($result);
    }

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
              <form action="admin.php?manage=manageuser" method="POST">
                <input type="hidden" name="fireid" value="<?php echo $fireid ?>"></input>
                <input type="hidden" name="access" value="<?php echo $access ?>"></input>
                <button type="submit" name="manageuser-btn">Manage User</button>
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
