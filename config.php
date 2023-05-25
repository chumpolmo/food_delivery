<?php
  define('DB_SERVER', 'xxx');
  define('DB_USERNAME', 'xxx');
  define('DB_PASSWORD', 'xxx');
  define('DB_DATABASE', 'xxx');
  
  $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

  mysqli_set_charset($db,'utf8');

  // Check connection
  if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
    die();
  }
?>
