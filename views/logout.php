<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
require_once(__ROOT__.'/config/access.php');
require_once(__ROOT__.'/src/header.php');
require_once(__ROOT__.'/src/footer.php');
if(isset($_SESSION["id"]))
{
    $_SESSION["message"] = "Logout Successful";
    $_SESSION['id'] = "";
    $_SESSION["lvl"] = "0";
    $_SESSION["user"] = "";
    $_SESSION["logged"] = "0";
}
?>

<div class="redirection">
    <div>User logged out successfully</div>
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