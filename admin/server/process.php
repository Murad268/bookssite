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
      $checkAdmin = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND (status = ? OR status = ?)");
      $checkAdmin->execute([$email, $password, 1, 2]);
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

if(isset($_POST["searchAuthor"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=authors&search=".$search); 
   }
}


if(isset($_POST["changeAuthor"])) {
   $name = seo($_POST["author_name"]);
   $desc = seo($_POST["author_desc"]);
   $id = seo($_POST["id"]);

   if(empty($name) OR empty($desc)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $updateAuthor = $dbh->prepare('UPDATE authors SET author_name=?, author_desc = ? WHERE id = ?');
   $updateAuthor->execute([$name, $desc, $id]);
   if($updateAuthor->rowCount() > 0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   
}