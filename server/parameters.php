<?php
   if(isset($_SESSION["user_email"])) {
      $email = $_SESSION["user_email"];
      $getAminInfo = $dbh->prepare("SELECT * from users WHERE email = ?");
      $getAminInfo->execute([$email]);
      $adminInfo = $getAminInfo->fetch(PDO::FETCH_ASSOC);
      $user_email = $adminInfo["email"];
      $user_name = $adminInfo["name"];
      $user_surname = $adminInfo["surname"];
   }
?>