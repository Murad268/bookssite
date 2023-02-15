<section class="books__content">
   <?php



   $getCategory = $dbh->prepare("SELECT * FROM categories WHERE slug = ?");
   $getCategory->execute([$_GET["category"]]);
   $category = $getCategory->fetch(PDO::FETCH_ASSOC);
   $cat = $_GET["category"];
   $getBooks = $dbh->prepare("SELECT * FROM $cat WHERE cat__id = ?");
   $getBooks->execute([$category["id"]]);
   $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);
   ?>
   <h3 class="books__content__title">
      <?php
      echo $category["name"];
      ?>
   </h3>

   <?php
   if ($_GET["category"] == "books") { ?>
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
   } elseif($_GET["category"] == "manuals") {?>
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