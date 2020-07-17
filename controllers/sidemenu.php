<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

$f_mngr = new FilterManager();
$cats = $f_mngr->get_cats($pdo);
$categories = array();
foreach ($cats as $num => $cat)
{
  $filts = $f_mngr->get_filters($pdo, $cat['cat_name']);

  foreach ($filts as $num2 => $tab)
  {
    $categories[$cat['cat_name']][] = $tab;
  }
}
