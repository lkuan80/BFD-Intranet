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
      <li class="menu__item"><a href="admin.php?manage=display" class="menu__link">Manage Users</a></li>
      <li class="menu__item menu__item--current"><a href="admin.php?blogs" class="menu__link">Approve Blogs</a></li>

    </ul>
  </div>
</section>


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

<section class="main-wrapper">

<div class="content">

  <?php

    echo "<h1>Approve Blogs | Work in progress...</h1>";


  ?>


</div>

</section>
