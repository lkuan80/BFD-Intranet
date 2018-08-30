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
  <title>Bethesda Fire Department | BFD IECS</title>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/header.css">
  <link rel="stylesheet" type="text/css" href="css/bfdiecs.css">
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

<div class="parallax-window" data-parallax="scroll" data-z-index="2" data-image-src="images/bannerImg.jpg"></div>

   <?php
   if (isset($_GET['display'])) {
     switch ($_GET['display']) {

       case 'profiles':
         include 'bfdiecs/bfdprofiles.php'; //show each user profile widget; widget would display basic profile info, have link to specific user profile; allow for sorting users
         break;

       case 'qualifications': //show list of individuals based on qualifications; allow for drop down search
         include 'bfdiecs/bfdqualifications.php';
         break;

       default:
         include 'bfdiecs/iecslist.php';
         break;
       }
    } else {
      include 'bfdiecs/iecslist.php'; //should default to show bfd iecs list based on iecs rank
    }

   ?>

</body>
</html>
