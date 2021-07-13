<?php
  define('DB_HOST', 'localhost');
  define('DB_NAME', 'quanlydathang');
  define('DB_USER','customer');
  define('DB_PASSWORD','CustomerShopPlus777');
  function connectDB(){
    $connect = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die("Cannot connect to database");
    return $connect;
  }
 ?> 