<link rel="stylesheet" type="text/css" href="css/bfdprofiles.css">

<section class="section section--menu" id="Shylock">
  <div class="menu menu--shylock">
    <ul class="menu__list">
      <li class="menu__item"><a href="javascript:delay('bfdiecs.php?display')" class="menu__link">BFD IECS List</a></li>
      <li class="menu__item menu__item--current"><a href="javascript:delay('bfdiecs.php?display=profiles')" class="menu__link">User Profiles</a></li>
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

<div class="content" id="content-bfdprofiles">

<?php
   include_once 'includes/dbh.inc.php';

   $sql = "SELECT * FROM members WHERE user_accesslvl > 0";
   $result = mysqli_query($conn, $sql);

   if (mysqli_num_rows($result) > 0) {
       while ($row = mysqli_fetch_assoc($result)) {
         $fireid = $row['user_fireid'];
         $sqlProf = "SELECT * FROM profile WHERE user_fireid='$fireid'";
         $resultProf = mysqli_query($conn, $sqlProf);
         while ($rowProf = mysqli_fetch_assoc($resultProf)){
           echo "
             <ul id='widgets' class='widgets'>

               <li class='grid'>
                 <h3>".$row['user_fireid']."</h3><h3>".$row['user_first']." ".$row['user_last']."</h3>
                 <div class='overlay'>
                   <span class='close'>close</span>
                   <div class='overlay-full'>
                     <div><span class='overlay-title'><b>".$row['user_fireid']." <br/><br/>".$row['user_first']." ".$row['user_last']."</b></span></div>";

             if ($rowProf['propic_check'] == 1) {
               //find proper file extension
               $imgName = "uploads/profile".$fireid."*";
               $imgInfo = glob($imgName);
               $imgExt = explode(".", $imgInfo[0]);
               $imgActualExt = $imgExt[1];
               echo "<div><img src='uploads/profile".$fireid.".".$imgActualExt."?".mt_rand()."'>";
             } else { /*default profile image*/
               echo "<div><img src='uploads/ninjaCat.jpg'>";
             }

           echo "<span class='overlay-content'><b>Phone:</b> ".$rowProf['phone_number']."<br/><b>Email:</b> ".$row['user_email']."<br/><br/><b>IECS Rank:</b> ".$rowProf['iecs_rank']."<br/><b>Duty Crew:</b> ".$rowProf['duty']."<br/><b>Committee:</b> ".$rowProf['committee']."</span></div>
                  </div> <!--/overlay-full-->
                 </div> <!--/overlay-->
               </li></ul>";
         }
       }
     } else {
       echo "There are no users!";
     }
 ?>

   <script src="js/modernizr.custom.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
   <script src="js/jquery.fittext.js"></script>
   <script src="js/widgets.js"></script>
   <script>
     $(function() {
       Boxgrid.init();
     });
   </script>

</div>

</section>
