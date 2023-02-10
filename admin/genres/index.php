<?php
   $getGenres = $dbh->prepare("SELECT * FROM genres");
   $getGenres->execute();
   $genres = $getGenres->fetchAll(PDO::FETCH_ASSOC);
 
?>
<div class="langs__content">
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-sm-12 ">
         <div class="bg-secondary rounded h-100 p-4">
  
               <table class="table">
                  <thead>
                     <tr>
                           <th scope="col">#</th>
                           <th scope="col">Dil</th>
                           <th scope="col">Məlumat dili</th>
                           <th scope="col">İdarə</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        foreach($genres as $genre) {
                           $getLang = $dbh->prepare("SELECT * FROM language WHERE id = ?");
                           $getLang->execute([$genre["lang_İd"]]);
                           $lang = $getLang->fetch(PDO::FETCH_ASSOC);?>
                           <tr>
                              <th scope="row"><?php echo $genre["id"]?></th>
                              <td><?php echo $genre["name"]?></td>
                              <td><?php echo $lang["name"]?></td>
                              <td><a onclick="return confirm('Dili silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?genreproc=delete&id=<?php echo $genre["id"]?>" class=""><i class="fa fa-window-close"></i></a></td>
                           </tr>
                        <?php
                        }
                     ?>
                   
                  </tbody>
               </table>
         </div>
      </div>
   </div>
   </div>


   <div class="container-fluid pt-4 px-4">
         <div class="row g-4">
            <div style="margin: 20px auto" class="col-xl-6">
               <div class="bg-secondary rounded h-100 p-4">
                     <form method="POST" action="./server/process.php">
                     <select name="lang__id" class="mb-3 form-select" aria-label="Default select example">
                        <option selected>məlumatın dili</option>
                        <?php
                           foreach($langs as $lang) {?>
                           <option value="<?php echo $lang["id"]?>"><?php echo $lang["name"]?></option>
                        <?php
                        }
                        ?>
                     </select>
                        <div class="mb-3"> 
                           <input type="text" name="genre_name" class="form-control" id="exampleInputEmail1"
                                 aria-describedby="emailHelp">
                        </div>
                        <button name="add__genre" type="submit" class="btn btn-primary">Əlavə et</button>
                     </form>
               </div>
            </div>
         </div>
   </div>
</div>