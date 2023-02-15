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

  // :: e > e; :: ə > e;
  function normalize($string) {
    // Transliterate non-ASCII characters to ASCII characters
    $transliterator = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC; Latin-ASCII;');
    $string = $transliterator->transliterate($string);

    // Replace non-alphanumeric characters with hyphens
    $slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $string);

    // Convert the slug to lowercase
    $slug = strtolower($slug);

    // Remove leading and trailing hyphens
    $slug = trim($slug, '-');

    return $slug;
}


function dateR($unix_timestamp) {
      return date('Y-m-d H:i:s', $unix_timestamp);
}
