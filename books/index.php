<section class="books__content">
   <?php
   $page = $_GET["page"];
   $cat = $_GET["category"];

   if (isset($_REQUEST["pagenumber"])) {
      $pagenumber = $_REQUEST["pagenumber"];
   } else {
      $pagenumber = 1;
   }



   $current_url = 'http';
   if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $current_url .= "s";
   }
   $current_url .= "://";
   if ($_SERVER['SERVER_PORT'] != '80') {
      $current_url .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
   } else {
      $current_url .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
   }





   $getLangs = $dbh->prepare("SELECT * FROM language");
   $getLangs->execute();
   $langs = $getLangs->fetchAll(PDO::FETCH_ASSOC);
   $getCategories = $dbh->prepare("SELECT * FROM categories");
   $getCategories->execute();
   $categories = $getCategories->fetchAll(PDO::FETCH_ASSOC);
   $getCategory = $dbh->prepare("SELECT * FROM categories WHERE slug = ?");
   $getCategory->execute([$_GET["category"]]);
   $category = $getCategory->fetch(PDO::FETCH_ASSOC);







   ?>

   <h3 class="books__content__title">
      <?php
      echo $category["name"];
      ?>
   </h3>

   <?php
   if ($_GET["category"] == "books") {
      $sayfalamaKosulu = "page=" . $page . "&category=$cat";
      if (isset($_GET["search"])) {
         $s = $_GET["search"];
         $l = $_GET["lang_id"];
         $g = $_GET["genre_id"];
         $sayfalamaKosulu .= "&search=$s&genre_id=$g&lang_id=$l";
      }
      if (isset($_GET["filter"])) {
         $f = $_GET["filter"];
         $sayfalamaKosulu .= "&filter=$f";
         if ($_GET["filter"] == "popular") {
            $fq = "ORDER BY views DESC";
         } elseif ($_GET["filter"] == "likes") {
            $fq = "ORDER BY stars/countofb DESC";
         } elseif ($_GET["filter"] == "onsale") {
            $fq = "AND sale=1";
         } elseif ($_GET["filter"] == "popularinonsale") {
            $fq = "AND sale = 1 ORDER BY views DESC";
         } elseif ($_GET["filter"] == "morelikesinonsale") {
            $fq = "AND sale = 1 ORDER BY stars/countofb DESC";
            // morelikesinonsale
         } elseif ($_GET["filter"] == "fromceaptoexpensive") {
            $fq = "AND sale=1 ORDER BY price ASC";
         } elseif ($_GET["filter"] == "fromexpensivetocheap") {
            $fq = "AND sale=1 ORDER BY price DESC";
         } elseif ($_GET["filter"] == "newbooks") {
            $fq = "AND new=1 ORDER BY price DESC";
         }
      } else {
         $fq = "";
      }
      if (!empty($_GET["search"])) {
         $q = $_GET["search"];
         $s = "AND book_name LIKE '%$q%'";
      } else {
         $s = "";
      }
      if (!empty($_GET["lang_id"])) {
         $id = $_GET["lang_id"];
         $l = "AND  lang_id = $id";
      } else {
         $l = "";
      }
      if (!empty($_GET["genre_id"])) {
         $id = $_GET["genre_id"];
         $g = "AND  genre__id = $id";
      } else {
         $g = "";
      }





      $sayfalamaIcinButonSayisi = 2;
      $sayfaBasinaGosterilecek = 8;
      $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ?  $s $l $g $fq");
      $toplamKayitSayisiSorgusu->execute([$category["id"]]);
      $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
      $sayfalamayBaslayacaqKayotSayisi = ($pagenumber * $sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
      $bulunanSafyaSayisi = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecek);

      $getBooks = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ?  $s $l $g $fq LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      $getBooks->execute([$category["id"]]);
      $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);


   ?>

      <div class="interesting__wrapper__filter">
         <form action="./server/process.php" method="post">
            <input value="<?php
               echo isset($_GET["search"])?$_GET["search"]:'';
            ?>" class="form-control" type="text" name="search" placeholder="kitabın adını daxil edin">
            <input class="form-control" value="<?php echo $page ?>" type="hidden" name="page">
            <input class="form-control" value="<?php echo $cat ?>" type="hidden" name="cat">
            <select class="form-control" name="lang_id" id="">
               <option value="">Dil</option>
               <?php
               foreach ($langs as $lang) { ?>
                  <option <?php
                     if(isset($_GET["lang_id"])) {
                        echo $_GET['lang_id'] == $lang["id"]?'selected':'';
                     }
                  ?> value="<?php echo $lang["id"] ?>"><?php echo $lang["name"] ?></option>
               <?php
               }
               ?>
            </select>
            <select class="form-control" name="genre_id" id="">
               <option value="">Janr</option>
               <?php
               foreach ($genres as $genre) { ?>
                  <option <?php
                     if(isset($_GET["genre_id"])) {
                        echo $_GET["genre_id"] == $genre["id"]?'selected':'';
                     }
                  ?> value="<?php echo $genre["id"] ?>"><?php echo $genre["name"] ?></option>
               <?php
               }
               ?>
            </select>
            <?php
                  if(isset($_GET["search"])) {?>
                     <input name="searching" type="hidden" value="<?php echo $_GET["search"]?>">
                  <?php
                  }
                  if(isset($_GET["genre_id"])) {?>
                    <input name="genre" type="hidden" value="<?php echo $_GET["genre_id"]?>">
                     <?php
                  }
                  if(isset($_GET["lang_id"])) {?>
                    <input name="lang" type="hidden" value="<?php echo $_GET["lang_id"]?>">
                     <?php
                  }
                  if(isset($_GET["filter"])) {?>
                    <input name="filtering" type="hidden" value="<?php echo $_GET["filter"]?>">
                     <?php
                  }
               ?>
            <button type="submit" name="searchInBooks" class="btn btn-success">axtar</button>
         </form>

      </div>
      <div class="mt-3 interesting__wrapper__filter">
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popular" class="btn btn-primary">Populyarlığa görə sırala</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=likes" class="btn btn-success">Bəyəniyə görə sırala</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=onsale" class="btn btn-danger">Satışdadı</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popularinonsale" class="btn btn-danger">Satışda olanlar arasında ən populyarları</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=morelikesinonsale" class="btn btn-danger">Satışda olanlar arasında ən çox bəyənilənləri</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromceaptoexpensive" class="btn btn-dark">Uzudan bahaya</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromexpensivetocheap" class="btn btn-warning">Bahadan ucuza</a>
         <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=newbooks" class="btn btn-primary">Yeni kitablar</a>
      </div>
      <?php
      if (count($books) < 1) { ?>
         <div class="no__book">
            <div class="alert alert-warning" role="alert">
               Axtarılan tipdə kitab yoxdur və ya bölmə düzənlənir
            </div>
         </div>
      <?php
      }
      ?>
      <div class="interesting__wrapper container">

         <?php
         foreach ($books as $book) {
            $getAuthor = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
            $getAuthor->execute([$book["author_id"]]);
            $author = $getAuthor->fetch(PDO::FETCH_ASSOC);
            $star;
            $text;
            if ($book["countofb"] == 0) {
               $star = "<div class='no-star'>Hələ ki, heç bir istifadəçi bu kitaba qiymət verməyib</div>";
               $text = $star;
            } else {
               $star = $book["stars"] / $book["countofb"];
               if ($star <= 1) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 2) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 3) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 4) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                  
                           </div>
                           ';
               } elseif ($star <= 5) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               }
            }
         ?>
            <a href=".?page=book&book_id=<?php echo $book["id"]?>" class="interesting__book">
               <?php
                  if($book["price"]>1) {?>
                      <div class="interesting__book__types">
                        <div class="interesting__book__type">
                           <?php echo $book["price"]?>
                        </div>
                     </div>
                  <?php
                  } else {?>
                    <div class="interesting__book__types">
                        <div class="interesting__book__type">
                           pulsuz
                        </div>
                     </div>
                  <?php
                  }
               ?>
               <div class="interesting__book__img">
                  <img src="admin/assets/img/books/<?php echo $book["src"] ?>" alt="" />
               </div>
               <?php
                  echo $text;
               ?>
               <div class="interesting__book__author"><?php echo $author["author_name"] ?></div>
               <div class="interesting__book__name"><?php echo $book["book_name"] ?></div>
            </a>
         <?php
         }
         ?>

      </div>
      <nav style="margin: 20px auto; width: max-content" aria-label="Page navigation example">
         <?php
         if ($bulunanSafyaSayisi > 1) { ?>
            <div class="paginationWrapper">
               <nav aria-label="Page navigation example ">
                  <ul class="pagination">
                     <li class="page-item"><a class="page-link" href="<? echo "?" . $sayfalamaKosulu . '&pagenumber=1' ?>">&laquo;</a></li>
                     <?php
                     for ($i = $pagenumber - $sayfalamaIcinButonSayisi; $i <= $pagenumber + $sayfalamaIcinButonSayisi; $i++) {
                        if (($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                           $curr = $i;
                           if ($pagenumber == $i) {
                              echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: black; color: white\" class=\"page-link\">$curr</div></li>";
                           } else {
                              echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?$sayfalamaKosulu&pagenumber=$curr\">$curr</a></li>";
                           }
                        }
                     }
                     ?>
                     <li class="page-item"><a class="page-link" href="<?= "?" . $sayfalamaKosulu . "&" . "pagenumber=" . $bulunanSafyaSayisi ?>">&raquo;</a></li>
                  </ul>
               </nav>
            </div>
         <?php
         }
         ?>
      </nav>

   <?php
   } elseif ($_GET["category"] == "university") { 
      $sayfalamaKosulu = "page=" . $page . "&category=$cat";
      if (isset($_GET["search"])) {
         $s = $_GET["search"];
         $l = $_GET["lang_id"];
         $g = $_GET["spec_id"];
         $t = $_GET["type_id"];
         $sayfalamaKosulu .= "&search=$s&spec_id=$g&lang_id=$l&type_id=$t";
      }
      if (!empty($_GET["search"])) {
         $q = $_GET["search"];
         $s = "AND name LIKE '%$q%'";
      } else {
         $s = "";
      }
      if (!empty($_GET["lang_id"])) {
         $id = $_GET["lang_id"];
         $l = "AND  lang_id = $id";
      } else {
         $l = "";
      }
      if (!empty($_GET["type_id"])) {
         $id = $_GET["type_id"];
         $t = "AND  type_id = $id";
      } else {
         $t = "";
      }
      if (!empty($_GET["spec_id"])) {
         $id = $_GET["spec_id"];
         $sp = "AND  speciality_id = $id";
      } else {
         $sp = "";
      }
      if (isset($_GET["filter"])) {
         $fq = $_GET["filter"];
         $sayfalamaKosulu .= "&search=$s&spec_id=$sp&lang_id=$l&type_id=$t&filter=$fq";
         if ($_GET["filter"] == "popular") {
            $fq = "ORDER BY views DESC";
         } elseif ($_GET["filter"] == "likes") {
            $fq = "ORDER BY views DESC";
         } elseif ($_GET["filter"] == "onsale") {
            $fq = "AND sale=1";
         } elseif ($_GET["filter"] == "popularinonsale") {
            $fq = "AND sale = 1 ORDER BY views DESC";
         } elseif ($_GET["filter"] == "morelikesinonsale") {
            $fq = "AND sale = 1 ORDER BY views DESC";
            // morelikesinonsale
         } elseif ($_GET["filter"] == "fromceaptoexpensive") {
            $fq = "AND sale=1 ORDER BY price ASC";
         } elseif ($_GET["filter"] == "fromexpensivetocheap") {
            $fq = "AND sale=1 ORDER BY price DESC";
         }
      } else {
         $fq = "";
      }

      $sayfalamaIcinButonSayisi = 2;
      $sayfaBasinaGosterilecek = 8;
      $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ? $s $l $t $fq $sp");
      $toplamKayitSayisiSorgusu->execute([$category["id"]]);
      $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
      $sayfalamayBaslayacaqKayotSayisi = ($pagenumber * $sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
      $bulunanSafyaSayisi = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecek);

      $getBooks = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ? $s $l $t $fq $sp LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      $getBooks->execute([$category["id"]]);
      $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);



      $getTypes = $dbh->prepare("SELECT * FROM types");
      $getTypes->execute();
      $types = $getTypes->fetchAll(PDO::FETCH_ASSOC);

      $getSpec = $dbh->prepare("SELECT * FROM specialties");
      $getSpec->execute();
      $specs = $getSpec->fetchAll(PDO::FETCH_ASSOC);
      ?>
      
      <div class="books__content__wrapper">
         <div class="interesting__wrapper__filter">
            <form action="./server/process.php" method="post">
               <input class="form-control" value="<?php echo isset($_GET["search"])? $_GET["search"]:''?>" type="text" name="search" placeholder="kitabın adını daxil edin">
               <input class="form-control" value="<?php echo $page ?>" type="hidden" name="page">
               <input class="form-control" value="<?php echo $cat ?>" type="hidden" name="cat">
               <select class="form-control" name="lang_id" id="">
                  <option value="">Dil</option>
                  <?php
                  foreach ($langs as $lang) { ?>
                     <option <?php
                        if(isset($_GET["lang_id"])) {
                           echo $lang["id"]==$_GET["lang_id"]?'selected':'';
                        }
                     ?> value="<?php echo $lang["id"] ?>"><?php echo $lang["name"] ?></option>
                  <?php
                  }
                  ?>
               </select>
               <select class="form-control" name="type_id" id="">
                  <option value="">Tip</option>
                  <?php
                  foreach ($types as $type) { ?>
                     <option <?php
                        if(isset($_GET["lang_id"])) {
                           echo $type["id"]==$_GET["type_id"]?'selected':'';
                        }
                     ?> value="<?php echo $type["id"] ?>"><?php echo $type["name"] ?></option>
                  <?php
                  }
                  ?>
               </select>
               <select class="form-control" name="spec_id" id="">
                  <option value="">İxtisas</option>
                  <?php
                  foreach ($specs as $spec) { ?>
                     <option <?php
                        if(isset($_GET["spec_id"])) {
                           echo $spec["id"]==$_GET["spec_id"]?'selected':'';
                        }
                     ?> value="<?php echo $spec["id"] ?>"><?php echo $spec["name"] ?></option>
                  <?php
                  }
                  ?>
               </select>
               <?php
                  if(isset($_GET["search"])) {?>
                     <input name="searching" type="hidden" value="<?php echo $_GET["search"]?>">
                  <?php
                  }
                  if(isset($_GET["type_id"])) {?>
                    <input name="type" type="hidden" value="<?php echo $_GET["type_id"]?>">
                     <?php
                  }
                  if(isset($_GET["lang_id"])) {?>
                    <input name="lang" type="hidden" value="<?php echo $_GET["lang_id"]?>">
                     <?php
                  }
                  if(isset($_GET["spec"])) {?>
                    <input name="spec" type="hidden" value="<?php echo $_GET["spec_id"]?>">
                     <?php
                  }
                  if(isset($_GET["filter"])) {?>
                    <input name="filtering" type="hidden" value="<?php echo $_GET["filter"]?>">
                     <?php
                  }
               ?>
               <button type="submit" name="searchInUn" class="btn btn-success">axtar</button>
            </form>

         </div>
         <div class="mt-3 interesting__wrapper__filter">
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popular" class="btn btn-primary">Populyarlığa görə sırala</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=onsale" class="btn btn-danger">Satışdadı</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popularinonsale" class="btn btn-danger">Satışda olanlar arasında ən populyarları</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromceaptoexpensive" class="btn btn-dark">Uzudan bahaya</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromexpensivetocheap" class="btn btn-warning">Bahadan ucuza</a>
         </div>
         <?php
         if (count($books) < 1) { ?>
            <div class="no__book">
               <div class="alert alert-warning" role="alert">
                  Axtarılan tipdə kitab yoxdur və ya bölmə düzənlənir
               </div>
            </div>
         <?php
         }
         ?>
         <?php

    
         foreach ($books as $book) {
            $getSpec = $dbh->prepare("SELECT * FROM specialties WHERE id = ?");
            $getSpec->execute([$book["speciality_id"]]);
            $specialty = $getSpec->fetch(PDO::FETCH_ASSOC);

            $getType = $dbh->prepare("SELECT * FROM types WHERE id = ?");
            $getType->execute([$book["type_id"]]);
            $type = $getType->fetch(PDO::FETCH_ASSOC);

            $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
            $getLang->execute([$book["lang_id"]]);
            $lang = $getLang->fetch(PDO::FETCH_ASSOC);
           
        
         ?>
            <div class="manual">
               <a href=""><?php echo $book["name"] ?></a> -
               <span>(<?php echo $type["name"] ?>)</span> -
               <span><?php echo $specialty["name"] ?></span> -
               <span><?php echo $book["price"] < 2 ? 'pulsuz' : $book["price"].'AZN' ?></span> -
               <span><?php echo $lang["name"] ?></span> dilində -
            </div>
         <?php
         }
         ?>
      </div>
      <nav style="margin: 20px auto; width: max-content" aria-label="Page navigation example">
         <?php
         if ($bulunanSafyaSayisi > 1) { ?>
            <div class="paginationWrapper">
               <nav aria-label="Page navigation example ">
                  <ul class="pagination">
                     <li class="page-item"><a class="page-link" href="<? echo "?" . $sayfalamaKosulu . '&pagenumber=1' ?>">&laquo;</a></li>
                     <?php
                     for ($i = $pagenumber - $sayfalamaIcinButonSayisi; $i <= $pagenumber + $sayfalamaIcinButonSayisi; $i++) {
                        if (($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                           $curr = $i;
                           if ($pagenumber == $i) {
                              echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: black; color: white\" class=\"page-link\">$curr</div></li>";
                           } else {
                              echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?$sayfalamaKosulu&pagenumber=$curr\">$curr</a></li>";
                           }
                        }
                     }
                     ?>
                     <li class="page-item"><a class="page-link" href="<?= "?" . $sayfalamaKosulu . "&" . "pagenumber=" . $bulunanSafyaSayisi ?>">&raquo;</a></li>
                  </ul>
               </nav>
            </div>
         <?php
         }
         ?>
      </nav>

   <?php
   } elseif ($_GET["category"] == "manuals") { 
      $sayfalamaKosulu = "page=" . $page . "&category=$cat";
      if (isset($_GET["search"])) {
         $s = $_GET["search"];
         $l = $_GET["sub_id"];
         $g = $_GET["lang_id"];
         $t = $_GET["class_id"];
         $sayfalamaKosulu .= "&search=$s&sub_id=$l&lang_id=$g&class_id=$t";
      }
      if (!empty($_GET["search"])) {
         $q = $_GET["search"];
         $s = "AND name LIKE '%$q%'";
      } else {
         $s = "";
      }
      if (!empty($_GET["lang_id"])) {
         $id = $_GET["lang_id"];
         $l = "AND  lang_id = $id";
      } else {
         $l = "";
      }
      if (!empty($_GET["sub_id"])) {
         $id = $_GET["sub_id"];
         $t = "AND  sub__id = $id";
      } else {
         $t = "";
      }

      if (!empty($_GET["class_id"])) {
         $id = $_GET["class_id"];
         $c = "AND  class_id = $id";
      } else {
         $c = "";
      }
      if (isset($_GET["filter"])) {
         $fq = $_GET["filter"];
         $sayfalamaKosulu .= "&filter=$fq";
         if ($_GET["filter"] == "popular") {
            $fq = "ORDER BY views DESC";
         } elseif ($_GET["filter"] == "likes") {
            $fq = "ORDER BY views DESC";
         } elseif ($_GET["filter"] == "onsale") {
            $fq = "AND sale=1";
         } elseif ($_GET["filter"] == "popularinonsale") {
            $fq = "AND sale = 1 ORDER BY views DESC";
         } elseif ($_GET["filter"] == "morelikesinonsale") {
            $fq = "AND sale = 1 ORDER BY views DESC";
            // morelikesinonsale
         } elseif ($_GET["filter"] == "fromceaptoexpensive") {
            $fq = "AND sale=1 ORDER BY price ASC";
         } elseif ($_GET["filter"] == "fromexpensivetocheap") {
            $fq = "AND sale=1 ORDER BY price DESC";
         } elseif ($_GET["filter"] == "newbooks") {
            $fq = "AND new=1 ORDER BY price DESC";
         }
      } else {
         $fq = "";
      }

      $sayfalamaIcinButonSayisi = 2;
      $sayfaBasinaGosterilecek = 8;
      $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ? $s $l $t $c $fq");
      $toplamKayitSayisiSorgusu->execute([$category["id"]]);
      $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
      $sayfalamayBaslayacaqKayotSayisi = ($pagenumber * $sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
      $bulunanSafyaSayisi = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecek);

  

      $getSubjects = $dbh->prepare("SELECT * FROM subjects");
      $getSubjects->execute();
      $subjects = $getSubjects->fetchAll(PDO::FETCH_ASSOC);
      $getClasses = $dbh->prepare("SELECT * FROM classes");
      $getClasses->execute();
      $classes = $getClasses->fetchAll(PDO::FETCH_ASSOC);
      $getBooks = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ? $s $l $t $c $fq LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
      $getBooks->execute([$category["id"]]);
      $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);?>
         <div class="interesting__wrapper__filter">
            <form action="./server/process.php" method="post">
               <input class="form-control" value="<?php echo isset($_GET["search"])?$_GET["search"]:''?>" type="text" name="search" placeholder="kitabın adını daxil edin">
               <input class="form-control" value="<?php echo $page ?>" type="hidden" name="page">
               <input class="form-control" value="<?php echo $cat ?>" type="hidden" name="cat">
               <select class="form-control" name="lang_id" id="">
                  <option value="">Dil</option>
                  <?php
                  foreach ($langs as $lang) { ?>
                     <option <?php 
                              if(isset($_GET["lang_id"])) {
                                 echo $lang["id"] == $_GET["lang_id"]?'selected':'';
                              }
                        ?> value="<?php echo $lang["id"] ?>"><?php echo $lang["name"] ?></option>
                  <?php
                  }
                  ?>
               </select>
               <select class="form-control" name="sub_id" id="">
                  <option value="">Fənn</option>
                  <?php
                     foreach ($subjects as $subject) { ?>
                        <option <?php 
                           if(isset($_GET["sub_id"])) {
                              echo $subject["id"] == $_GET["sub_id"]?'selected':'';
                           }
                        ?> value="<?php echo $subject["id"] ?>"><?php echo $subject["name"] ?></option>
                     <?php
                     }
                  ?>
               </select>
               <select class="form-control" name="class_id" id="">
                  <option value="">Sinif</option>
                  <?php
                     foreach ($classes as $class) { ?>
                        <option <?php if(isset($_GET["class_id"])){
                           echo $class["id"] == $_GET["class_id"]?'selected':'';
                        }  
                        ?> value="<?php echo $class["id"] ?>"><?php echo $class["name"] ?></option>
                     <?php
                  }
                  ?>
               </select>
               <?php
                  if(isset($_GET["search"])) {?>
                     <input name="searching" type="hidden" value="<?php echo $_GET["search"]?>">
                  <?php
                  }
                  if(isset($_GET["sub_id"])) {?>
                    <input name="subject" type="hidden" value="<?php echo $_GET["sub_id"]?>">
                     <?php
                  }
                  if(isset($_GET["lang_id"])) {?>
                    <input name="lang" type="hidden" value="<?php echo $_GET["lang_id"]?>">
                     <?php
                  }
                  if(isset($_GET["class_id"])) {?>
                    <input name="class" type="hidden" value="<?php echo $_GET["class_id"]?>">
                     <?php
                  }
                  if(isset($_GET["filter"])) {?>
                    <input name="filtering" type="hidden" value="<?php echo $_GET["filter"]?>">
                     <?php
                  }
               ?>
               <button type="submit" name="searchInManual" class="btn btn-success">axtar</button>
            </form>

         </div>
         <div class="mt-3 interesting__wrapper__filter">
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popular" class="btn btn-primary">Populyarlığa görə sırala</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=likes" class="btn btn-success">Bəyəniyə görə sırala</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=onsale" class="btn btn-danger">Satışdadı</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=popularinonsale" class="btn btn-danger">Satışda olanlar arasında ən populyarları</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=morelikesinonsale" class="btn btn-danger">Satışda olanlar arasında ən çox bəyənilənləri</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromceaptoexpensive" class="btn btn-dark">Uzudan bahaya</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=fromexpensivetocheap" class="btn btn-warning">Bahadan ucuza</a>
            <a style="font-size: 12px" href="?<?php echo $sayfalamaKosulu ?>&filter=newbooks" class="btn btn-primary">Yeni kitablar</a>
         </div>
      <?php
      if (count($books) < 1) { ?>
         <div class="no__book">
            <div class="alert alert-warning" role="alert">
               Axtarılan tipdə kitab yoxdur və ya bölmə düzənlənir
            </div>
         </div>
      <?php
      }
      ?>
      <div class="interesting__wrapper container">

         <?php
         foreach ($books as $book) {
            $star;
            $text;
            if ($book["countofb"] == 0) {
               $star = "<div class='no-star'>Hələ ki, heç bir istifadəçi bu kitaba qiymət verməyib</div>";
               $text = $star;
            } else {
               $star = $book["stars"] / $book["countofb"];
               if ($star <= 1) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 2) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 3) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               } elseif ($star <= 4) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                  
                           </div>
                           ';
               } elseif ($star <= 5) {
                  $text = '
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           ';
               }
            }
         ?>
            <a href=".?page=manual&manual_id=<?php echo $book["id"] ?>" class="interesting__book">
               <?php
                  if($book["price"]>1) {?>
                      <div class="interesting__book__types">
                        <div class="interesting__book__type">
                           <?php echo $book["price"]?>
                        </div>
                     </div>
                  <?php
                  } else {?>
                    <div class="interesting__book__types">
                        <div class="interesting__book__type">
                           pulsuz
                        </div>
                     </div>
                  <?php
                  }
               ?>
               <div class="interesting__book__img">
                  <img src="admin/assets/img/manuals/<?php echo $book["src"] ?>" alt="" />
               </div>
               <?php
                  echo $text;
               ?>
               <div class="interesting__book__author"><?php echo $book["authors"] ?></div>
               <div class="interesting__book__name"><?php echo $book["name"] ?></div>
            </a>
         <?php
         }
         ?>

      </div>


   <?php
   }
   ?>

</section>