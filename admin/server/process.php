<?php
session_start();
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
         $_SESSION["admin"] = $email;
         header('Location: ../');
      } else {
         header('Location: ../login?status=notuser');
      }
   }
}



if(isset($_POST["add_author"])) {
   $author_name = seo($_POST["author_name"]);
   $author_desc = seo($_POST["author_desc"]);
   if(empty($author_name) OR empty($author_desc)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      $postAuthor = $dbh->prepare("INSERT INTO authors (author_name, author_desc) VALUES (?,?)");
      $postAuthor->execute([$author_name, $author_desc]);
      if($postAuthor->rowCount() > 0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }
}

if(isset($_GET["author_process"])) {
   if(isset($_GET["id"])) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $deleteFetch = $dbh->prepare("DELETE FROM authors WHERE id = ?");
   $deleteFetch->execute([$_GET["id"]]);
   if( $deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}