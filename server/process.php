<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include './functions.php';
include './connect.php';
if (isset($_POST['registration'])) {
   $email = seo($_POST["email"]);
   $name = seo($_POST["name"]);
   $surname = seo($_POST["surname"]);

   if (empty($email) or empty($name) or empty($surname)) {
      header('Location: ../registration?status=empty');
   } else {
      try {
         $searchUser = $dbh->prepare("SELECT * FROM users WHERE email = ?");
         $searchUser->execute([$email]);
         $countUser = $searchUser->rowCount();
         if ($countUser > 0) {
            header('Location: ../registration?status=therisemail');
         } else {
            $newPassword = passwordGenerator();
            $postNewUser = $dbh->prepare('INSERT INTO users (name, surname, email, password) VALUES (?,?,?,?)');
            $postNewUser->execute([$name, $surname, $email, md5($newPassword)]);
            if ($postNewUser->rowCount() > 0) {
               $message = "Sizin təyin edilmiş şifrəniz: " . $newPassword . " şifrənizi istənilən vaxt 'mənim hesabım' bölməsində dəyişə bilərsiniz";
               $mail = new PHPMailer();
               $mail->SMTPDebug = SMTP::DEBUG_SERVER;
               $mail->CharSet = 'UTF-8';                   //Enable verbose debug output
               $mail->isSMTP();                                            //Send using SMTP
               $mail->Host       = 'smtp.mail.ru';                     //Set the SMTP server to send through
               $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
               $mail->Username   = 'agamedov94@mail.ru';                     //SMTP username
               $mail->Password   = '';                               //SMTP password
               $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
               $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
               //Recipients
               $mail->setFrom('agamedov94@mail.ru', $name . " " . $surname);
               $mail->addAddress($email, $name);     //Add a recipient
               // $mail->addAddress('ellen@example.com');               //Name is optional
               // $mail->addReplyTo('info@example.com', 'Information');
               // $mail->addCC('cc@example.com');
               // $mail->addBCC('bcc@example.com');

               //Attachments
               // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
               // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

               //Content
               $mail->isHTML(true);                                  //Set email format to HTML
               $mail->Subject = 'skybooks qeydiyyat';
               $mail->Body  = $message;
               $mail->send();
               header('Location: ../login?status=ok');
            } else {
               header('Location: ../registration?status=error');
            }
         }
         //Server settings

      } catch (Exception $e) {
         header('Location: ../registration?status=error');
      }
   }
}

if(isset($_POST["login"])) {
   $email = seo($_POST["email"]);
   $password = seo(md5($_POST["password"]));


   if(empty($email) or empty($password)) {
      header('Location: ../login?status=empty');
   } else {
      $checkUser = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
      $checkUser->execute([$email, $password]);

      if($checkUser->rowCount()>0) {
         $_SESSION["user_email"] = $email;
         header('Location: ../');
      } else {
         header('Location: ../login?status=notuser');
      }
   }


}



if(isset($_GET["pros"])) {
   if($_GET["pros"] == "exit") {
      session_destroy();
      header('Location: ../');
   }
}


if(isset($_POST['searchInBooks'])) {
   $page = $_POST["page"];
   $cat = $_POST["cat"];
   $prev_url = $_SERVER['HTTP_REFERER'];
   $search = seo($_POST["search"]);
   $lang_id = seo($_POST["lang_id"]);
   $genre_id = seo($_POST["genre_id"]);
   if(!empty($prev_url)) {
      header("Location:  ../?page=$page&category=$cat&search=$search&genre_id=$genre_id&lang_id=$lang_id");
   }
}



?>

