<?php
include '../../server/connect.php';
include '../../server/functions.php';
if (isset($_POST["adminlogin"])) {
   $email = seo($_POST["email"]);
   $password = seo(md5($_POST["password"]));
   if (empty($email) or empty($password)) {
      header('Location: ../login?status=empty');
   } else {
      $checkAdmin = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND status = ?");
      $checkAdmin->execute([$email, $password, 1]);
      if ($checkAdmin->rowCount() > 0) {
         header('Location: ../');
      } else {
         header('Location: ../login?status=notuser');
      }
   }
}
