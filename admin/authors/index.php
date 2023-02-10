<?php
   if(isset($_REQUEST["pagenumber"])) {
      $pagenumber = $_REQUEST["pagenumber"];
   } else {
      $pagenumber = 1;
   }

   if(isset($_REQUEST["page"])) {
      $page = $_REQUEST["page"];
      if(isset($_REQUEST["search"])) {
         
         $q = $_REQUEST["search"];
         $s = "WHERE author_name LIKE '%$q%'";
         $sayfalamaKosulu = "&page=$page&search=$q";
      } else {
         $sayfalamaKosulu = "&page=$page";
         $s = "";
      }
   } else {
      $sayfalamaKosulu = "";
   }


   $sayfalamaIcinButonSayisi = 2;
   $sayfaBasinaGosterilecek = 5;
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM authors $s");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($pagenumber*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);

  $fetchAuthors = $dbh->prepare("SELECT * FROM authors $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
  $fetchAuthors->execute();
  $authors = $fetchAuthors->fetchAll(PDO::FETCH_ASSOC);

?>
<section class="author__content">
   <div class="author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="müəllif adını daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchAuthor" class="btn btn-dark">axtar</button>
      </form>
   </div>
   <?php
      if(count($authors)<1) {?>
         <div class="alert alert-secondary" role="alert">
            hələ ki, heç bir müəllif əlavə edilməyib
         </div>
      <?php
      }
      foreach($authors as $author) {?>
         <div class="author">
            <div class="author__controlls">
               <div class="author__edit">
                  <a><i class="bi bi-pencil"></i></a>
               </div>
               <div class="author__delete">
               <a onclick="return confirm('müəllifi silmək istədiyinizdən əminsiniz?')" href="./server/process.php?author_process=delete&id=<?php echo $author['id']?>"><i class="fa fa-window-close" aria-hidden="true"></i></a>
               </div>
            </div>
            <input type="hidden" class="author__id" value="<?php echo $author["id"]?>">
            <div class="author__name"><?php echo $author["author_name"]?></div>
            <div class="author__desc"><?php echo $author["author_desc"] ?> </div>
         </div>
      <?php
      }
   ?>

   <nav aria-label="Page navigation example">
      <?php
            if($bulunanSafyaSayisi>1) {?>
               <div class="paginationWrapper">
                  <nav aria-label="Page navigation example ">
                     <ul class="pagination">
                     <li class="page-item"><a class="page-link" href="?pagenumber=1<? echo $sayfalamaKosulu?>">&laquo;</a></li>
                     <?php
                        for($i = $pagenumber-$sayfalamaIcinButonSayisi; $i <= $pagenumber+$sayfalamaIcinButonSayisi; $i++) {
                           if(($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                              $curr = $i;
                           if($pagenumber == $i) {
                              echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: black; color: white\" class=\"page-link\">$curr</div></li>";
                           } else {
                              echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?pagenumber=$curr$sayfalamaKosulu\">$curr</a></li>";
                           }
                        }
                     }
                     ?>
                        <li class="page-item"><a class="page-link"  href="?pagenumber=<?=$bulunanSafyaSayisi.$sayfalamaKosulu?>">&raquo;</a></li>
                     </ul>
                  </nav>
               </div>
            <?php
            }
         ?>
   </nav>
   <div class="add__author">
      <form method="post" action="./server/process.php">
         <input name="author_name" type="text" class="form-control" placeholder="Müəllifin adı">
         <textarea name="author_desc" name="" class="form-control" placeholder="müəllif haqqında"></textarea>
         <button name="add_author" class="btn btn-dark">müəllifi əlavə et</button>
      </form>
   </div>
   <div class="changeAuthor">
      <div class="changeAuthor__box">
          <form method="post" action="./server/process.php">
            <input type="text" name="author_name" placeholder="müəllifin adını dəyiş" class="form-control at-name">
            <textarea name="author_desc" placeholder="müəllif haqqında məlumatı dəyiş" class="form-control"></textarea>
            <input class="at-id" type="hidden" name="id">
            <button type="submit" name="changeAuthor" class="btn btn-dark">Dəyiş</button>
          </form>
      </div>
   </div>
</section>  