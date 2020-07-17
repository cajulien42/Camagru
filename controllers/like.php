<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (!isset($_SESSION['id']) || empty($_SESSION['id']))
  die(false);

if (isset($_POST['like']) && !empty($_POST['like']) && reg_num($_POST['like']) && reg_num($_SESSION['id']))
{
  $date = time();
  $img_id = $_POST['like'];
  $user_id = $_SESSION['id'];
  // echo $user_id;
  $like_mngr = new LikeManager();
  $gal_mngr = new GalleryManager();
  $ret = $like_mngr->like($pdo, $user_id, $img_id, $date);
  if ($ret === true)
  {
    $gal_mngr->like($pdo, $img_id);
    echo "liked";
  }
  else if ($ret === false)
  {
    $gal_mngr->unlike($pdo, $img_id);
    echo "unliked";
  }
}
else
  echo false;