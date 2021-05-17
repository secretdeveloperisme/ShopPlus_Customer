<?php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'quanlydathang');
  define('DB_USER','root');
  define('DB_PASSWORD','');
  $connect = new mysqli(DB_HOST,DB_NAME,DB_PASSWORD,DB_NAME) or die("Cannot connect to database");
?>