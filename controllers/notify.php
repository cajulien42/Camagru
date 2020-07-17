<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (isset($_POST['action']) && !empty($_POST['action']) && reg_name($_POST['action']) && $_POST['action'] == 'toggle'
&& isset($_POST['id']) && !empty($_POST['id']) && reg_num($_POST['id']))
{
  
  $mngr = new AccountManager();
  $ret = $mngr->togglenotify($pdo, $_POST['id']);
  echo $ret;
}
else if (isset($_POST['action']) && !empty($_POST['action']) && reg_name($_POST['action']) && $_POST['action'] == 'notify'
  && isset($_SESSION['id']) && !empty($_SESSION['id']) && reg_num($_SESSION['id']))
{
  $mngr = new AccountManager();
  $notify = $mngr->notify($pdo, $_SESSION['id']);
  echo $notify;
}
else if (isset($_SESSION['id']) && !empty($_SESSION['id']) && reg_num($_SESSION['id']))
{
  $mngr = new AccountManager();
  $notify = $mngr->notify($pdo, $_SESSION['id']);
}
else
  $notify = false;

