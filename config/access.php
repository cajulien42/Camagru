<?php
session_name('user');
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
$files = array( __ROOT__.'index.php' => array('lvl' => '0', 'logged' => '2'),
              __ROOT__.'/views/login.php' => array('lvl' => '0', 'logged' => '0'),
              __ROOT__.'/views/logout.php' => array('lvl' => '0', 'logged' => '1'),
              __ROOT__.'/views/register.php' => array('lvl' => '0', 'logged' => '0'),
              __ROOT__.'/src/photo.php' => array('lvl' => '0', 'logged' => '1'),
              __ROOT__.'/views/take_photo.php' => array('lvl' => '0', 'logged' => '1'),
              __ROOT__.'/views/confirmation.php' => array('lvl' => '0', 'logged' => '0'),
              __ROOT__.'/views/account.php' => array('lvl' => '0', 'logged' => '1'),
              __ROOT__.'/views/forgotpwd.php' => array('lvl' => '0', 'logged' => '0'),
              __ROOT__.'/views/resetpwd.php' => array('lvl' => '0', 'logged' => '0')
            );

$nb = 0;
foreach ($files as $file => $rights)
{
  if ($file === $current_file) {
    if (!isset($_SESSION['lvl']) || empty($_SESSION['lvl']))
      $_SESSION['lvl'] = '0';
    if (!isset($_SESSION['logged']) || empty($_SESSION['logged']))
      $_SESSION['logged'] = '0';
    if ($rights['lvl'] !== '0')
    {
      if ($_SESSION['lvl'] < $rights['lvl'])
        header('Location: ' . "index.php?error=error1");
    }
    if ($rights['logged'] === '1' && $_SESSION['logged'] === '0')
      header('Location: ' . 'index.php?error=error2');
    if ($rights['logged'] === '0' && $_SESSION['logged'] === '1')
      header('Location: ' . 'index.php?error=error3');
    break;
    }
    $nb++;
}
// if ($nb == sizeof($files)) {
//   header('Location: ' . "index.php");
// }

// echo "current = ".$current_file;
// echo " file = ".$file;
// print_r($rights);
// echo $_SESSION['lvl'];
// echo $_SESSION['logged']; 







