<?php
include './server/functions.php';
include './server/parameters.php';
if (isset($_GET["manual_id"])) {
   $id = seo($_GET["manual_id"]);
   $getBook = $dbh->prepare("SELECT * FROM manuals WHERE id = ?");
   $getBook->execute([$id]);
   $book = $getBook->fetch(PDO::FETCH_ASSOC);
   $getComments = $dbh->prepare("SELECT * FROM manual_comment");
   $getComments->execute();
   $comments = $getComments->fetchAll(PDO::FETCH_ASSOC);
} else { ?>
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
            <img src="./admin/assets/img/manuals/<?php echo $book["src"] ?>" alt="" />
            <a href="./admin/assets/pdfs/manuals/<?php echo $book['book_pdf']?>" <?php echo $book['sale']==1? "onclick='return confirm(\"Kitabı almaq üçün lazım olan əlaqə vasitələrini yükləmək istəyirsiniz?\")'":""?> download class="book__download"> kitabı yüklə </a>
            <?php
            $getStar = $dbh->prepare("SELECT * FROM manual_stars WHERE user_id = ? AND goods_id = ?");
            $getStar->execute([$user_id, $_GET["manual_id"]]);
            $star = $getStar->fetch(PDO::FETCH_ASSOC);
            if (!$getStar->rowCount() > 0) { ?>
               <div class="book__top__add__star">
                  <div class="rating-box">
                     <div class="stars manstars">
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
            <?php
            } else {
               if ($star["star_count"] <= 1) {
                  $text = '
                              <div class="interesting__book__raiting">
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                              </div>
                              ';
               } elseif ($star["star_count"] <= 2) {
                  $text = '
                              <div class="interesting__book__raiting">
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                              </div>
                              ';
               } elseif ($star["star_count"] <= 3) {
                  $text = '
                              <div class="interesting__book__raiting">
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                              </div>
                              ';
               } elseif ($star["star_count"] <= 4) {
                  $text = '
                              <div class="interesting__book__raiting">
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                     
                              </div>
                              ';
               } elseif ($star["star_count"] <= 5) {
                  $text = '
                              <div class="interesting__book__raiting">
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                                 <i class="fa fa-star active" aria-hidden="true"></i>
                              </div>
                              ';
               }


            ?>
               <div class="book__top__add__star reaiting-have">
                  <div class="rating-box">
                     <div class="all_stars">
                        <?php
                           echo $text;
                        ?>
                     </div>
                  </div>
                  <a class="change_raiting btn btn-dark raiting-send">
                     <i class="fa fa-pencil" aria-hidden="true"></i>
                  </a>
               </div>
               <div class="book__top__add__star raiting-not">
                  <div class="rating-box">
                     <div class="stars manstars">
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
            <?php
            }
            ?>
         </div>
         <div class="book__top__right">
            <div class="book__top__author"><?php echo $book["authors"] ?></div>
            <div class="book__top__name"><?php echo $book["name"] ?></div>
            <?php
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
            <div class="book__top__raiting">
               <?php
                  echo $text;
               ?>
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
               if (count($comments) <= 0) { ?>
                  <div class="no-comment">
                     Kitaba heç bir şərh verilməyib
                  </div>
               <?php
               }
               foreach ($comments as $comment) {
                  $getUser = $dbh->prepare("SELECT * FROM users WHERE id = ?");
                  $getUser->execute([$comment["user_id"]]);
                  $user = $getUser->fetch(PDO::FETCH_ASSOC) ?>
                  <div class="book__comment">
                     <div class="book__comment__wrapper">
                        <div class="book__comment__author"><?php echo $user["name"] . ' ' . $user['surname'] ?> <?php
                                                                                                                  if ($comment["user_id"] == $user_id) { ?>
                              <a onclick="return confirm('Şərhinizi silmək istədiyinizdən əminsinizmi?')" class="text-danger" href="./server/process.php?compross=delete&id=<?php echo $comment["id"] ?>">sil</a>
                           <?php
                                                                                                                  }
                           ?>
                        </div>
                        <div class="book__comment__date"><?php echo dateR($comment["date"]) ?></div>
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
                  <button name="manual_comment">şərh əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>