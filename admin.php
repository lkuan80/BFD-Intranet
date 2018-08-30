<?php

  session_start();
//check for access level and login session
  if (isset($_SESSION['u_fireid']) && $_SESSION['u_accesslvl'] != 3) {
    header("Location: index.php?unauthorized=unauthorized");
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

  } elseif (isset($_SESSION['u_fireid']) && $_SESSION['u_accesslvl'] == 3) {
    //database connection after verifying access
    include_once 'includes/dbh.inc.php';
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-compatible" content="ie=edge">
  <title>Bethesda Fire Department | Admin's Tools</title>
  <link rel="stylesheet" type="text/css" href="css/reset.css">
  <link rel="stylesheet" type="text/css" href="css/header.css">
  <link rel="stylesheet" type="text/css" href="css/admin.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="http://code.jquery.com/jquery-3.2.1.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!--link to Google fonts-->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,700,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=IBM+Plex+Mono" rel="stylesheet">

</head>

<body>

<?php
include_once 'header.php';
 ?>

<section class="title">
  <h1>Admin Tools</h1>
</section>


   <?php
     if (!isset($_GET['dashboard']) && !isset($_GET['verify']) && !isset($_GET['manage']) && !isset($_GET['blogs'])) {
       include 'admintools/admindash.php';
     } else {
       if (isset($_GET['dashboard'])) {
           include 'admintools/admindash.php';
       } elseif (isset($_GET['verify'])) {

          if ($_GET['verify'] == "display") {
            include 'admintools/adminverify.php';
          } elseif ($_GET['verify'] == "verifyuser") {
            include 'admintools/adminusers.php';
          }
       } elseif (isset($_GET['manage'])) {

          if ($_GET['manage'] == "display") {
            include 'admintools/adminmanage.php';
          } elseif ($_GET['manage'] == "manageuser") {
            include 'admintools/adminusers.php';
          }
       } elseif (isset($_GET['blogs'])) {
           include 'admintools/adminblogs.php';
       }
     }

    ?>


</body>
</html>
