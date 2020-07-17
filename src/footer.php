<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));
ob_start();
?>

<footer class="page-footer">
           <div> © 2019 Camagru by cajulien</div>
</footer>

<?php 
$footer = ob_get_clean();
?>
