<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (isset($_POST['jsquery']) && !empty($_POST['jsquery']))
{
  if (isset($_SESSION['id']) && !empty($_SESSION['id']))
    echo true;
  else
    echo false;
}