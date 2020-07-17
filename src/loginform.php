<?php 
ob_start();
?>


<form id="changelogin" class="col s12">
  	<div class="row">
  	  <div class="input-field col s12">
  	    <input id="newlogin" type="text" class="validate">
  	    <label class="active" for="login">New login</label>
  	    <span id="newlogin_err" class="helper-text" data-error="wrong" data-success="right"></span>
  	  </div>
  	</div>
  	<div class="row">
  	  <div class="input-field col s12">
  	    <input id="newloginconf" type="text" class="validate">
  	    <label class="active" for="login">Confirm New login</label>
  	    <span id="newloginconf_err" class="helper-text" data-error="wrong" data-success="right"></span>
  	  </div>
  	</div>
  	<div class="row">
  	  <span id="success_login" class="helper-text" data-error="wrong" data-success="right"></span>
  	</div>
  	<div class="row">
  	  <a class="waves-effect waves-light btn" onclick="Changelogin('<?=$_SESSION['user']?>', '<?=$_SESSION['id']?>')">Submit</a>
  	</div>
</form>

<?php 
$login_form = ob_get_clean();
?>