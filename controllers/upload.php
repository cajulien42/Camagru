<?php
session_name("user");
session_start();
define('__ROOT1__', dirname(dirname(__FILE__))); 
require_once(__ROOT1__.'/config/requires.php');

if (isset($_FILES['file']) && !empty($_FILES['file']) && is_array($_FILES['file']) && reg_name($_FILES['file']['name']))
{
  if($_FILES['file']['type'] !== "image/png") 
  {
    echo false;

  }
  else if ($_FILES['file']['size'] > 500000)
  {
    echo false;
  }
  else {
    $target_dir = __ROOT1__.'/uploads/';
    if (!file_exists($target_dir))
      mkdir($target_dir);
    $file_name = $_FILES['file']['name'];
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir.$file_name);
    $_SESSION['upload'] = '/uploads/'.$file_name;
    echo 'uploads/'.$file_name;
  }
}
else
  echo false;



