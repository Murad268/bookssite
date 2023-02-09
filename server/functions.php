<?php
   function seo($arg) {
      return htmlspecialchars(trim($arg));
   }

   function passwordGenerator() {
      $password_length = rand(8, 16);
      $pw = '';
      for($i = 0; $i < $password_length; $i++) {
        $pw .= chr(rand(32, 126));
      }
      return $pw;
   }

   function validateLatin($string) {
      $result = false;
      if (preg_match("/^[\w\d\s.,-]*$/", $string)) {
          $result = true;
      }
      return $result;
  }
?>