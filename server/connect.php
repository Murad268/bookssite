<?php
  try {
   $dbh = new PDO('mysql:host=localhost;dbname=skybooks', "root", "");
  } catch ( PDOException $e) {
      echo $e->getMessage();
  }
?>