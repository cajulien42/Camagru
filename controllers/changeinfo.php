<?php
session_name("user");
session_start();
define('__ROOT1__', dirname(dirname(__FILE__))); 
require_once(__ROOT1__.'/config/requires.php');


if (isset($_POST['action']) && !empty($_POST['action']) && reg_name($_POST['action'])) {
  if ($_POST['action'] == "cpwd"
	&& (isset($_POST['login']) && !empty($_POST['login']) && reg_name($_POST['login'])
	&& isset($_POST['id']) && !empty($_POST['id']) && reg_num($_POST['id'])
	&& isset($_POST['old_pwd']) && !empty($_POST['old_pwd']) && reg_passwd($_POST['old_pwd'])
	&& isset($_POST['new_pwd']) && !empty($_POST['new_pwd']) && reg_passwd($_POST['new_pwd']))) {
    $mngr = new AccountManager();
    if ($mngr->change_password($pdo, $_POST['id'], $_POST['login'], $_POST['old_pwd'], $_POST['new_pwd']))
    {
      echo true;
    }
    else
      die (false);
  }

  else if ($_POST['action'] == "cmail"
	&& isset($_POST['login']) && !empty($_POST['login']) && reg_name($_POST['login'])
	&& isset($_POST['id']) && !empty($_POST['id']) && reg_num($_POST['id'])
	&& isset($_POST['mail']) && !empty($_POST['mail']) && reg_mail($_POST['mail'])) {
    $mngr = new AccountManager();
    if ($mngr->mail_exists($pdo, $_POST['mail']))
      die ("mail already exists"); 
    if($mngr->change_mail($pdo, $_POST['id'], $_POST['login'], $_POST['mail']))
    {
      $_SESSION['email'] = $_POST['mail'];
      echo true;
    }
    else
      die (false);
  }

  else if ($_POST['action'] == "clogin"
	&& isset($_POST['login']) && !empty($_POST['login']) && reg_name($_POST['login'])
	&& isset($_POST['id']) && !empty($_POST['id']) && reg_num($_POST['id'])
	&& isset($_POST['new_login']) && !empty($_POST['new_login']) && reg_login($_POST['new_login'])) {
    $mngr = new AccountManager();
    if ($mngr->login_exists($pdo, $_POST['new_login']))
      die ("login already  exists");
    if($mngr->change_login($pdo, $_POST['id'], $_POST['login'], $_POST['new_login']))
    {
      $gal = new GalleryManager();
      $comm = new CommentManager();
      $gal->update_login($pdo, $_POST['login'] ,$_POST['new_login']);
      $comm->update_login($pdo, $_POST['login'], $_POST['new_login']);
      echo true;
      $_SESSION['user'] = $_POST['new_login'];
    }
    else
      die ($_SESSION['user']);
  }

  else if ($_POST['action'] == "cpwd"
  && isset($_POST['rkey']) && !empty($_POST['rkey']) && reg_hash($_POST['rkey'])
  && isset($_POST['new_pwd']) && !empty($_POST['new_pwd']) && reg_passwd($_POST['new_pwd'])) {

    $mngr = new AccountManager();
    if ($mngr->reset_pwd($pdo, $_POST['rkey'], $_POST['new_pwd']))
    {
      echo "yolo";
    }
    else
      die (false);
  }

  else
	  echo "failure";
}
else {
  echo "failure";
}


