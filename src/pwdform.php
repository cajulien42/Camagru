<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));
ob_start();
?>


<form id="changepwd" class="col s12">
  	<div class="row">
  	  <div class="input-field col s12">
  	    <input id="oldpassword" type="password" class="validate">
  	    <label class="active" for="password">Old Password</label>
  	    <span id="oldpasswd_err" class="helper-text" data-error="wrong" data-success="right"></span>
  	  </div>
  	</div>
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
  	  <a class="waves-effect waves-light btn" onclick="ChangePwd('<?=$_SESSION['user']?>', '<?=$_SESSION['id']?>')">Submit</a>
  	</div>
</form>

<?php 
$pwd_form = ob_get_clean();
?>
