<?php
if (isset($_REQUEST["pagenumber"])) {
   $pagenumber = $_REQUEST["pagenumber"];
} else {
   $pagenumber = 1;
}

if (isset($_REQUEST["page"])) {
   $page = $_REQUEST["page"];
   if (isset($_REQUEST["search"])) {
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
$toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM university $s");
$toplamKayitSayisiSorgusu->execute();
$toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
$sayfalamayBaslayacaqKayotSayisi = ($pagenumber * $sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
$bulunanSafyaSayisi = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecek);
$getUnversity = $dbh->prepare("SELECT * FROM university $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
$getUnversity->execute();
$university = $getUnversity->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="langs__content">
   <div class="mt-4 ms-4 author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="Material adını daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchUn" class="btn btn-dark">axtar</button>
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
                        <th scope="col">ad</th>
                        <th scope="col">Ortalama bəyənmə qiyməti</th>
                        <th scope="col">Satışdadı</th>
                        <th scope="col">Qiymət</th>
                        <th scope="col">Dil</th>
                        <th scope="col">Tip</th>
                        <th scope="col">İxtisas</th>
                        <th scope="col">İdarə</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     foreach ($university as $un) {
                        $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
                        $getLang->execute([$un["lang_id"]]);
                        $lang = $getLang->fetch(PDO::FETCH_ASSOC); 
                        $getType = $dbh->prepare("SELECT * FROM types WHERE id = ?");
                        $getType->execute([$un["type_id"]]);
                        $type = $getType->fetch(PDO::FETCH_ASSOC);
                        $getSpec = $dbh->prepare("SELECT * FROM specialties WHERE id = ?");
                        $getSpec->execute([$un["speciality_id"]]);
                        $spec = $getSpec->fetch(PDO::FETCH_ASSOC);?>
                        <tr>
                           <th scope="row"><?php echo $un["id"] ?></th>
                           <td><?php echo $un["name"] ?></td>
                           <td scope="row">
                              <?php 
                                 if($un['countofb'] == 0) {
                                    echo "0";
                                 } else {
                                    echo $un["stars"]/$un['countofb'];
                                 }
                              ?>
                           </td>
                           <td scope="row">
                              <?php if($un["sale"]==1){?>
                                 <a onclick="return confirm('Məhsul satışdan çıxarılsın?')" class="text-success" href="./server/process.php?unpros=remsale&id=<?php echo $un["id"]?>" >Satışdadı</a>
                              <?php
                              } else {?>
                                 <a onclick="return confirm('Məhsul satışa əlavə edilsin?')" class="" href="./server/process.php?unpros=addsale&id=<?php echo $un["id"]?>">Satışda deyil</a>
                              <?php
                              }
                              ?>
                           </td>
                           <td><?php echo $un["price"] ?></td>
                           <td><?php echo $lang["name"] ?></td>
                           <td><?php echo $type["name"] ?></td>
                           <td><?php echo $spec["name"] ?></td>
                           <td><a onclick="return confirm('Materialı silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?unpros=delete&id=<?php echo $un["id"] ?>" class=""><i class="fa fa-window-close"></i></a></td>
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
         if ($bulunanSafyaSayisi > 1) { ?>
            <div class="paginationWrapper">
               <nav aria-label="Page navigation example ">
                  <ul class="pagination">
                     <li class="page-item"><a class="page-link" href="?pagenumber=1<? echo $sayfalamaKosulu ?>">&laquo;</a></li>
                     <?php
                     for ($i = $pagenumber - $sayfalamaIcinButonSayisi; $i <= $pagenumber + $sayfalamaIcinButonSayisi; $i++) {
                        if (($i > 0) and ($i <= $bulunanSafyaSayisi)) {
                           $curr = $i;
                           if ($pagenumber == $i) {
                              echo "<li style=\"cursor: pointer\" class=\"page-item\"><div style=\"background: black; color: white\" class=\"page-link\">$curr</div></li>";
                           } else {
                              echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?pagenumber=$curr$sayfalamaKosulu\">$curr</a></li>";
                           }
                        }
                     }
                     ?>
                     <li class="page-item"><a class="page-link" href="?pagenumber=<?= $bulunanSafyaSayisi . $sayfalamaKosulu ?>">&raquo;</a></li>
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
               <label for="book_pdf" class="form-label">Məhsul elektron</label>
                  <input style="background: transparent" type="file" class="mb-3 form-control" name="un_pdf" id="book_pdf">
                  <input placeholder="material adı" type="text" name="un_name" class="mt-3 mb-3 form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <select name="lang__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kitabın dili</option>
                     <?php
                        foreach($langs as $lang) {?>
                        <option value="<?php echo $lang["id"]?>"><?php echo $lang["name"]?></option>
                     <?php
                     }
                     ?>
                  </select>
                  <select name="sale" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Material satışdadı</option>
                     <option value="1">hə</option>
                     <option value="2">yox</option>
                  </select>
                  <input placeholder="material qiyməti" type="text" name="un_price" class="mt-3 mb-3 form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <select name="spec__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">İxtisası</option>
                     <?php
                        foreach ($specialities as $speciality) { ?>
                           <option value="<?php echo $speciality["id"] ?>"><?php echo $speciality["name"] ?></option>
                        <?php
                        }
                     ?>
                  </select>
                  <select name="cat__id" class="mb-3 form-select" aria-label="Default select example">
                     <option value="">Kateqoriya</option>
                     <?php
                        foreach($categories as $category) {?>
                        <option value="<?php echo $category["id"]?>"><?php echo $category["name"]?></option>
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
                  <button name="add__un" type="submit" class="btn btn-primary">Əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>