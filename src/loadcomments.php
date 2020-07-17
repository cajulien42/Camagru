<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/controllers/gallery.php');

if (isset($_POST['img_id']) && !empty($_POST['img_id']) && reg_num($_POST['img_id']))
{
	$cmt_mngr = new CommentManager;
	$comments = $cmt_mngr->get_comments($pdo, $img_id);
	print_r($comments);
}
else 
	echo false;


