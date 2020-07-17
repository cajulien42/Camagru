<?php 
ob_start();
if (!isset($_SESSION['id']) || empty($_SESSION['id']))
{
	$button2 = "Register";
	$button3 = "Login";
}

else
{
	$button2 = "Account";
	$button3 = "Logout";
}
?>

<div class="navbar-fixed">
<nav>
    <div class="nav-wrapper">
      <a href="index.php?action=photo" class="brand-logo right">Take picture</a>
      <ul id="nav-mobile" class="left">
        <li class="active"><a href="index.php">Gallery</a></li>
        <li class="active"><a href="index.php?action=<?=strtolower($button2)?>"><?=$button2?></a></li>
        <li class="active"><a href="index.php?action=<?=strtolower($button3)?>"><?=$button3?></a></li>
      </ul>
    </div>
</nav>
</div>



<?php 
$header = ob_get_clean();
?>
