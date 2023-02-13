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
         $s = "WHERE name LIKE '%$q%'";
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
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM categories $s");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($pagenumber*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
   $getCats = $dbh->prepare("SELECT * FROM categories $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
   $getCats->execute();
   $cats = $getCats->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="langs__content">
   <div class="mt-4 ms-4 author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="kateqoriya adını daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchGenre" class="btn btn-dark">axtar</button>
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
                              <th scope="col">Kateqoriya</th>
                              <th scope="col">Rel</th>
                              <th scope="col">Məlumat dili</th>
                              <th scope="col">İdarə</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($cats as $cat) {
                              $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
                              $getLang->execute([$cat["lang_id"]]);
                              $lang = $getLang->fetch(PDO::FETCH_ASSOC);
                              $getRel = $dbh->prepare("SELECT * FROM relationship WHERE id = ?");
                              $getRel->execute([$cat["rel_id"]]);
                              $rel = $getRel->fetch(PDO::FETCH_ASSOC);
                              ?>
                              <tr>
                                 <th scope="row"><?php echo $cat["id"]?></th>
                                 <td><?php echo $cat["name"]?></td>
                                 <td><?php echo $rel["name"]?></td>
                                 <td><?php echo $lang["name"]?></td>
                                 <td><a onclick="return confirm('Kateqoriyanı silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?catpros=delete&id=<?php echo $cat["id"]?>" class=""><i class="fa fa-window-close"></i></a></td>
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
                     <form method="POST" action="./server/process.php">
                     <select name="lang__id" class="mb-3 form-select" aria-label="Default select example">
                        <option value="">məlumatın dili</option>
                        <?php
                           foreach($langs as $lang) {?>
                           <option value="<?php echo $lang["id"]?>"><?php echo $lang["name"]?></option>
                        <?php
                        }
                        ?>
                     </select>
                     <select name="rel__id" class="mb-3 form-select" aria-label="Default select example">
                        <option value="">Rel</option>
                        <?php
                           foreach($rels as $rel) {?>
                           <option  value="<?php echo $rel["id"]?>"><?php echo $rel["name"]?></option>
                        <?php
                        }
                        ?>
                     </select>
                        <div class="mb-3"> 
                           <input type="text" name="cat_name" class="form-control" id="exampleInputEmail1"
                                 aria-describedby="emailHelp" placeholder="Kateqoriya adı">
                        </div>
                        <button name="add__cat" type="submit" class="btn btn-primary">Əlavə et</button>
                     </form>
               </div>
            </div>
         </div>
   </div>
</div>