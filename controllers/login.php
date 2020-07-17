<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (isset($_POST['login']) && isset($_POST['passwd'])
    && !empty($_POST['login']) && !empty($_POST['passwd'])
    && reg_login($_POST['login']) && reg_passwd($_POST['passwd']))
{
    $login = htmlspecialchars($_POST['login']);
    $passwd = hash('whirlpool', $_POST['passwd']);
    echo (mdl_login($pdo, $login, $passwd));
}
else
    echo "Please enter all fields";
?>