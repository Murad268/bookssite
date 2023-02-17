<?php
   if(isset($_SESSION["user_email"])) {
      $email = $_SESSION["user_email"];
      $getUserInfo = $dbh->prepare("SELECT * from users WHERE email = ?");
      $getUserInfo->execute([$email]);
      $userInfo = $getUserInfo->fetch(PDO::FETCH_ASSOC);
      $user_email = $userInfo["email"];
      $user_name = $userInfo["name"];
      $user_surname = $userInfo["surname"];
      $user_id = $userInfo["id"];
   }
?>