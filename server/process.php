<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
include './functions.php';
include './connect.php';
include './parameters.php';
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

   if(!empty($_POST["search"])) {
      $search = seo($_POST["search"]);
   } else {
      $search=seo($_POST["searching"]);
   }
   if(!empty($_POST["lang_id"])) {
      $lang_id = seo($_POST["lang_id"]);
   } else {
      $lang_id=seo($_POST["lang"]);
   }
   if(!empty($_POST["genre_id"])) {
      $genre_id = seo($_POST["genre_id"]);
   } else {
      $genre_id=seo($_POST["genre"]);
   }

   if(!empty($prev_url)) {
      header("Location:  ../?page=$page&category=$cat&search=$search&genre_id=$genre_id&lang_id=$lang_id");
   }
}

if(isset($_POST['searchInUn'])) {
   $page = $_POST["page"];
   $cat = $_POST["cat"];
   $prev_url = $_SERVER['HTTP_REFERER'];
   $search = seo($_POST["search"]);
  
   if(!empty($_POST["search"])) {
      $search = seo($_POST["search"]);
   } else {
      $search=seo($_POST["searching"]);
   }
   
   if(!empty($_POST["type_id"])) {
      $type_id = seo($_POST["type_id"]);
   } else {
      $type_id=seo($_POST["type"]);;
   }

   if(!empty($_POST["lang_id"])) {
      $lang_id = seo($_POST["lang_id"]);
   } else {
      $lang_id=seo($_POST["lang"]);
   }

   if(!empty($_POST["spec_id"])) {
      $spec_id = seo($_POST["spec_id"]);
   } else {
      $spec_id=seo($_POST["spec"]);
   }

   if(!empty($_POST["filter"])) {
      $filter = seo($_POST["filter"]);
   } else {
      $filter=seo($_POST["filtering"]);
   }
 
   if(!empty($prev_url)) {
      header("Location:  ../?page=$page&category=$cat&search=$search&type_id=$type_id&lang_id=$lang_id&spec_id=$spec_id&filter=$filter");
   }
}



if(isset($_POST['searchInManual'])) {
   $page = $_POST["page"];
   $cat = $_POST["cat"];
   $prev_url = $_SERVER['HTTP_REFERER'];
   $search = seo($_POST["search"]);
  
   if(!empty($_POST["search"])) {
      $search = seo($_POST["search"]);
   } else {
      $search=seo($_POST["searching"]);
   }
   
   if(!empty($_POST["sub_id"])) {
      $sub_id = seo($_POST["sub_id"]);
   } else {
      $sub_id=seo($_POST["subject"]);;
   }

   if(!empty($_POST["lang_id"])) {
      $lang_id = seo($_POST["lang_id"]);
   } else {
      $lang_id=seo($_POST["lang"]);
   }

   if(!empty($_POST["class_id"])) {
      $class_id = seo($_POST["class_id"]);
   } else {
      $class_id=seo($_POST["class"]);
   }

   if(!empty($_POST["filter"])) {
      $filter = seo($_POST["filter"]);
   } else {
      $filter=seo($_POST["filtering"]);
   }
 
   if(!empty($prev_url)) {
      header("Location:  ../?page=$page&category=$cat&search=$search&sub_id=$sub_id&lang_id=$lang_id&class_id=$class_id&filter=$filter");
   }
}


if(isset($_POST["add_comment"])) {
   $comment = seo($_POST["comment"]);
 
   if(empty($comment)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $postComment = $dbh->prepare('INSERT INTO comments (user_id, date, comment) VALUES (?,?,?)');
   $time = time();
   $postComment->execute([$user_id, $time, $comment]);
   if($postComment->rowCount() > 0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}


if(isset($_GET["compross"])) {
   if($_GET["compross"] == "delete") {
      $id = seo($_GET["id"]);
      if(empty($id)) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
      $getUComment = $dbh->prepare("SELECT * FROM comments WHERE id = ?");
      $getUComment->execute([$id]);
      $comment = $getUComment->fetch(PDO::FETCH_ASSOC);
      $getUser = $dbh->prepare("SELECT * FROM users WHERE id = ?");
      $getUser->execute([$comment["user_id"]]);
      $user = $getUser->fetch(PDO::FETCH_ASSOC);
      if($user["email"]==$user_email) {
         $deleteFetch = $dbh->prepare("DELETE FROM comments WHERE id = ?");
         $deleteFetch->execute([$id]);
         if($deleteFetch->rowCount() > 0) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
         }
      } else {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   } elseif($_GET["compross"] == "addraiting") {
         if(!isset($_GET["raiting"])) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] );
            if(empty($_GET["raiting"])) {
               header('Location: ' . $_SERVER['HTTP_REFERER'] );
            }
         } else {
            $raiting = seo($_GET["raiting"]);
            $id = seo($_GET["id"]);
            $getStars = $dbh->prepare("SELECT * FROM stars WHERE user_id = ? AND goods_id = ?");
            $getStars->execute([$user_id, $id]);
            if(!$getStars->rowCount() > 0) {
               $insertStar = $dbh->prepare('INSERT INTO stars (user_id, goods_id, star_count) VALUES (?,?,?)');
               $insertStar->execute([$user_id, $id, $raiting]);
               if($insertStar -> rowCount() > 0) {
                  $updateBooks = $dbh->prepare("UPDATE books SET stars=stars+?, countofb=countofb+1 WHERE id=?");
                  $updateBooks->execute([$raiting, $id]);
                  if($updateBooks->rowCount() > 0) {
                     header('Location: ' . $_SERVER['HTTP_REFERER'] );
                  }
               }
            } else {
               $updateStars = $dbh->prepare("UPDATE stars SET user_id=?, goods_id=?, star_count=? WHERE goods_id=? AND user_id=?");
               $updateStars->execute([$user_id, $id, $raiting, $id, $user_id]);
               if($updateStars -> rowCount() > 0) {
                  $getStar = $dbh->prepare("SELECT * FROM books WHERE id = ?");
                  $getStar->execute([$id]);
                  $star = $getStar->fetch(PDO::FETCH_ASSOC);
                  if($getStar->rowCount() > 0) {
                     $updateBooks = $dbh->prepare("UPDATE books SET stars=stars-?, countofb=countofb-1 WHERE id=?");
                     $updateBooks->execute([$star["stars"], $id]);
                     if($updateBooks->rowCount() > 0) {
                        $updateBooks = $dbh->prepare("UPDATE books SET stars=stars+?, countofb=countofb+1 WHERE id=?");
                        $updateBooks->execute([$raiting, $id]);
                        if($updateBooks->rowCount() > 0) {
                           header('Location: ' . $_SERVER['HTTP_REFERER'] );
                        }
                     }
                  }
               }
            }
         }
   }
}
?>

