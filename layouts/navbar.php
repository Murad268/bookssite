<nav class="navbar">
   <ul class="navbar__links">
      <li class="navbar__link">
         <a href=".">ANA SƏHİFƏ</a>
      </li>
      <?php
         foreach($categories as $category) {?>
           <li class="navbar__link">
               <a href=".?page=books&category=<?php echo $category["slug"]?>"><?php echo $category["name"]?></a>
            </li> 
         <?php
         }
      ?>
      <li class="navbar__link">
         <a href="">BLOG</a>
         <div class="header__top__left__lang__arrow">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
         </div>
      </li>
   </ul>
</nav>


