<?php
   $getLangs = $dbh->prepare("SELECT * FROM language");
   $getLangs->execute();
   $langs = $getLangs->fetchAll(PDO::FETCH_ASSOC);
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
                           <th scope="col">İdarə</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        foreach($langs as $lang) {?>
                           <tr>
                              <th scope="row"><?php echo $lang["id"]?></th>
                              <td><?php echo $lang["name"]?></td>
                              <td><a onclick="return confirm('Dili silmək istədiyinizdən əminsinizmi?')" href="./server/process.php?langproc=delete&id=<?php echo $lang["id"]?>" class=""><i class="fa fa-window-close"></i></a></td>
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
                        <div class="mb-3"> 
                           <input type="text" name="lang_name" class="form-control" id="exampleInputEmail1"
                                 aria-describedby="emailHelp">
                        </div>
                        <button name="add__lang" type="submit" class="btn btn-primary">Əlavə et</button>
                     </form>
               </div>
            </div>
         </div>
   </div>
</div>