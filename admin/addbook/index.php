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
         $s = "WHERE book_name LIKE '%$q%'";
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
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM books $s");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($pagenumber*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
   $getBooks = $dbh->prepare("SELECT * FROM books $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
   $getBooks->execute();
   $books = $getBooks->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="langs__content">
   <div class="mt-4 ms-4 author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="kitab adını daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchBook" class="btn btn-dark">axtar</button>
      </form>
   </div>
   <div class="container-fluid pt-4 px-4">
      <div class="row g-4">
         <div class="col-sm-12 ">
            <div class="bg-secondary rounded h-100 p-4">
                  <table class="table">
                     <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Şəkil</th>
                              <th scope="col">Ad</th>
                              <th scope="col">Müəllif</th>
                              <th scope="col">Qiymət</th>
                              <th scope="col">Bəyəni</th>
                              <th scope="col">Baxış</th>
                              <th scope="col">Satışdadı</th>
                              <th scope="col">Dil</th>
                              <th scope="col">Status</th>
                              <th scope="col">İdarə</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($books as $book) {
                              $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
                              $getLang->execute([$book["lang_id"]]);
                              $lang = $getLang->fetch(PDO::FETCH_ASSOC);
                              $getAuthor = $dbh->prepare("SELECT * FROM authors WHERE id = ?");
                              $getAuthor->execute([$book["author_id"]]);
                              $author = $getAuthor->fetch(PDO::FETCH_ASSOC);
                              ?>
                           <tr>
                              <td>
                                 #
                              </td>
                              <td scope="row">
                                 <img class="book__img" src="./assets/img/books/<?php echo $book["src"]?>" alt="">
                              </th>   
                              <td scope="row">
                                 <?php echo $book["book_name"]?>
                              </td>
                              <td scope="row">
                                 <?php echo $author["author_name"]?>
                              </td>
                              <td scope="row">
                                 <?php echo $book["price"]?>
                              </td>
                              <td scope="row">
                                 <?php 
                                    if($book['countofb'] == 0) {
                                       echo "0";
                                    } else {
                                       echo $book["stars"]/$book['countofb'];
                                    }
                                 ?>
                              </td>
                              <td scope="row">
                                 <?php echo $book["views"]?>
                              </td>
                              <td scope="row">
                                 <?php if($book["sale"]==1){?>
                                    <a onclick="return confirm('Məhsul satişdan çıxarılsın?')" class="text-success" href="./server/process.php?bookproc=remsale&id=<?php echo $book["id"]?>" >Satışdadı</a>
                                 <?php
                                 } else {?>
                                    <a onclick="return confirm('Məhsul satişa əlavə edilsin?')" class="" href="./server/process.php?bookproc=addsale&id=<?php echo $book["id"]?>">Satışda deyil</a>
                                 <?php
                                 }
                                 ?>
                              </td>
                              <td scope="row">
                                 <?php echo $lang["name"]?>
                              </td>
                              <td scope="row">
                                 <?php if($book["new"]==1){?>
                                    <a onclick="return confirm('Məhsul yeni deyil?')" class="text-success" href="./server/process.php?bookproc=remnew&id=<?php echo $book["id"]?>"  >Yenidir</a>
                                 <?php
                                 } else {?>
                                    <a onclick="return confirm('Məhsul yenidir?')" class="" href="./server/process.php?bookproc=addnew&id=<?php echo $book["id"]?>" >Yeni deyil</a>
                                 <?php
                                 }
                                 ?>
                              </td>
                         
                              <td><a onclick="return confirm('Dili silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?bookproc=delete&id=<?php echo $book["id"] ?>" class=""><i class="fa fa-window-close"></i></a></td>
                           
                           </tr>
                           <?php
                           }
                        ?>
                     </tbody>
                  </table>
            </div>
         </div>
      </div>
      <nav style="margin: 20px auto; width: max-content" aria-label="Page navigation example">
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
</div>


<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div style="margin: 20px auto" class="col-xl-6">
         <div class="bg-secondary rounded h-100 p-4">
               
               <form enctype="multipart/form-data" method="POST" action="./server/process.php">
                  <label for="book_src" class="form-label">Məhsul şəkli</label>
                  <input style="background: transparent" type="file" class="mb-3 form-control" name="book_src" id="book_src">
                  <label for="book_pdf" class="form-label">Məhsul elektron</label>
                  <input style="background: transparent" type="file" class="mb-3 form-control" name="book_pdf" id="book_pdf">
                  <input type="text" name="book_name" class="mb-3 form-control" id="" placeholder="Kitabın adı">
                  <select name="rel__id" class="mb-3 form-select" aria-label="Default select example">
                        <option value="">Rel</option>
                        <?php
                           foreach($rels as $rel) {?>
                           <option <?php echo $rel["name"] == "genres"?  "selected":"disabled" ?> value="<?php echo $rel["id"]?>"><?php echo $rel["name"]?></option>
                        <?php
                        }
                        ?>
                  </select>
                  <select name="lang__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">məlumatın dili</option>
                     <?php
                        foreach($langs as $lang) {?>
                        <option value="<?php echo $lang["id"]?>"><?php echo $lang["name"]?></option>
                     <?php
                     }
                     ?>
                  </select>
                  <select name="author__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitabın müəllifi</option>
                     <?php
                        foreach($authors as $author) {?>
                        <option value="<?php echo $author["id"]?>"><?php echo $author["author_name"]?></option>
                     <?php
                     }
                     ?>
                  </select>          
                  <select name="sale" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitab satışdadı</option>
                     <option value="1">hə</option>
                     <option value="2">yox</option>
                  </select>
                  <input type="text" class="mb-3 form-control" id="" name="book_price" placeholder="Qiyməti">
                  <select name="new" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitab yeni yazılıb</option>
                     <option value="1">hə</option>
                     <option value="2">yox</option>
                  </select>
                  <button name="add__book" type="submit" class="btn btn-primary">Əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>