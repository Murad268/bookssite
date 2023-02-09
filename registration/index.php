<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="../style/style.css">
   <title>Document</title>
</head>
<body>
<div class="login-page">
  <div class="form">
    <form method="post" action="../server/process.php" class="register-form">
      <input type="text"  name="name" placeholder="ad"/>
      <input type="text"  name="surname" placeholder="soyad"/>
      <input type="email"  name="email" placeholder="elektron poçt"/>
      <button name="registration">Hesab yarat</button>
      <p class="message">Artıq hesabın var? <a href="../login/">Daxil ol</a></p>
      <?php
         if(isset($_GET["status"])) {
            if($_GET["status"] == "empty") {?>
               <div style="font-size: 12px;" class="mt-3 alert alert-danger" role="alert">
                  Xahiş edirik bütün məlumatları doldurun
               </div>
            <?php
            } elseif($_GET["status"] == "therisemail") {?>
               <div style="font-size: 12px;" class="mt-3 alert alert-danger" role="alert">
                  Bu şifrə ilə artıq istifadəçi mövcuddur
               </div>
            <?php
            } elseif($_GET["status"] == "error") {?>
               <div style="font-size: 12px;" class="mt-3 alert alert-danger" role="alert">
                  Qeydiyyat zamanı ciddi xəta baş verdi. Xahiş edirik bir az sonra yenidən cəhd edin. Əgər üç gün ərzində problem davam edərsə, administartor ilə əlaqə saxlayın
               </div>
            <?php
            } elseif($_GET["status"] == "ok") {?>
               <div style="font-size: 12px;" class="mt-3 alert alert-danger" role="alert">
                  Qeydiyyat uğurla aparılmışdır və avtomatik təyin edilmiş şifrə elektron poçtunuza göndərilmişdir. Unutmayın ki, şifrəni istənilənn vaxt dəyişə bilərsiniz
               </div>
            <?php
            }
         }
      ?>
    </form>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>

</script>
</body>
</html>