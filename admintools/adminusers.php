<section class="section section--menu">
  <div class="menu menu--bagot">
    <ul class="menu__list">
      <li class="menu__item"><a href="admin.php?dashboard" class="menu__link">Dashboard</a></li>
      <li class="menu__item <?php if (isset($_GET['verify'])){ echo "menu__item--current";} ?>"><a href="admin.php?verify=display" class="menu__link">Verify Users
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
      <li class="menu__item <?php if (isset($_GET['manage'])){ echo "menu__item--current";} ?>"><a href="admin.php?manage=display" class="menu__link">Manage Users</a></li>
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

<?php
if (isset($_POST['verifyuser-btn']) || isset($_POST['manageuser-btn'])) {
?>
<section class="main-wrapper" id="wrapper-adminusers">

<div class="content">
<h1><b>USER:</b>
  <?php
    $getFireId = $_POST['fireid'];
    $getAccess = $_POST['access'];
    /*include other $_POST inputs from search filters*/
    echo $getFireId;

  ?>
</h1><br/><br/>

<?php
include_once 'includes/dbh.inc.php';

$sql = "SELECT * FROM members WHERE user_fireid='$getFireId' AND user_accesslvl='$getAccess'";
$result = mysqli_query($conn, $sql);

  if ($row = mysqli_fetch_assoc($result)) {
      if (isset($_GET['verify'])) {
        echo "<form class='user-form' id='verify-form' action='includes/verifyuser.inc.php' method='POST'>";
        echo "<div class='user-form-title'><h1>User Verification Form</h1></div>";
      } elseif (isset($_GET['manage'])) {
        echo "<form class='user-form' id='manage-form' action='includes/manageuser.inc.php' method='POST'>";
        echo "<div class='user-form-title'><h1>User Manager Form</h1></div>";
      }
    ?>

    <div class="form-container">
      <div class="user-info">
    <!--user fire id-->
      <label for='fireid'>Fire ID:</label>
      <input class='verify-input' type='text' id='fireid' name='fireid' value='<?php echo $row['user_fireid']?>' required><br/>
      <input class='check' type='checkbox' onclick='lockInput()' required>Verify</input><br/><br/>
      <input type="hidden"  name="dbfireid" value="<?php echo $row['user_fireid']?>">
    <!--user first name-->
      <label for='firstname'>First Name:</label>
      <input class='verify-input' type='text' id='firstname' name='firstname' value='<?php echo $row['user_first']?>' required><br/>
      <input class='check' type='checkbox' onclick='lockInput()' required>Verify</input><br/><br/>
    <!--user last name-->
      <label for='lastname'>Last Name:</label>
      <input class='verify-input' type='text' id='lastname' name='lastname' value='<?php echo $row['user_last']?>' required><br/>
      <input class='check' type='checkbox' onclick='lockInput()' required>Verify</input><br/><br/>
    <!--user email-->
      <label for='email'>E-mail:</label>
      <input class='verify-input' type='email' id='email' name='email' value='<?php echo $row['user_email']?>' required><br/>
      <input class='check' type='checkbox' onclick='lockInput()' required>Verify</input><br/><br/>
    <!--select access level-->
      <label for="accesslvl">Access Level</label>
      <?php if (isset($_GET['verify'])) {
        echo "<select name='accesslvl' form='verify-form'>";
      } elseif (isset($_GET['manage'])) {
        echo "<select name='accesslvl' form='manage-form'>";
      } ?>
        <option value=1 <?php if ($row['user_accesslvl']==1){echo "selected";}?>>Member</option>
        <option value=2 <?php if ($row['user_accesslvl']==2){echo "selected";}?>>Officer</option>
        <option value=3 <?php if ($row['user_accesslvl']==3){echo "selected";}?>>Site Admin</option>
        <option value=0 <?php if ($row['user_accesslvl']==0){echo "selected";}?>>No Access</option>
      </select><br/><br/>
    <!--sql query for profile table-->
      <?php
        $sqlProfile = "SELECT * FROM profile WHERE user_fireid='$getFireId';";
        $resultProfile = mysqli_query($conn, $sqlProfile);
        $rowProfile = mysqli_fetch_assoc($resultProfile);
      ?>
    <!--select fire/ems/admin-->
      <label for="fireems">Fire/EMS/Admin</label>
      <?php
      if (isset($_GET['verify'])) {
        echo "<select name='fireems' form='verify-form'>";
      } elseif (isset($_GET['manage'])) {
        echo "<select name='fireems' form='manage-form'>";
      } ?>
        <option value="EMS Only" <?php if ($rowProfile['fire_ems']=="EMS Only"){echo "selected";}?>>EMS Only</option>
        <option value="Fire/Rescue" <?php if ($rowProfile['fire_ems']=="Fire/Rescue"){echo "selected";}?>>Fire/Rescue</option>
        <option value="Administrative" <?php if ($rowProfile['fire_ems']=="Administrative"){echo "selected";}?>>Administrative</option>
      </select><br/><br/>
    <!--select IECS Rank-->
      <label for="rank">IECS Rank</label>
      <?php if (isset($_GET['verify'])) {
        echo "<select name='rank' form='verify-form'>";
      } elseif (isset($_GET['manage'])) {
        echo "<select name='rank' form='manage-form'>";
      } ?>
        <option value="Administrative" <?php if ($rowProfile['iecs_rank']=="Administrative"){echo "selected";}?>>Administrative</option>
        <option value="Candidate" <?php if ($rowProfile['iecs_rank']=="Candidate"){echo "selected";}?>>Candidate</option>
        <option value="Recruit" <?php if ($rowProfile['iecs_rank']=="Recruit"){echo "selected";}?>>Recruit</option>
        <option value="Firefighter/EMS Prov I" <?php if ($rowProfile['iecs_rank']=="Firefighter/EMS Prov I"){echo "selected";}?>>Firefighter/EMS Prov I</option>
        <option value="Firefighter/EMS Prov II" <?php if ($rowProfile['iecs_rank']=="Firefighter/EMS Prov II"){echo "selected";}?>>Firefighter/EMS Prov II</option>
        <option value="Firefighter/EMS Prov III" <?php if ($rowProfile['iecs_rank']=="Firefighter/EMS Prov III"){echo "selected";}?>>Firefighter/EMS Prov III</option>
        <option value="Master" <?php if ($rowProfile['iecs_rank']=="Master"){echo "selected";}?>>Master</option>
        <option value="Lieutenant" <?php if ($rowProfile['iecs_rank']=="Lieutenant"){echo "selected";}?>>Lieutenant</option>
        <option value="Captain" <?php if ($rowProfile['iecs_rank']=="Captain"){echo "selected";}?>>Captain</option>
        <option value="Chief" <?php if ($rowProfile['iecs_rank']=="Chief"){echo "selected";}?>>Chief</option>
      </select><br/><br/>
    <!--select Duty Crew-->
      <label for="duty">Duty Crew</label>
      <?php if (isset($_GET['verify'])) {
        echo "<select name='duty' form='verify-form'>";
      } elseif (isset($_GET['manage'])) {
        echo "<select name='duty' form='manage-form'>";
      } ?>
        <option value="Monday" <?php if ($rowProfile['duty']=="Monday"){echo "selected";}?>>Monday</option>
        <option value="Tuesday" <?php if ($rowProfile['duty']=="Tuesday"){echo "selected";}?>>Tuesday</option>
        <option value="Wednesday" <?php if ($rowProfile['duty']=="Wednesday"){echo "selected";}?>>Wednesday</option>
        <option value="Thursday" <?php if ($rowProfile['duty']=="Thursday"){echo "selected";}?>>Thursday</option>
        <option value="Friday" <?php if ($rowProfile['duty']=="Friday"){echo "selected";}?>>Friday</option>
        <option value="Saturday Day" <?php if ($rowProfile['duty']=="Saturday Day"){echo "selected";}?>>Saturday Day</option>
        <option value="Saturday Night" <?php if ($rowProfile['duty']=="Saturday Night"){echo "selected";}?>>Saturday Night</option>
        <option value="Sunday Day" <?php if ($rowProfile['duty']=="Sunday Day"){echo "selected";}?>>Sunday Day</option>
        <option value="Sunday Night" <?php if ($rowProfile['duty']=="Sunday Night"){echo "selected";}?>>Sunday Night</option>
        <option value="Roving Crew" <?php if ($rowProfile['duty']=="Roving Crew"){echo "selected";}?>>Roving Crew</option>
        <option value="Administrative" <?php if ($rowProfile['duty']=="Administrative"){echo "selected";}?>>Administrative</option>
      </select><br/></br>
      <!--select Committee; only displayed in Manage Users tool-->
      <?php
        if (isset($_GET['manage'])) { ?>
          <label for='committee'>Committee</label>
          <select name='committee' form='manage-form'>
            <option value='N/A' <?php if ($rowProfile['committee']=='N/A'){echo "selected";} ?>>N/A</option>
            <option value='Membership' <?php if ($rowProfile['committee']=="Membership"){echo "selected";}?>>Membership</option>
            <option value='Fundraising' <?php if ($rowProfile['committee']=="Fundraising"){echo "selected";}?>>Fundraising</option>
            <option value='Activities' <?php if ($rowProfile['committee']=="Activities"){echo "selected";}?>>Activities</option>
            <option value='Apparatus' <?php if ($rowProfile['committee']=="Apparatus"){echo "selected";}?>>Apparatus</option>
          </select><br/>
        <?php
        }
       ?>
    </div> <!--/div user profile info-->
    <span class="divider"></span>
    <div class="qualifications">
    <!--sql query for qualifications table-->
    <?php
      $sqlQualifications = "SELECT * FROM qualifications WHERE user_fireid='$getFireId';";
      $resultQualifications = mysqli_query($conn, $sqlQualifications);
      $rowQualifications = mysqli_fetch_assoc($resultQualifications);
    ?>
    <!--select qualifications-->
    <label>Qualifications</label><br/><br/><br/>
      <input type="checkbox" value=1 name="emsobserve" <?php if ($rowQualifications['emsobserve'] == 1){echo "checked";}?>>EMS Observer</input><br/><br/>
      <input type="checkbox" value=1 name="fireobserve" <?php if ($rowQualifications['fireobserve'] == 1){echo "checked";}?>>Fire Observer</input><br/><br/>
      <input type="checkbox" value=1 name="emt" <?php if ($rowQualifications['emt'] == 1){echo "checked";}?>>Charge EMT</input><br/><br/>
      <input type="checkbox" value=1 name="paramedic" <?php if ($rowQualifications['paramedic'] == 1){echo "checked";}?>>Charge Paramedic</input><br/><br/>
      <input type="checkbox" value=1 name="engineff" <?php if ($rowQualifications['engineff'] == 1){echo "checked";}?>>Lead FF, Engine</input><br/><br/>
      <input type="checkbox" value=1 name="truckff" <?php if ($rowQualifications['truckff'] == 1){echo "checked";}?>>Lead FF, Truck</input><br/><br/>
      <input type="checkbox" value=1 name="ambdriver" <?php if ($rowQualifications['ambdriver'] == 1){echo "checked";}?>>Ambulance Driver</input><br/><br/>
      <input type="checkbox" value=1 name="engdriver" <?php if ($rowQualifications['engdriver'] == 1){echo "checked";}?>>Engine Driver</input><br/><br/>
      <input type="checkbox" value=1 name="truckdriver" <?php if ($rowQualifications['truckdriver'] == 1){echo "checked";}?>>Truck Driver</input><br/><br/>
      <input type="checkbox" value=1 name="engineoic" <?php if ($rowQualifications['engineoic'] == 1){echo "checked";}?>>Engine Officer</input><br/><br/>
      <input type="checkbox" value=1 name="truckoic" <?php if ($rowQualifications['truckoic'] == 1){echo "checked";}?>>Truck Officer</input><br/><br/>
      <input type="checkbox" value=1 name="chief" <?php if ($rowQualifications['chief'] == 1){echo "checked";}?>>Chief Officer</input>
    </div> <!--/div qualifications-->
  </div> <!--/end form-container-->
    <div class="btn-div">
    <!--submit button-->
      <?php
      if (isset($_GET['verify'])) {
        echo "<button class='submit-btn' type='submit' name='verify-submit'>Submit</button>";
        echo "<button class='submit-btn' type='button' onClick='deleteunverified()'>Delete User</button>";
      } elseif (isset($_GET['manage'])) {
        echo "<button class='submit-btn' type='submit' name='manage-submit'>Submit</button>";
        echo "<button class='submit-btn' type='button' onClick='deleteuser()'>Delete User</button>";
      }

      ?>
    </div> <!--/div submit button-->
      </form>
<?php
  } else {
    echo "<h2>ERROR: No User Data Available</h2>";
  }

?>

</div><!--/content-->

</section><!--/main-wrapper-->

<script>
//checkbox function for verifying critical input fields, ie user's first/last name, fire id, and email
function lockInput() {
  // Get the checkbox
  var checkBox = document.getElementsByClassName("check");
  var verifyInput = document.getElementsByClassName("verify-input");

  for (var i = 0; i < checkBox.length; i++) {
    if (checkBox[i].checked == true) {
      verifyInput[i].style.border = "1px solid #8BC572";
      verifyInput[i].readOnly = true;
    } else {
      verifyInput[i].style.border = "inherit";
      verifyInput[i].style.borderBottom = "1px solid #727274";
      verifyInput[i].readOnly = false;
    }
  }
};

//delete unverified user function (verify user form)
function deleteunverified() {

  var deleteunverified = confirm("Are you sure you want to delete this unverified user?");

  if (deleteunverified == true) {
    window.location.href="includes/verifyuser.inc.php?del_user=<?php echo $row['user_fireid']; ?>";
  }

};

//delete verified user in database (manage user form)
function deleteuser() {

  var deleteuser = confirm("Are you sure you want to delete this user?");

  if (deleteuser == true) {
    window.location.href="includes/manageuser.inc.php?del_user=<?php echo $row['user_fireid']; ?>";
  }

};

</script>

<?php
}
else {
  echo "<section class='main-wrapper'><div class='content'><h1>Error: No Users to Display</h1></div></section>";
  exit();
}
?>
