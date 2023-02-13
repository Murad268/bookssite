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
   $toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM manuals $s");
   $toplamKayitSayisiSorgusu->execute();
   $toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
   $sayfalamayBaslayacaqKayotSayisi = ($pagenumber*$sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
   $bulunanSafyaSayisi = ceil($toplamKayitSayisi/$sayfaBasinaGosterilecek);
   $getManuals = $dbh->prepare("SELECT * FROM manuals $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
   $getManuals->execute();
   $manuals = $getManuals->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="langs__content">
   <div class="mt-4 ms-4 author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="kitab adını daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchManual" class="btn btn-dark">axtar</button>
      </form>
   </div>
   <div class="container-fluid pt-4 px-4">
      <div style="font-size: 11px;" class="row g-4">
         <div class="col-sm-12 ">
            <div class="bg-secondary rounded h-100 p-4">
                  <table class="table">
                     <thead>
                        <tr>
                              <th scope="col">#</th>
                              <th scope="col">Şəkil</th>
                              <th scope="col">Ad</th>
                              <th scope="col">Ortalama bəyəni</th>
                              <th scope="col">Baxış</th>
                              <th scope="col">Satışdadı</th>
                              <th scope="col">Qiymət</th>
                              <th scope="col">Status</th>
                              <th scope="col">Dil</th>
                              <th scope="col">Müəlliflər</th>
                              <th scope="col">Sinif</th>
                              <th scope="col">İxtisas</th>
                              <th scope="col">Tip</th>
                              <th scope="col">İdarə</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           foreach($manuals as $manual) {
                              $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
                              $getLang->execute([$manual["lang_id"]]);
                              $lang = $getLang->fetch(PDO::FETCH_ASSOC);
                              $getClass = $dbh->prepare("SELECT * FROM classes WHERE id = ?");
                              $getClass->execute([$manual["class_id"]]);
                              $class = $getClass->fetch(PDO::FETCH_ASSOC);
                              $getSpec = $dbh->prepare("SELECT * FROM specialties WHERE id = ?");
                              $getSpec->execute([$manual["spec_id"]]);
                              $spec = $getSpec->fetch(PDO::FETCH_ASSOC);
                              $getType = $dbh->prepare("SELECT * FROM types WHERE id = ?");
                              $getType->execute([$manual["type_id"]]);
                              $type = $getType->fetch(PDO::FETCH_ASSOC);
                              ?>
                           <tr>
                              <td>
                                 #
                              </td>
                              <td scope="row">
                                 <img class="book__img" src="./assets/img/manuals/<?php echo $manual["src"]?>" alt="">
                              </th>   
                              <td scope="row">
                                 <?php echo $manual["name"]?>
                              </td>
                              <td scope="row">
                                 <?php 
                                    if($manual['countofb'] == 0) {
                                       echo "0";
                                    } else {
                                       echo $manual["stars"]/$un['countofb'];
                                    }
                                 ?>
                              </td>
                              <td scope="row">
                                 <?php echo $manual["views"]?>
                              </td>
                              <td scope="row">
                                 <?php if($manual["sale"]==1){?>
                                    <a onclick="return confirm('Məhsul satişdan çıxarılsın?')" class="text-success" href="./server/process.php?manualspec=remsale&id=<?php echo $manual["id"]?>" >Satışdadı</a>
                                 <?php
                                 } else {?>
                                    <a onclick="return confirm('Məhsul satişa əlavə edilsin?')" class="" href="./server/process.php?manualspec=addsale&id=<?php echo $manual["id"]?>">Satışda deyil</a>
                                 <?php
                                 }
                                 ?>
                              </td>
                              <td scope="row">
                                 <?php echo $manual["price"]?>
                              </td>
                              <td scope="row">
                                 <?php if($manual["new"]==1){?>
                                    <a onclick="return confirm('Məhsul yeni deyil?')" class="text-success" href="./server/process.php?manualspec=remnew&id=<?php echo $manual["id"]?>"  >Yenidir</a>
                                 <?php
                                 } else {?>
                                    <a onclick="return confirm('Məhsul yenidir?')" class="" href="./server/process.php?manualspec=addnew&id=<?php echo $manual["id"]?>" >Yeni deyil</a>
                                 <?php
                                 }
                                 ?>
                              </td>
                              


                              <td scope="row">
                                 <?php echo $lang["name"]?>
                              </td>
                       
                              <td scope="row">
                                 <?php echo $manual["authors"]?>
                              </td>
                              
                              <td scope="row">
                                 <?php echo $class["name"]?>
                              </td>
                              <td scope="row">
                                 <?php echo $spec["name"]?>
                              </td>
                              <td scope="row">
                                 <?php echo $type["name"]?>
                              </td>
                              <td><a onclick="return confirm('Dərsliyi silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?manualspec=delete&id=<?php echo $manual["id"] ?>" class=""><i class="fa fa-window-close"></i></a></td>
                           
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
                  <input type="text" name="name" class="mb-3 form-control" id="" placeholder="Kitabın adı">
                  <select name="rel__id" class="mb-3 form-select" aria-label="Default select example">
                        <option value="">Rel</option>
                        <?php
                           foreach($rels as $rel) {?>
                           <option <?php echo $rel["name"] == "manual"?  "selected":"disabled" ?> value="<?php echo $rel["id"]?>"><?php echo $rel["name"]?></option>
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
                  <select name="class__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">sinif</option>
                     <?php
                        foreach($classes as $class) {?>
                        <option value="<?php echo $class["id"]?>"><?php echo $class["name"]?></option>
                     <?php
                     }
                     ?>
                  </select>
                  <select name="spec__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">İxtisası</option>
                     <?php
                        foreach ($specialities as $speciality) { ?>
                           <option value="<?php echo $speciality["id"] ?>"><?php echo $speciality["name"] ?></option>
                        <?php
                        }
                     ?>
                  </select>
                  <select name="type__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Tipi</option>
                     <?php
                        foreach ($types as $type) { ?>
                           <option value="<?php echo $type["id"] ?>"><?php echo $type["name"] ?></option>
                        <?php
                        }
                     ?>
                  </select>
                  <input placeholder="müəlliflər" style="background: transparent" type="text" class="mb-3 form-control" name="authors" id="book_src">
                  
                  <select name="sale" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitab satışdadı</option>
                     <option value="1">hə</option>
                     <option value="2">yox</option>
                  </select>
                  <input type="text" class="mb-3 form-control" id="" name="price" placeholder="Qiyməti">
                  <select name="new" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitab yeni yazılıb</option>
                     <option value="1">hə</option>
                     <option value="2">yox</option>
                  </select>
                  <button name="add__manual" type="submit" class="btn btn-primary">Əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>