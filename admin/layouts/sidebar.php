<div class="sidebar pe-4 pb-3">
         <nav class="navbar bg-secondary navbar-dark">
            <a href="index.html" class="navbar-brand mx-4 mb-3">
               <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>DarkPan</h3>
            </a>
            <div class="d-flex align-items-center ms-4 mb-4">
           
               <div class="ms-3">
                  <h6 class="mb-0"><?php echo $admin_name." ".$admin_surname?></h6>
                  <span class="mt-5"><?php echo $admin_status?></span>
               </div>
            </div>
            <div class="navbar-nav w-100">
               <div class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="far fa-file-alt me-2"></i>Əlavə et</a>
                  <div class="dropdown-menu bg-transparent border-0">
                     <a href=".?page=authors" class="dropdown-item">Müəllif</a>
                     <a href=".?page=languages" class="dropdown-item">Dil</a>
                     <a href=".?page=genres" class="dropdown-item">Janr</a>
                     <a href=".?page=classes" class="dropdown-item">Sinif</a>
                     <a href=".?page=subjects" class="dropdown-item">Fənn</a>
                     <a href=".?page=specialties" class="dropdown-item">İxtisas</a>
                     <a href=".?page=types" class="dropdown-item">Tiplər</a>
                  </div>
               </div>
               <div class="nav-item dropdown">
                  <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fa fa-book me-2"></i>Materiallar</a>
                  <div class="dropdown-menu bg-transparent border-0">
                     <a href=".?page=addbook" class="dropdown-item">Kitab</a>
                     <a href=".?page=university" class="dropdown-item">Universitet materialları</a>
                     <a href=".?page=manuals" class="dropdown-item">Dərslik</a>
                     <a href=".?page=classes" class="dropdown-item">Sinif</a>
                     <a href=".?page=subjects" class="dropdown-item">Fənn</a>
                     <a href=".?page=manual" class="dropdown-item">İxtisas</a>
                  </div>
               </div>
            </div>
         </nav>
      </div>