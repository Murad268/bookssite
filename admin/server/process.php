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
   $lang = seo($_POST["lang__id"]);
   if(empty($author_name) OR empty($author_desc)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      $postAuthor = $dbh->prepare("INSERT INTO authors (author_name, author_desc, lang_İd) VALUES (?,?,?)");
      $postAuthor->execute([$author_name, $author_desc, $lang]);
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
   $lang__id = seo(($_POST["lang__id"]));

   if(empty($name) OR empty($desc) or empty($lang__id)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $updateAuthor = $dbh->prepare('UPDATE authors SET author_name=?, author_desc = ?, lang_İd = ? WHERE id = ?');
   $updateAuthor->execute([$name, $desc, $lang__id, $id]);
   if($updateAuthor->rowCount() > 0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }  
}


if(isset($_POST['add__lang'])) {
   $lang_name = seo($_POST["lang_name"]);

   if(empty($lang_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $addLang = $dbh->prepare("INSERT INTO language (name) VALUES (?)");
   $addLang->execute([$add__lang]);
   if($addLang->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_GET['langproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM language WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_POST['add__genre'])) {
   $genre_name = seo($_POST["genre_name"]);
   $lang = seo($_POST["lang__id"]);
   if(empty($genre_name) OR empty($lang)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $addLang = $dbh->prepare("INSERT INTO genres (name, lang_İd) VALUES (?, ?)");
   $addLang->execute([$genre_name, $lang]);
   if($addLang->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}
if(isset($_GET['genreproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM genres WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_POST["searchGenre"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=genres&search=".$search); 
   }
}

if(isset($_POST['add__class'])) {
   $genre_name = seo($_POST["class_name"]);
   $lang = seo($_POST["lang__id"]);
   if(empty($genre_name) OR empty($lang)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $addClass = $dbh->prepare("INSERT INTO classes (name, lang_id) VALUES (?, ?)");
   $addClass->execute([$genre_name, $lang]);
   if($addClass->rowCount()>0) {

      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_POST["searchClass"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=classes&search=".$search); 
   }
}
if(isset($_GET['classproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM classes WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}


if(isset($_POST['add__subject'])) {
   $subject_name = seo($_POST["subject_name"]);
   $lang = seo($_POST["lang__id"]);
   if(empty($subject_name) OR empty($lang)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $addSubject = $dbh->prepare("INSERT INTO subjects (name, lang_id) VALUES (?, ?)");
   $addSubject->execute([$subject_name, $lang]);
   if($addSubject->rowCount()>0) {

      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_POST["searchSubjects"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=subjects&search=".$search); 
   }
}
if(isset($_GET['subjectproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM subjects WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}


if(isset($_POST['add__specialities'])) {
   $speciality_name = seo($_POST["speciality_name"]);
   $lang = seo($_POST["lang__id"]);
   if(empty($speciality_name) OR empty($lang)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
   $addSubject = $dbh->prepare("INSERT INTO specialties (name, lang_id) VALUES (?, ?)");
   $addSubject->execute([$speciality_name, $lang]);
   if($addSubject->rowCount()>0) {

      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}


if(isset($_POST["searchSpeciality"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=specialties&search=".$search); 
   }
}


if(isset($_GET['specialityproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM specialties WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}

if(isset($_POST["add__book"])) {
   $book_src = $_FILES["book_src"];
   $book__name = seo($_POST["book_name"]);
   $lang__id = seo($_POST["lang__id"]);
   $author__id = seo($_POST["author__id"]);
   $sale = seo($_POST["sale"]);
   $book_price = seo($_POST["book_price"]);
   $new = seo($_POST["new"]);

   if($book_src["error"] == 4 OR empty($book__name) OR empty($lang__id) OR empty($author__id) OR empty($sale) OR empty($book__name) OR empty($book_price) OR  empty($new)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

   $postBook = $dbh->prepare("INSERT INTO books (src, book_name, author_id, sale, price, new, lang_id) VALUES (?,?,?,?,?,?,?)");
   $postBook->execute([$book_src["name"], $book__name, $author__id, $sale, $book_price, $new, $lang__id]);

   if($postBook->rowCount() > 0) {
      if(move_uploaded_file($book_src["tmp_name"], "../assets/img/books/".$book_src["name"])) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }
}




if(isset($_GET['bookproc'])) {
   if($_GET['bookproc']=="delete") {
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM books WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   } elseif($_GET['bookproc']=="addsale") {
      $id = seo($_GET["id"]);
      echo $id;
      $updateFetch = $dbh->prepare("UPDATE books SET sale = ? WHERE id = ?");
      $updateFetch->execute([1, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   } elseif($_GET['bookproc']=="remsale") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET sale = ? WHERE id=?");
      $removeFetch->execute([2, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   } elseif($_GET['bookproc']=="addnew") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET new = ? WHERE id=?");
      $removeFetch->execute([1, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   } elseif($_GET['bookproc']=="remnew") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET new = ? WHERE id=?");
      $removeFetch->execute([2, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
   }

}


