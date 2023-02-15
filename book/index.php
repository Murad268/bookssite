<?php
   include './server/functions.php';
   if(isset($_GET["book_id"])) {
      $id = seo( $_GET["book_id"]);
      $getBook = $dbh->prepare("SELECT * FROM books WHERE id = ?");
      $getBook->execute([$id]);
      $book = $getBook->fetch(PDO::FETCH_ASSOC);

      $getAuthor = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
      $getAuthor->execute([$book["author_id"]]);
      $author = $getAuthor->fetch(PDO::FETCH_ASSOC);
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
            <img src="assets/images/image (3).png" alt="" />
            <a href="" download class="book__download"> kitabı yüklə </a>
            <div class="book__top__add__star">
               <div class="rating-box">
                  <div class="stars">
                     <i class="fa-solid fa-star"></i>
                     <i class="fa-solid fa-star"></i>
                     <i class="fa-solid fa-star"></i>
                     <i class="fa-solid fa-star"></i>
                     <i class="fa-solid fa-star"></i>
                  </div>
               </div>
               <a href="" class="btn btn-dark raiting-send">
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
               <div class="book__comment">
                  <div class="book__comment__wrapper">
                     <div class="book__comment__author">Murad Agamedov</div>
                     <div class="book__comment__date">2 dekabr 2022</div>
                  </div>
                  <div class="book__comment__comment">
                     Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                     Vitae saepe necessitatibus nulla incidunt reiciendis, illo
                     iure hic voluptates minima quaerat.
                  </div>
               </div>
               <div class="book__comment">
                  <div class="book__comment__wrapper">
                     <div class="book__comment__author">Murad Agamedov</div>
                     <div class="book__comment__date">2 dekabr 2022</div>
                  </div>
                  <div class="book__comment__comment">
                     Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                     Vitae saepe necessitatibus nulla incidunt reiciendis, illo
                     iure hic voluptates minima quaerat.
                  </div>
               </div>
            </div>
            <div class="book__comment__add">
               <form class="" action="">
                  <textarea placeholder="kitab haqqında nə düşünürsüz?" class="form-control" name="" id=""></textarea>
                  <button>şərh əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>