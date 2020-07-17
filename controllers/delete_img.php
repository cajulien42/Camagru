<?php
session_name("user");
session_start();
define('__ROOT1__', dirname(dirname(__FILE__))); 
require_once(__ROOT1__.'/config/requires.php');

if (!isset($_SESSION['user']) || empty($_SESSION['user']))
	die(false);
else if (isset($_POST['delete']) && !empty($_POST['delete']) && reg_num($_POST['delete']))
{
	$gal_mngr = new GalleryManager();
	$gal_mngr->delete_img($pdo,$_POST['delete'], $_SESSION['user']);
}
else
	die(false);
