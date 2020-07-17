<?php
session_name("user");
session_start();
define('__ROOT1__', dirname(dirname(__FILE__))); 
require_once(__ROOT1__.'/config/requires.php');

if (isset($_POST['email']) && !empty($_POST['email']) && reg_mail($_POST['email'])
  && isset($_POST['message']) && !empty($_POST['message'])
  && isset($_POST['subject']) && !empty($_POST['subject']) && reg_text($_POST['subject'])
  )
{
  // echo "HERE";
  send_email($_POST['email'], $_POST['subject'], $_POST['message']);
}
else
  echo false;
