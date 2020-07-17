<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (isset($_POST['img_id']) && !empty($_POST['img_id']) && reg_num($_POST['img_id']))
{
  $img_id = $_POST['img_id'];
  $comm_mngr = new CommentManager();
  $img_comms = $comm_mngr->get_comments_img($pdo, $img_id);
  echo (json_encode($img_comms));
}
else
  echo false;