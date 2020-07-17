<?php
session_name("user");
session_start();
if (!isset($_SESSION['lvl']))
  $_SESSION['lvl'] = '0';
if (!isset($_SESSION['logged']))
  $_SESSION['logged'] = '0';
require_once("config/requires.php");

if (isset($_GET['error']) && !empty($_GET['error']))
{
    ctrl_error($_GET['error']);
}

if (isset($_GET['action']) && !empty($_GET['action']))
{
    switch ($_GET['action'])
    {
        case 'register':
            ctrl_register();
            break;
        case 'login':
            ctrl_login();
            break;
        case 'logout':
            ctrl_logout();
            break;
        case 'photo':
            ctrl_cam($pdo);
            break;
        case 'confirm':
			ctrl_confirm($pdo);
			break;
		case 'account':
			ctrl_account($pdo);
            break;
        case 'forgot':
			ctrl_forgot($pdo);
            break;
        case 'reset':
            ctrl_reset($pdo);
            break;
        default :
            header('Location: ' . 'index.php'); 
    }
}
else if (isset($_GET['filter']))
{
    ctrl_photo($pdo, $_GET['filter']);
}
else
{
    require_once("src/header.php");
    require_once("src/gallery.php");
    require_once("src/footer.php");
    require_once("src/template.php");
}
