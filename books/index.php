<section class="books__content">
   <?php
   $page = $_GET["page"];
   $cat = $_GET["category"];

   if(isset($_REQUEST["pagenumber"])) {
      $pagenumber = $_REQUEST["pagenumber"];
   } else {
      $pagenumber = 1;
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
         $sayfalamaKosulu = "&page=".$page."&category=$cat";
         if(isset($_GET["search"])) {
            $s = $_GET["search"];
            $l = $_GET["lang_id"];
            $g = $_GET["genre_id"];
            $sayfalamaKosulu .= "&search=$s&genre_id=$g&lang_id=$l";
         }
         if(!empty($_GET["search"])) {
            $q = $_GET["search"];
            $s = "AND book_name LIKE '%$q%'";
         } else {
            $s = "";
         }
         if(!empty($_GET["lang_id"])) {
            $id = $_GET["lang_id"];
            $l = "AND  lang_id = $id";
         } else {
            $l= "";
         }
         if(!empty($_GET["genre_id"])) {
            $id = $_GET["genre__id"];
            $g = "AND  genre__id = $id";
         } else {
            $g = "";
         }
      
      
         
      
      
         $sayfalamaIcinButonSayisi = 2;
         $sayfaBasinaGosterilecek = 1;
         $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ?  $s $l $g");
         $toplamKayitSayisiSorgusu->execute([$category["id"]]);
         $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
         $sayfalamayBaslayacaqKayotSayisi = ($pagenumber*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
         $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
          
         $getBooks = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ?  $s $l $g LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
         $getBooks->execute([$category["id"]]);
         $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);
      ?>
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
         <div class="interesting__wrapper__filter">
            <form action="./server/process.php" method="post" >
               <input type="text" name="search" placeholder="kitabın adını daxil edin">
               <input value="<?php echo $page?>" type="hidden" name="page">
               <input value="<?php echo $cat?>" type="hidden" name="cat">
               <select name="lang_id" id="">
                  <option value="">Dil</option>
                  <?php
                     foreach($langs as $lang) {?>
                        <option value="<?php echo $lang["id"]?>"><?php echo $lang["name"]?></option>
                     <?php
                     }
                  ?>
               </select>
               <select name="genre_id" id="">
                  <option value="">Janr</option>
                  <?php
                     foreach($categories as $category) {?>
                        <option value="<?php echo $category["id"]?>"><?php echo $category["name"]?></option>
                     <?php
                     }
                  ?>
               </select>
               <button type="submit" name="searchInBooks" class="btn btn-success">axtar</button>
               <a href="" class="btn btn-primary">Populyarlığa görə sırala</a>
               <a href="" class="btn btn-success">Bəyəniyə görə sırala</a>
               <a href="" class="btn btn-danger">Satışdadı</a>
               <a href="" class="btn btn-dark">Uzudan bahaya</a>
               <a href="" class="btn btn-warning">Bahadan ucuza</a>
               <a href="" class="btn btn-primary">Yeni kitablar</a>
            </form>  

         </div>
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
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 2) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 3) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 4) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                  
                           </div>
                           `;
                  } elseif ($star <= 5) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  }
               }
            ?>
               <a class="interesting__book">
                  <div class="interesting__book__img">
                     <img src="admin/assets/img/books/<?php echo $book["src"] ?>" alt="" />
                  </div>
                  <?php
                  echo $star;
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
               if($bulunanSafyaSayisi>1) {?>
                  <div class="paginationWrapper">
                     <nav aria-label="Page navigation example ">
                        <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="<? echo "?".$sayfalamaKosulu.'&pagenumber=1'?>">&laquo;</a></li>
                        <?php
                           for($i = $pagenumber-$sayfalamaIcinButonSayisi; $i <= $pagenumber+$sayfalamaIcinButonSayisi; $i++) {
                              if(($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                                 $curr = $i;
                              if($pagenumber == $i) {
                                 echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: black; color: white\" class=\"page-link\">$curr</div></li>";
                              } else {
                                 echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?$sayfalamaKosulu&pagenumber=$curr\">$curr</a></li>";
                              }
                           }
                        }
                        ?>
                           <li class="page-item"><a class="page-link"  href="<?="?".$sayfalamaKosulu."&"."pagenumber=".$bulunanSafyaSayisi?>">&raquo;</a></li>
                        </ul>
                     </nav>
                  </div>
               <?php
               }
            ?>
      </nav>

      <?php
      } elseif ($_GET["category"] == "university") { ?>
         <div class="books__content__wrapper">
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
               $star;
               $text;

               if ($book["countofb"] == 0) {
                  $star = "<div class='no-star'>Hələ ki, heç bir istifadəçi bu kitaba qiymət verməyib</div>";
                  $text = $star;
               } else {
                  $star = $book["stars"] / $book["countofb"];
                  if ($star <= 1) {
                     $text = `
                                 <div class="interesting__book__raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                 </div>
                                 `;
                  } elseif ($star <= 2) {
                     $text = `
                                 <div class="interesting__book__raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                 </div>
                                 `;
                  } elseif ($star <= 3) {
                     $text = `
                                 <div class="interesting__book__raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                 </div>
                                 `;
                  } elseif ($star <= 4) {
                     $text = `
                                 <div class="interesting__book__raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                        
                                 </div>
                                 `;
                  } elseif ($star <= 5) {
                     $text = `
                                 <div class="interesting__book__raiting">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                 </div>
                                 `;
                  }
               }
               echo $text;
            ?>
               <div class="manual">
                  <a href=""><?php echo $book["name"] ?></a> -
                  <span>(<?php echo $type["name"] ?>)</span> -
                  <span><?php echo $specialty["name"] ?></span> -
                  <span><?php echo $book["price"] < 2 ? 'pulsuz' : $book["price"] ?></span> -
                  <span><?php echo $lang["name"] ?></span> dilində -
                  <?php
                  echo $text;
                  ?>
               </div>
            <?php
            }
            ?>
         </div>

      <?php
      } elseif ($_GET["category"] == "manuals") { ?>
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
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 2) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 3) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  } elseif ($star <= 4) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                  
                           </div>
                           `;
                  } elseif ($star <= 5) {
                     $text = `
                           <div class="interesting__book__raiting">
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                              <i class="fa fa-star" aria-hidden="true"></i>
                           </div>
                           `;
                  }
               }
            ?>
               <a class="interesting__book">
                  <div class="interesting__book__img">
                     <img src="admin/assets/img/manuals/<?php echo $book["src"] ?>" alt="" />
                  </div>
                  <?php
                  echo $star;
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