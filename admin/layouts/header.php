<?php
   session_start();
   include '../server/connect.php';
   include './server/parameters.php';
   if (!isset($_SESSION["admin"])) {
      header("Location: ./login");
   }

   $getLangs = $dbh->prepare("SELECT * FROM language");
   $getLangs->execute();
   $langs = $getLangs->fetchAll(PDO::FETCH_ASSOC);

   $geAuthors = $dbh->prepare("SELECT * FROM authors");
   $geAuthors->execute();
   $authors = $geAuthors->fetchAll(PDO::FETCH_ASSOC);

   $geSpec = $dbh->prepare("SELECT * FROM specialties");
   $geSpec->execute();
   $specialities = $geSpec->fetchAll(PDO::FETCH_ASSOC);

   $geTypes = $dbh->prepare("SELECT * FROM types");
   $geTypes->execute();
   $types = $geTypes->fetchAll(PDO::FETCH_ASSOC);

   $getClasses = $dbh->prepare("SELECT * FROM classes");
   $getClasses->execute();
   $classes = $getClasses->fetchAll(PDO::FETCH_ASSOC);

   $getCategories = $dbh->prepare("SELECT * FROM categories");
   $getCategories->execute();
   $categories = $getCategories->fetchAll(PDO::FETCH_ASSOC);

   $getGenres = $dbh->prepare("SELECT * FROM books");
   $getGenres->execute();
   $genres = $getGenres->fetchAll(PDO::FETCH_ASSOC);

   $getSubjects = $dbh->prepare("SELECT * FROM subjects");
   $getSubjects->execute();
   $subjects = $getSubjects->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <title>DarkPan - Bootstrap 5 Admin Template</title>
   <meta content="width=device-width, initial-scale=1.0" name="viewport">
   <meta content="" name="keywords">
   <meta content="" name="description">

   <!-- Favicon -->
   <link href="img/favicon.ico" rel="icon">

   <!-- Google Web Fonts -->
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

   <!-- Icon Font Stylesheet -->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

   <!-- Libraries Stylesheet -->
   <link href="./assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
   <link href="./assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

   <!-- Customized Bootstrap Stylesheet -->
   <link href="./assets/css/bootstrap.min.css" rel="stylesheet">

   <!-- Template Stylesheet -->
   <link href="./assets/css/style.css" rel="stylesheet">
</head>

<body>
   <div class="container-fluid position-relative d-flex p-0">
 
      <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
         <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
         </div>
      </div>




   <?php
      include "./layouts/sidebar.php";
   ?>
    


