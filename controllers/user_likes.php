<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');



if (!isset($_SESSION['id']) || empty($_SESSION['id']))
  die(false);

if (isset($_POST['jsquery']) && !empty($_POST['jsquery']) && isset($_SESSION['id']) && !empty($_SESSION['id']) && reg_num($_SESSION['id']))
{
  $like_mngr = new LikeManager();
  $user_id = $_SESSION['id'];
  $u_like = $like_mngr->get_likes_user($pdo, $user_id);
  echo (json_encode($u_like));
}
else
  echo false;