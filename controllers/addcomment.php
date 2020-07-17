<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');


if (!isset($_SESSION['id']) || empty($_SESSION['id']))
{
  die(false);
}

if (isset($_POST['img_id']) && !empty($_POST['img_id']) && reg_num($_POST['img_id'])
   && isset($_POST['text']) && !empty($_POST['text']) && reg_text($_POST['text'])
  )
{
  // echo $_POST['text'];
  $uid = $_SESSION['id'];
  $date = time();
  $acc_mngr = new AccountManager();
  $tab = $acc_mngr->get_login($pdo, $uid);
  
  if (sizeof($tab) === 0)
  {
    die(false);
  }
  // print_r($tab);
  $login = $tab[0]['login'];
  $mail = $tab[0]['email'];
  // echo reg_text($_POST['text']);
  $comm_mngr = new CommentManager();
  $comm_mngr->add_comment($pdo, $login, $date, $_POST['img_id'], $_POST['text']);
  $ret = array('login' => $login, 'mail' => $mail, 'msg' => $_POST['text']);
  echo json_encode($ret);
}
else
  die (false);