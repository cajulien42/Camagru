<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
require_once(__ROOT__.'/src/header.php');
require_once(__ROOT__.'/src/footer.php');
require_once(__ROOT__.'/config/access.php');


if (!isset($_SESSION['confirmation']) || empty($_SESSION['confirmation']) || !preg_match("/^ok$/", $_SESSION['confirmation']))
    $msg = "BAD REQUEST ! BAD !";
else
{
    $msg = "Confirmation successful!";
    $_SESSION['confirmation'] = "";
}
?>
<div>
    <div class=confirmation><?=$msg?></div>
    <div class=redirect>redirecting...</div>
    <div class="progress" style="opacity : 1">
      <div class="indeterminate"></div>
    </div>
</div>
<script src="public/js/redirect.js"></script>

<?php 
    $content = ob_get_clean();
    require_once("src/template.php");
?>