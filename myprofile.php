<?php

  session_start();
//check for login session and access level
  if (isset($_SESSION['u_fireid']) && $_SESSION['u_accesslvl'] == 0) {
    header("Location: index.php?unauthorized=verification");
    session_unset();
    session_destroy();
    exit();

  } //check for pwd_reset
    elseif ($_SESSION['u_pwd_reset'] != 0) {
    header("Location: index.php?unauthorized=password");
    session_unset();
    session_destroy();
    exit();

  } //check if session is set
    elseif(!isset($_SESSION['u_fireid'])) {
    header("Location: index.php?unauthorized=unauthorizedaccess");
    session_unset();
    session_destroy();
    exit();

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-compatible" content="ie=edge">
  <title>Bethesda Fire Department | Profile: <?php echo $_SESSION['u_first'] . " " . $_SESSION['u_last'] ?></title>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/header.css">
  <link rel="stylesheet" type="text/css" href="css/myprofile.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="js/parallax/parallax.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900" rel="stylesheet">

</head>

<body>

<?php
include_once 'header.php';
 ?>
<!--
 <section class="banner">
   <div class="banner-title">
     <hgroup>
       <?php/*
        if ($_SESSION['u_accesslvl'] ==3) {
         echo "<h1>Admin</h1>";

       } elseif ($_SESSION['u_accesslvl'] > 0 && $_SESSION['u_accesslvl'] < 3) {
          echo "<h1>".$_SESSION['u_first']." ".$_SESSION['u_last']."</h1>";
        }*/
         ?>
     </hgroup>
   </div>

   <div class="banner-bg">
   </div>
 </section>

 <script src="js/banner.js"></script> -->

 <section class="main-wrapper">
   <div class="parallax-window" data-parallax="scroll" data-z-index="2" data-image-src="images/bannerImg.jpg"></div>

   <hgroup class="header-widget">
     <!--Form for submitting profile picture-->
     <div id="pro-pic">
       <?php

         include_once 'includes/dbh.inc.php';
         $fireid = $_SESSION['u_fireid'];
         $sqlProf = "SELECT * FROM profile WHERE user_fireid='$fireid'";
         $resultProf = mysqli_query($conn, $sqlProf);
         $rowProf = mysqli_fetch_assoc($resultProf);

         if ($rowProf['propic_check'] == 1) {                 //check setting for default pic or if user has uploaded profile pic
           //find proper file extension
           $imgName = "uploads/profile".$fireid."*";
           $imgInfo = glob($imgName);
           $imgExt = explode(".", $imgInfo[0]);
           $imgActualExt = $imgExt[1];

           echo "<img src='uploads/profile".$fireid.".".$imgActualExt."?".mt_rand()."'>"; //if propic_check is 1, user has uploaded a profile image; display profile image
         } else {                                             //default profile image = ninjaCat!
           echo "<img src='uploads/ninjaCat.jpg'>";
         }
        ?>
     </div>
   </hgroup>

   <div class="content">

     <!--Upload profile image form-->
     <form action="includes/imgupload.inc.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <button type="submit" name="submitimg">UPLOAD</button>
     </form>

     <!--Delete profile image form-->
     <form action="includes/deleteimg.inc.php" method="POST">
        <button type="submit" name="submitimg">DELETE</button>
     </form>
     <br/>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In bibendum purus ligula, at interdum purus molestie nec. Praesent eu maximus arcu. Duis ante arcu, convallis nec lorem eu, molestie bibendum leo. Quisque eu magna at velit sollicitudin ornare tempor eu justo. Etiam ante urna, ornare in consequat ut, condimentum sit amet erat. Aenean efficitur dignissim lectus eu porta. Mauris convallis non nisl eget rhoncus. Fusce nisi est, malesuada sed bibendum sit amet, mattis nec magna. Donec vitae elit mauris. Aenean et tellus venenatis, luctus odio a, luctus nulla.</p>

     <p>Sed pretium pulvinar interdum. Mauris imperdiet, libero at mattis scelerisque, eros risus condimentum massa, sit amet laoreet augue justo id velit. Etiam convallis quis elit nec fringilla. Proin maximus tincidunt egestas. Nullam pretium arcu nec purus maximus, et tristique orci venenatis. Maecenas vulputate dapibus luctus. Aliquam a eros eget mauris blandit cursus. Mauris sapien justo, accumsan id felis sit amet, pulvinar dignissim risus. Vestibulum vitae dui at velit euismod lobortis sodales sit amet tellus. Pellentesque a aliquet dui. Curabitur dictum odio vitae tempor commodo.</p>

     <p>Donec risus nisl, condimentum eu lacus et, congue consectetur neque. Interdum et malesuada fames ac ante ipsum primis in faucibus. Proin eu est dictum, congue metus in, vehicula sem. Cras nec vulputate massa. Sed ut tristique odio. Vivamus vitae dui venenatis libero vulputate interdum. Aenean consectetur ligula quis nibh accumsan fringilla. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce eu enim sit amet nisi convallis pretium. Cras sed varius quam. Fusce metus nibh, convallis ut feugiat volutpat, luctus quis felis. Morbi eleifend lectus ut aliquet sodales.</p>

     <p>Proin luctus gravida pretium. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus ultrices tincidunt lobortis. Morbi fringilla viverra mauris a tristique. Aenean ut ex vulputate, elementum metus vitae, pulvinar metus. Nam id purus purus. Praesent accumsan vehicula auctor. Phasellus ac scelerisque lorem. Nullam leo enim, ullamcorper eget fermentum dictum, gravida quis dui.</p>

     <p>Sed euismod et quam ut efficitur. Nam faucibus, sem eget cursus tempus, ipsum nisl lacinia velit, vel posuere neque lorem a tellus. Cras et quam vel quam aliquet pulvinar vitae vel magna. Donec nec nunc imperdiet ex vulputate aliquam nec et mauris. Sed sollicitudin eleifend quam eu tincidunt. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Fusce ut elementum felis. Duis ultricies orci lacus. Integer consequat vehicula posuere. Mauris lacus augue, gravida at erat vel, dictum imperdiet ex. Aenean id rutrum justo. Sed ultrices convallis ante, at pretium arcu malesuada nec. Vestibulum nec volutpat lorem. Integer accumsan imperdiet justo vitae viverra. Proin egestas dolor in elit iaculis, et faucibus purus placerat. Proin pretium neque eget ligula condimentum, quis semper urna malesuada.
      </p>
   </div>

 </section>


</body>
</html>
