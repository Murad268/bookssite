<?php
session_start();
include '../../server/connect.php';
include '../../server/functions.php';
if (isset($_POST["adminlogin"])) {
   $email = seo($_POST["email"]);
   $password = seo(md5($_POST["password"]));
   if (empty($email) or empty($password)) {
      header('Location: ../login?status=empty');
      exit;
   } else {
      $checkAdmin = $dbh->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND (status = ? OR status = ?)");
      $checkAdmin->execute([$email, $password, 1, 2]);
      if ($checkAdmin->rowCount() > 0) {
         $_SESSION["admin"] = $email;
         header('Location: ../');
         exit;
      } else {
         header('Location: ../login?status=notuser');
         exit;
      }
   }
}



if(isset($_POST["add_author"])) {
   $author_name = seo($_POST["author_name"]);
   $author_desc = seo($_POST["author_desc"]);
   if(empty($author_name) OR empty($author_desc)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      $postAuthor = $dbh->prepare("INSERT INTO authors (author_name, author_desc) VALUES (?,?)");
      $postAuthor->execute([$author_name, $author_desc]);
      if($postAuthor->rowCount() > 0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }
}

if(isset($_GET["author_process"])) {
 
   if($_GET["author_process"] == "delete") {
      if(!isset($_GET["id"])) {
    
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
      $deleteFetch = $dbh->prepare("DELETE FROM authors WHERE id = ?");
      $deleteFetch->execute([$_GET["id"]]);
      if( $deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }

}

if(isset($_POST["searchAuthor"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=authors&search=".$search); 
      exit;
   }
}


if(isset($_POST["changeAuthor"])) {
   $name = seo($_POST["author_name"]);
   $desc = seo($_POST["author_desc"]);
   $id = seo($_POST["id"]);


   if(empty($name) OR empty($desc)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $updateAuthor = $dbh->prepare('UPDATE authors SET author_name=?, author_desc = ? WHERE id = ?');
   $updateAuthor->execute([$name, $desc, $id]);
   if($updateAuthor->rowCount() > 0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }  
}


if(isset($_POST['add__lang'])) {
   $lang_name = seo($_POST["lang_name"]);

   if(empty($lang_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addLang = $dbh->prepare("INSERT INTO language (name) VALUES (?)");
   $addLang->execute([$lang_name]);
   if($addLang->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_GET['langproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM language WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_POST['add__genre'])) {
   $genre_name = seo($_POST["genre_name"]);
   if(empty($genre_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addLang = $dbh->prepare("INSERT INTO genres (name) VALUES (?)");
   $addLang->execute([$genre_name]);
   if($addLang->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}
if(isset($_GET['genreproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM genres WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_POST["searchGenre"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=genres&search=".$search); 
      exit;
   }
}

if(isset($_POST['add__class'])) {
   $genre_name = seo($_POST["class_name"]);

   if(empty($genre_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addClass = $dbh->prepare("INSERT INTO classes (name) VALUES (?)");
   $addClass->execute([$genre_name]);
   if($addClass->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_POST["searchClass"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=classes&search=".$search); 
      exit;
   }
}
if(isset($_GET['classproc'])) {
   $id = seo($_GET["id"]);

   $deleteFetch = $dbh->prepare("DELETE FROM classes WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}


if(isset($_POST['add__subject'])) {
   $subject_name = seo($_POST["subject_name"]);
   if(empty($subject_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addSubject = $dbh->prepare("INSERT INTO subjects (name) VALUES (?)");
   $addSubject->execute([$subject_name]);
   if($addSubject->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_POST["searchSubjects"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=subjects&search=".$search); 
      exit;
   }
}
if(isset($_GET['subjectproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM subjects WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}


if(isset($_POST['add__specialities'])) {
   $speciality_name = seo($_POST["speciality_name"]);
   if(empty($speciality_name)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addSubject = $dbh->prepare("INSERT INTO specialties (name) VALUES (?)");
   $addSubject->execute([$speciality_name]);
   if($addSubject->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}


if(isset($_POST["searchSpeciality"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   } else {
      header("Location: ../?page=specialties&search=".$search); 
      exit;
   }
}


if(isset($_GET['specialityproc'])) {
   $id = seo($_GET["id"]);
   $deleteFetch = $dbh->prepare("DELETE FROM specialties WHERE id = ?");
   $deleteFetch->execute([$id]); 
   if($deleteFetch->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
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
   $book_pdf = $_FILES["book_pdf"];
   $genre__id = seo($_POST["genre__id"]);
   $cat__id  = seo($_POST["cat__id"]);
   if(empty($cat__id) OR empty($cat__id) OR $book_pdf["error"] == 4 OR $book_src["error"] == 4 OR empty($book__name) OR empty($lang__id) OR empty($author__id) OR empty($sale) OR empty($book__name) OR empty($book_price) OR  empty($new)) {

      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }

   $postBook = $dbh->prepare("INSERT INTO books (genre__id, cat__id, src, book_name, book_pdf, author_id, sale, price, new, lang_id) VALUES (?,?,?,?,?,?,?,?,?,?)");
   $postBook->execute([$genre__id,  $cat__id, $book_src["name"], $book__name, $book_pdf["name"], $author__id, $sale, $book_price, $new, $lang__id]);

   if($postBook->rowCount() > 0) {
      if(move_uploaded_file($book_src["tmp_name"], "../assets/img/books/".$book_src["name"])) {
         if(move_uploaded_file($book_pdf["tmp_name"], "../assets/pdfs/books/".$book_pdf["name"])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
         }
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
         exit;
      }
   } elseif($_GET['bookproc']=="addsale") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE books SET sale = ? WHERE id = ?");
      $updateFetch->execute([1, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['bookproc']=="remsale") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET sale = ? WHERE id=?");
      $removeFetch->execute([2, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['bookproc']=="addnew") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET new = ? WHERE id=?");
      $removeFetch->execute([1, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['bookproc']=="remnew") {
      $id = seo($_GET["id"]);
      $removeFetch = $dbh->prepare("UPDATE books SET new = ? WHERE id=?");
      $removeFetch->execute([2, $id]); 
      if($removeFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }

}




if(isset($_POST["searchBook"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=addbook&search=".$search); 
      exit;
   }
}





if(isset($_POST['add__type'])) {
   $type = seo($_POST["type"]);
   if(empty($type) ) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addType = $dbh->prepare("INSERT INTO types (name) VALUES (?)");
   $addType->execute([$type]);
   if($addType->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}


if(isset($_POST["searchType"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=types&search=".$search); 
      exit;
   }
}

if(isset($_GET["typepros"])) {
   if($_GET["typepros"] == "delete") {
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM types WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }
}


if(isset($_POST["add__un"])) {
   $name = seo($_POST["un_name"]);
   $sale = seo($_POST["sale"]);
   $price = seo($_POST["un_price"]);
   $lang_id = seo($_POST["lang__id"]);
   $book_pdf = $_FILES["un_pdf"];
   $type_id = seo($_POST["type__id"]);
   $speciality_id = seo($_POST["spec__id"]);
   $cat__id = seo($_POST["cat__id"]);
   if(empty($cat__id) OR empty($name) OR empty($sale) OR empty($price) OR empty($lang_id) OR $book_pdf["error"] == 4 OR empty($type_id) OR empty($speciality_id)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }

   $addUn = $dbh->prepare("INSERT INTO university (name, cat__id, sale, price, lang_id, book_pdf, type_id, speciality_id) VALUES (?,?,?,?,?,?,?,?)");
   $addUn->execute([$name, $cat__id, $sale, $price, $lang_id, $book_pdf["name"], $type_id, $speciality_id]);
   if($addUn->rowCount()>0) {
      if(move_uploaded_file($book_pdf["tmp_name"], "../assets/pdfs/uni/".$book_pdf["name"]))
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}



if(isset($_GET["unpros"])) {
   if($_GET["unpros"] == "delete") {
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM university WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['unpros']=="addsale") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE university SET sale = ? WHERE id = ?");
      $updateFetch->execute([1, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['unpros']=="remsale") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE university SET sale = ? WHERE id = ?");
      $updateFetch->execute([2, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }
}



if(isset($_POST["searchUn"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=university&search=".$search); 
      exit;
   }
}





if(isset($_POST["add__manual"])) {
   $book_src = $_FILES["book_src"];
   $book_pdf = $_FILES["book_pdf"];
   $name = seo($_POST["name"]);
   $lang__id = seo($_POST["lang__id"]);
   $class__id = seo($_POST["class__id"]);
   $sub__id = seo($_POST["sub__id"]);
   $type__id = seo($_POST["type__id"]);
   $authors = seo($_POST["authors"]);
   $sale = seo($_POST["sale"]);
   $price = seo($_POST["price"]);
   $new = seo($_POST["new"]);
   $cat__id = seo($_POST["cat__id"]);

   if($book_pdf["error"] == 4 OR $book_src["error"] == 4 OR empty($name) OR empty($lang__id) OR empty($class__id) OR empty($sub__id) OR empty($type__id) OR empty($authors) OR  empty($sale) OR  empty($price) OR  empty($new)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }

   $postManual = $dbh->prepare("INSERT INTO manuals (cat__id, src, name, sale, price,  new, lang_id, book_pdf, authors, class_id, sub__id, type_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
   $postManual->execute([$cat__id, $book_src["name"], $name, $sale, $price, $new,  $lang__id, $book_pdf["name"], $authors, $class__id, $sub__id, $type__id]);

   if($postManual->rowCount() > 0) {
      if(move_uploaded_file($book_src["tmp_name"], "../assets/img/manuals/".$book_src["name"])) {
         if(move_uploaded_file($book_pdf["tmp_name"], "../assets/pdfs/manuals/".$book_pdf["name"])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
         }
      }
   }
}


if(isset($_GET["manualspec"])) {
   echo $_GET['manualspec'];
   
   if($_GET['manualspec'] == "delete") {
 
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM manuals WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['manualspec']=="addsale") {
  
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE manuals SET sale = ? WHERE id = ?");
      $updateFetch->execute([1, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['manualspec']=="remsale") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE manuals SET sale = ? WHERE id = ?");
      $updateFetch->execute([2, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['manualspec']=="addnew") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE manuals SET new = ? WHERE id = ?");
      $updateFetch->execute([1, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   } elseif($_GET['manualspec']=="remnew") {
      $id = seo($_GET["id"]);
      $updateFetch = $dbh->prepare("UPDATE manuals SET new = ? WHERE id = ?");
      $updateFetch->execute([2, $id]); 
      if($updateFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      }
   }
}


if(isset($_POST["searchManual"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=manuals&search=".$search); 
      exit;
   }
}




if(isset($_POST['add__cat'])) {
   $cat_name = seo($_POST["cat_name"]);

   if(empty($cat_name) ) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addCat = $dbh->prepare("INSERT INTO categories (name) VALUES (?)");
   $addCat->execute([$cat_name]);
   if($addCat->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
}

if(isset($_POST["searchCat"])) {
   $search = seo($_POST["search"]);
   if(empty($search)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   } else {
      header("Location: ../?page=categories&search=".$search); 
      exit;
   }
}
if(isset($_GET['catpros'])) {
   if($_GET["catpros"] == "delete") {
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM categories WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      } 
   }
}



if(isset($_POST['add__relationship'])) {
   $relationship = seo($_POST["relationship"]);

 
   if(empty($relationship)) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
      exit;
   }
   $addRel = $dbh->prepare("INSERT INTO relationship (name) VALUES (?)");
   $addRel->execute([$relationship]);
   if($addRel->rowCount()>0) {
      header('Location: ' . $_SERVER['HTTP_REFERER']);
   }
}




if(isset($_GET['relpros'])) {
   if($_GET["relpros"] == "delete") {
      $id = seo($_GET["id"]);
      $deleteFetch = $dbh->prepare("DELETE FROM relationship WHERE id = ?");
      $deleteFetch->execute([$id]); 
      if($deleteFetch->rowCount()>0) {
         header('Location: ' . $_SERVER['HTTP_REFERER']);
         exit;
      } 
   }
}