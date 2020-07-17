<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
require_once(__ROOT__.'/src/header.php');
require_once(__ROOT__.'/src/manage_account.php');
require_once(__ROOT__.'/src/footer.php');
require_once(__ROOT__.'/src/template.php');