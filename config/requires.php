<?php
session_name('user');
session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config/database.php');
require_once(__ROOT__.'/config/errors.php');
require_once(__ROOT__.'/config/utilities.php');
require_once(__ROOT__.'/config/setup.php');
require_once(__ROOT__.'/config/regex.php');
require_once(__ROOT__.'/controllers/controller.php');
require_once(__ROOT__.'/model/AccountManagerclass.php');
require_once(__ROOT__.'/model/FilterManagerclass.php');
require_once(__ROOT__.'/model/GalleryManagerclass.php');
require_once(__ROOT__.'/model/LikeManagerclass.php');
require_once(__ROOT__.'/model/CommentManagerclass.php');


