<section class="section section--menu" id="Shylock">
  <div class="menu menu--shylock">
    <ul class="menu__list">
      <li class="menu__item menu__item--current"><a href="javascript:delay('bfdiecs.php?display')" class="menu__link">BFD IECS List</a></li>
      <li class="menu__item"><a href="javascript:delay('bfdiecs.php?display=profiles')" class="menu__link">User Profiles</a></li>
      <li class="menu__item"><a href="javascript:delay('bfdiecs.php?display=qualifications')" class="menu__link">Qualifications</a></li>
    </ul>
  </div>
</section>

<script src="js/classie.js"></script>

<script>
function delay (URL) {
    setTimeout( function() { window.location = URL }, 500 );
}

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

<section class="main-wrapper">

<div class="content">

<?php
  include_once 'includes/dbh.inc.php';
?>

  <h1><b>Bethesda Fire Dept's Integrated Emergency Command Structure (IECS) List</b></h1></br></br>
  <p>This IECS list replicates the MCFRS IECS list based on Bethesda Fire Department's internal database; this list is NOT a substitute for the MCFRS IECS List.</br></br>All personnel should always refer to the official <a href="https://www.montgomerycountymd.gov/frs-ql/resources/files/ofc/iecs/list/IecsDfrsLfrd.pdf">MCFRS IECS list</a> regarding his or her MCFRS operational status.</p>

  <div class="fire-iecs">
    <h2>Fire/Rescue Chief</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Chief' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p></br>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Captain</h2><br/>
      <?php
        $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
                FROM profile
                RIGHT JOIN members
                ON profile.user_fireid = members.user_fireid
                WHERE iecs_rank='Captain' AND fire_ems='Fire/Rescue';";

        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          $first = $row['user_first'];
          $last = $row['user_last'];
          echo "<p>".$first." ".$last."</p></br>";
        }
        ?>
        </br>
    <h2>Fire/Rescue Lieutenant</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Lieutenant' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Master Firefighter</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Master' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Firefighter III</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov III' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Firefighter II</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov II' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Firefighter I</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov I' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Recruit</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Recruit' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>Fire/Rescue Candidate</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Candidate' AND fire_ems='Fire/Rescue';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
  </div>

  <div class="ems-iecs">
    <h2>EMS Chief</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Chief' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider Captain</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Captain' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider Lieutenant</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Lieutenant' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider Master</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Master' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider III</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov III' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider II</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov II' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider I</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Firefighter/EMS Prov I' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider Recruit</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Recruit' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
      </br>
    <h2>EMS Provider Candidate</h2><br/>
      <?php
      $sql = "SELECT profile.iecs_rank, profile.fire_ems, members.user_first, members.user_last
              FROM profile
              RIGHT JOIN members
              ON profile.user_fireid = members.user_fireid
              WHERE iecs_rank='Candidate' AND fire_ems='EMS Only';";

      $result = mysqli_query($conn, $sql);

      while ($row = mysqli_fetch_assoc($result)) {
        $first = $row['user_first'];
        $last = $row['user_last'];
        echo "<p>".$first." ".$last."</p>";
      }
      ?>
    </br>
  </div>

</div>

</section>
