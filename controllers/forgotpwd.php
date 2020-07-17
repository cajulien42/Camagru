<?php
session_name("user");
session_start();
define('__ROOT1__', dirname(dirname(__FILE__))); 
require_once(__ROOT1__.'/config/requires.php');

if (isset($_POST['action']) && !empty($_POST['action']) && reg_name($_POST['action'])) {
  if ($_POST['action'] == "rpwd"
  && isset($_POST['login']) && !empty($_POST['login']) && reg_name($_POST['login'])
  && isset($_POST['mail']) && !empty($_POST['mail']) && reg_mail($_POST['mail'])) {
    $mngr = new AccountManager();
    if ($mngr->send_reset_link($pdo, $_POST['login'], $_POST['mail']))
      echo true;
    else
      die (false);
  }
  else
	  echo "failure";
}
else {
  echo "failure";
}
