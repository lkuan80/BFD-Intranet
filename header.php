<header>
  <nav>
      <span id="bfdlogo"><a href="http://www.bethesdafire.org"><b>Bethesda</b> Fire Dept</a></span>
      <div id="navi">
        <ul id="menu">
            <li><a href="myprofile.php">My Profile</a></li>
            <li><a href="home.php">Home</a></li>
            <li><a id="toggleduty">Duty Night Crew</a></li>
            <li><a id="togglecomm">Committees</a></li>
            <li><a href="bfdiecs.php">BFD IECS</a></li>
            <li><a href="#">Fire/Rescue Resources</a></li>

            <!-- link to admin tool and officers' tools (for admin and officer session)-->
                <?php
                  if (isset($_SESSION['u_fireid']) && $_SESSION['u_accesslvl'] == 3) {

                    echo "<li><a href='admin.php'>Admin Tools</a></li>";
                  } elseif (isset($_SESSION['u_fireid']) && $_SESSION['u_accesslvl'] == 2) {

                    echo "<li><a href='#'>Officers' Tools</a></li>";
                  }
                ?>
            <!--display profile and logout button after login-->
                    <div class="nav-profile">
                      <form action="includes/logout.inc.php" method="POST">
                          <button type="submit" name="logout">Logout</button>
                      </form>

                      <?php
                        if (isset($_SESSION['u_fireid'])) {
                          echo "You are logged in! ";
                          echo $_SESSION['u_fireid'];
                        }
                       ?>

                    </div>

        </ul>

      </div>

      <div id="duty">
        <ul>
          <li><a href="#">Monday Crew</a></li>
          <li><a href="#">Tuesday Crew</a></li>
          <li><a href="#">Wednesday Crew</a></li>
          <li><a href="#">Thursday Crew</a></li>
          <li><a href="#">Friday Crew</a></li>
          <li><a href="#">Sat Day Crew</a></li>
          <li><a href="#">Sat Night Crew</a></li>
          <li><a href="#">Sun Day Crew</a></li>
          <li><a href="#">Sun Night Crew</a></li>
        </ul>
      </div>

      <div id="committees">
        <ul>
          <li><a href="#">Membership</a></li>
          <li><a href="#">Fundraising</a></li>
          <li><a href="#">Activities</a></li>
          <li><a href="#">Apparatus</a></li>
        </ul>
      </div>

      <div id="toggle">
        <div class="span" id="one"></div>
        <div class="span" id="two"></div>
        <div class="span" id="three"></div>
      </div>

      <div id="triangle">
        <div class="span" id="right"></div>
        <div class="span" id="bottom"></div>
        <div class="span" id="left"></div>
      </div>

      <div id="square">
        <div class="span" id="right"></div>
        <div class="span" id="bottom"></div>
        <div class="span" id="left"></div>
        <div class="span" id="top"></div>
      </div>

  </nav>

<script>

  $("#toggle").click(function() {

    $(this).toggleClass("on");
    $("#navi").toggleClass("active");
  });

  $("#toggleduty").click(function() {

    $("#toggle").toggleClass("hide");
    $("#triangle").toggleClass("on");
    $("#duty").toggleClass("active");
  });

  $("#triangle").click(function() {

    $("#toggle").toggleClass("hide");
    $("#triangle").toggleClass("on");
    $("#duty").toggleClass("active");
  });

  $("#togglecomm").click(function() {

    $("#toggle").toggleClass("hide");
    $("#square").toggleClass("on");
    $("#committees").toggleClass("active");
  });

  $("#square").click(function() {

    $("#toggle").toggleClass("hide");
    $("#square").toggleClass("on");
    $("#committees").toggleClass("active");
  });


</script>


</header>
