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
$toplamKayitSayisiSorgusu = $dbh->prepare("SELECT * FROM types $s");
$toplamKayitSayisiSorgusu->execute();
$toplamKayitSayisi = $toplamKayitSayisiSorgusu->rowCount();
$sayfalamayBaslayacaqKayotSayisi = ($pagenumber * $sayfaBasinaGosterilecek) - $sayfaBasinaGosterilecek;
$bulunanSafyaSayisi = ceil($toplamKayitSayisi / $sayfaBasinaGosterilecek);
$getTypes = $dbh->prepare("SELECT * FROM types $s LIMIT $sayfalamayBaslayacaqKayotSayisi, $sayfaBasinaGosterilecek");
$getTypes->execute();
$types = $getTypes->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="langs__content">
   <div class="mt-4 ms-4 author__content__form">
      <form method="POST" action="./server/process.php">
         <input placeholder="Sinif nömrəsini daxil edin" name="search" class="form-control" type="text">
         <button type="submit" name="searchType" class="btn btn-dark">axtar</button>
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
                        <th scope="col">Tip</th>
                        <th scope="col">İdarə</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     foreach ($types as $type) {?>
                        <tr>
                           <th scope="row"><?php echo $type["id"] ?></th>
                           <td><?php echo $type["name"] ?></td>
                           <td><a onclick="return confirm('Tipi silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?typepros=delete&id=<?php echo $type["id"] ?>" class=""><i class="fa fa-window-close"></i></a></td>
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
               <form method="POST" action="./server/process.php">
                  <input type="text" name="type" class="mb-3 form-control" placeholder="Tipin adı">
                  <button name="add__type" type="submit" class="btn btn-primary">Əlavə et</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>