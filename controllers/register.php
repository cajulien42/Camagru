<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');

if (isset($_POST['login']) && isset($_POST['mail']) && isset($_POST['passwd'])
    && !empty($_POST['login']) && !empty($_POST['mail']) && !empty($_POST['passwd'])
    && reg_login($_POST['login']) && reg_mail($_POST['mail']) !== FALSE && reg_passwd($_POST['passwd']))
{
    $login = htmlspecialchars($_POST['login']);
    $mail = htmlspecialchars($_POST['mail']);
    $passwd = hash('whirlpool', $_POST['passwd']);
    echo(mdl_register($pdo, $login, $mail, $passwd));
}
else
    echo "Please enter all fields";
?>