<?php
   include "../server/connect.php";
   if(isset($_SESSION["admin"])) {
      $email = $_SESSION["admin"];
      $getAminInfo = $dbh->prepare("SELECT * from users WHERE email = ?");
      $getAminInfo->execute([$email]);
      $adminInfo = $getAminInfo->fetch(PDO::FETCH_ASSOC);
      $admin_email = $adminInfo["email"];
      $admin_name = $adminInfo["name"];
      $admin_surname = $adminInfo["surname"];
      $admin_status = $adminInfo["status"]=="1"?"admin":($adminInfo["status"]=="2"?"baş admin":"");
   }
?>