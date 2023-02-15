<?php
   include './server/functions.php';
   include './server/parameters.php';
   if(isset($_GET["book_id"])) {
      $id = seo( $_GET["book_id"]);
      $getBook = $dbh->prepare("SELECT * FROM books WHERE id = ?");
      $getBook->execute([$id]);
      $book = $getBook->fetch(PDO::FETCH_ASSOC);

      $getAuthor = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
      $getAuthor->execute([$book["author_id"]]);
      $author = $getAuthor->fetch(PDO::FETCH_ASSOC);

      $getComments = $dbh->prepare("SELECT * FROM comments");
      $getComments->execute();
      $comments = $getComments->fetchAll(PDO::FETCH_ASSOC);
   } else {?>
      <div style="margin-left: 130px; font-size: 40px">
         error
      </div>
   <?php
      
      exit;
   }

?>
<section class="book">
   <div class="container">
      <div class="book__top">
         <div class="book__top__img">
            <img src="./admin/assets/img/books/<?php echo $book["src"]?>" alt="" />
            <a href="" download class="book__download"> kitabı yüklə </a>
            <div class="book__top__add__star">
               <div class="rating-box">
                  <div class="stars">
                     <i data-val="1" class="fa-solid fa-star"></i>
                     <i data-val="2" class="fa-solid fa-star"></i>
                     <i data-val="3" class="fa-solid fa-star"></i>
                     <i data-val="4" class="fa-solid fa-star"></i>
                     <i data-val="5" class="fa-solid fa-star"></i>
                  </div>
               </div>
               <a href="" class="get_url btn btn-dark raiting-send">
                  <i class="fa fa-paper-plane" aria-hidden="true"></i>
               </a>
            </div>
         </div>
         <div class="book__top__right">
            <div class="book__top__author"><?php echo $author["author_name"]?></div>
            <div class="book__top__name"><?php echo $book["book_name"]?></div>
            <div class="book__top__raiting">
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
               <i class="fa fa-star" aria-hidden="true"></i>
            </div>
            <div class="book__top__about__author">
               <div class="book__top__about__author__top">müəllif haqqında:</div>
               <div class="book__top__about__author__body">
                  <?php echo $author["author_desc"]?>
               </div>
            </div>
            <div class="book__top__about__book">
               <div class="book__top__about__book__top">kitab haqqında:</div>
               <div class="book__top__about__book__body">
                  Lorem ipsum dolor, sit amet consectetur adipisicing elit.
                  Corrupti, eius. Quos exercitationem voluptas vel corporis fugit
                  non nulla necessitatibus facilis pariatur earum! Non, nam labore
                  dicta eum odio architecto numquam expedita distinctio quis, eius
                  debitis. At amet eligendi vero corporis ullam natus autem
                  perferendis ea quasi, iusto nihil harum. Ad exercitationem nemo
                  velit ratione maiores tempore tempora in itaque impedit quisquam
                  dolorem nihil ex ducimus iure quaerat reiciendis repudiandae,
                  natus quam odit dolores aliquam! Corporis alias ex incidunt nisi
                  rem, repellendus culpa, distinctio in veritatis quis dolore
                  debitis, odit dicta ab! Culpa delectus, dolorum hic aliquam ab
                  at excepturi facere fugit autem pariatur porro rerum repudiandae
                  adipisci, unde harum quas quis quod eveniet amet? Cupiditate
                  nulla aperiam necessitatibus sint est?
               </div>
            </div>
            <div class="book__comments">
               <?php
                  if(count($comments) <= 0) {?>
                     <div class="no-comment">
                        Kitaba heç bir şərh verilməyib
                     </div>
                  <?php
                  }
                  foreach($comments as $comment) {
                     $getUser = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                     $getUser->execute([$comment["user_id"]]);
                     $user = $getUser->fetch(PDO::FETCH_ASSOC)?>
                      <div class="book__comment">
                        <div class="book__comment__wrapper">
                           <div class="book__comment__author"><?php echo $user["name"].' '.$user['surname']?> <?php
                              if($comment["user_id"]==$user_id) {?>
                                 <a onclick="return confrim('Şərhinizi silmək istədiyinizdən əminsinizmi?')" class="text-danger" href="./server/process.php?compross=delete&id=<?php echo $comment["id"]?>">sil</a>
                              <?php
                              }
                           ?></div>
                           <div class="book__comment__date"><?php echo dateR($comment["date"])?></div>
                        </div>
                        <div class="book__comment__comment">
                          <?php
                           echo $comment["comment"]
                          ?>
                        </div>
                     </div>
                  <?php
                  }
               ?>
           
            </div>
            <div class="book__comment__add">
               <form method="post" action="./server/process.php">
                  <textarea placeholder="kitab haqqında nə düşünürsüz?" class="form-control" name="comment" id=""></textarea>
                  <button name="add_comment">şərh əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>