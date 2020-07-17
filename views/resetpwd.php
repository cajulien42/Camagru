<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config/access.php');
require_once(__ROOT__.'/config/requires.php');
require_once(__ROOT__.'/src/header.php');
require_once(__ROOT__.'/src/footer.php');
ob_start();
?>

<div class="row">
  <form id="changepwd" class="col s12">
    	<div class="row">
    	  <div class="input-field col s12">
    	    <input id="newpassword" type="password" class="validate">
    	    <label class="active" for="password">New Password</label>
    	    <span id="newpasswd_err" class="helper-text" data-error="wrong" data-success="right"></span>
    	  </div>
    	</div>
    	<div class="row">
    	  <div class="input-field col s12">
    	    <input id="newpasswordconf" type="password" class="validate">
    	    <label class="active" for="password">Confirm New Password</label>
    	    <span id="newpasswdconf_err" class="helper-text" data-error="wrong" data-success="right"></span>
    	  </div>
    	</div>
    	<div class="row">
    	  <span id="success" class="helper-text" data-error="wrong" data-success="right"></span>
    	</div>
    	<div class="row">
    	  <a class="waves-effect waves-light btn" onclick="resetPwd('<?=$_SESSION['rkey']?>')">Submit</a>
    	</div>
  </form>
</div>
<script src="public/js/resetpwd.js"></script>

<?php 
    $content = ob_get_clean();
    require_once("src/template.php");
?>