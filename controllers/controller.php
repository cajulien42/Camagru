<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
function mdl_login($pdo, $login, $passwd)
{
    $mngr = new AccountManager();
    $account = $mngr->get_account($pdo, $login);
    if (sizeof($account) === 0)
    {
        $_SESSION['error'] = "Invalid login and/or password";
        return("Invalid login and/or password");  
    }
    else if ($account[0]['password'] !== $passwd && $account[0]['password'] !== strtoupper($passwd))
    {
        $_SESSION['error'] = "Invalid login and/or password";
        return("Invalid login and/or password");  
    }
    else if ($account[0]['confirmation'] === '0')
    {
        $_SESSION['error'] = "please confirm your registration";
        return("please confirm your registration");
    }
    else
    {
        $_SESSION["message"] = "Login Successful";
        $_SESSION['id'] = $account[0]['user_id'];
        $_SESSION["lvl"] = $account[0]['lvl'];
		$_SESSION["user"] = $account[0]['login'];
		$_SESSION["email"] = $account[0]['email'];
        $_SESSION['logged'] = '1';
        return("OK");
    }
}

function mdl_register($pdo, $login, $mail, $passwd)
{
    $mngr = new AccountManager();

    if ($mngr->login_exists($pdo, $login))
    {
        $_SESSION['message'] = "NOK";
        echo "Login already exists !";
    }

    else if ($mngr->mail_exists($pdo, $mail))
    {
        $_SESSION['message'] = "NOK";
        echo "Mail already exists !";
    }
    else
        echo $mngr->register($pdo, $login, $mail, $passwd);
}

function ctrl_register() 
{
    require_once("views/register.php");
}

function ctrl_login() 
{
    require_once("views/login.php");
}

function ctrl_logout() 
{
    require_once("views/logout.php");
}

function ctrl_confirm($pdo)
{
    if (isset($_GET['id']) && isset($_GET['key']) 
    && !empty($_GET['id']) && !empty($_GET['key'])
    && reg_hash($_GET['id']) && reg_hash($_GET['key']))
    {
        $mngr = new AccountManager();
        $arr = $mngr->check_idkey($pdo, $_GET['id'], $_GET['key']);
        if (sizeof($arr) !== 1)
        {
            $_SESSION['confirmation'] = "nok";
            require_once("views/confirmation.php");
        }
        else
        {
            $id = $arr[0]['uid'];
            if($mngr->confirm_account($pdo, $id))
                $_SESSION['confirmation'] = "ok";
            else
                $_SESSION['confirmation'] = "nok";
            require_once("views/confirmation.php");
        }
    }
    else
        header('Location: ' . 'index.php');
}

function ctrl_photo($pdo, $filter_id)
{
    if (!empty($filter_id)
    && reg_num($filter_id))
    {
        $f_mngr = new FilterManager();
        $selected_filter = $f_mngr->get_filter($pdo, $filter_id);
        if (sizeof($selected_filter) !== 1)
            header('Location: ' . 'index.php');
        else
        {
            // print_r($selected_filter);
            require_once("src/header.php");
            require_once("src/photo.php");
            require_once("src/footer.php");
            require_once("src/template.php");
        }
    }
    else
    {
        header('Location: ' . 'index.php');
    }
}

function ctrl_error($error)
{
    if (reg_error($error))
    {
        $msg = error_exists($error);
        require_once("src/header.php");
        require_once("src/redirect.php");
        require_once("src/footer.php");
        require_once("src/template.php");
    }
}

function ctrl_cam($pdo)
{
    $script_src =  'public/js/webcam.js';
    require_once("views/take_photo.php");
}

function send_email($to, $subject, $message)
{
    $headers = array();
    $headers[] = 'From: root@localhost';
    $headers[] = 'Reply-To: no-reply@localhost';
    $headers[] = 'X-Mailer: PHP/' . phpversion();
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    if (!mail($to, $subject, $message, implode("\r\n", $headers)))
    {
      $errorMessage = error_get_last()['message'];
      echo $errorMessage;
      echo false;
    }
    else
    {
      $_SESSION['message'] = "OK";
      echo true;
    }
}

function ctrl_account($pdo)
{
	require_once("views/account.php");
}

function ctrl_forgot($pdo)
{
    require_once("views/forgotpwd.php");
}

function ctrl_reset($pdo)
{
    if (isset($_GET['key']) 
    && !empty($_GET['key'])
    && reg_hash($_GET['key']))
    {
        $mngr = new AccountManager();
        if (!$arr = $mngr->check_resetkey($pdo, $_GET['key']))
        {
            $_SESSION['reset'] = "nok";
            header('Location: ' . 'index.php');
        }
        else
        {
            $_SESSION['rkey'] = $_GET['key'];
            require_once("views/resetpwd.php");
        }
    }
    else
        header('Location: ' . 'index.php');
}
