<div class="header__top">
   <div class="container">
      <div class="header__top__left">
         <div class="header__top__left__lang">
            <div class="header__top__left__lang__icon">
               <img src="./assets/icons/az.png" alt="" />
            </div>
            <div class="header__top__left__lang__name">Azərbaycan</div>
            <div class="header__top__left__lang__arrow">
               <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
            <div class="header__top__left__lang__hover">
               <div class="header__top__left__lang">
                  <div class="header__top__left__lang__icon">
                     <img src="./assets/icons/rus.png" alt="" />
                  </div>
                  <div class="header__top__left__lang__name">Azərbaycan</div>
               </div>
               <div class="header__top__left__lang">
                  <div class="header__top__left__lang__icon">
                     <img src="./assets/icons/eng.png" alt="" />
                  </div>
                  <div class="header__top__left__lang__name">Azərbaycan</div>
               </div>
            </div>
         </div>
         <div class="header__top__left__currency">
            <div class="header__top__left__currency__name">AZN</div>
            <div class="header__top__left__currency__icon">₼</div>
            <div class="header__top__left__lang__arrow">
               <i class="fa fa-angle-down" aria-hidden="true"></i>
            </div>
            <div class="header__top__left__currency__hover">
               <div class="header__top__left__currency">
                  <div class="header__top__left__currency__name">USD</div>
                  <div class="header__top__left__currency__icon">$</div>
               </div>
            </div>
         </div>
      </div>
      <div class="header__top__right">
         <ul class="header__top__right__links">
            <div class="header__top__right__link">
               <a href="">Mənim Hesabım</a>
            </div>
            <?php
            if (isset($_SESSION["user_email"])) { ?>
               <div class="header__top__right__link">
                  <a onclick="return confirm('Çıxış etmək istədiyinizdən əminsiniz?')" href="./server/process.php?pros=exit">Çıxış</a>
               </div>
            <?php
            } else { ?>
               <div class="header__top__right__link">
                  <a href="./login">Daxil ol</a>
               </div>
            <?php
            }
            ?>

         </ul>
      </div>
   </div>
</div>