<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

$g_mngr = new GalleryManager();

$pics = $g_mngr->get_photos($pdo);

if (isset($_POST['jsquery']))
{
  echo (json_encode($pics));
}
else
  echo false;