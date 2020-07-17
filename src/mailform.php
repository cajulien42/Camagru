<?php 
ob_start();
?>


<form id="changemail" class="col s12">
  	<div class="row">
  	  <div class="input-field col s12">
  	    <input id="newemail" type="email" class="validate">
  	    <label class="active" for="email">New email</label>
  	    <span id="newemail_err" class="helper-text" data-error="wrong" data-success="right"></span>
  	  </div>
  	</div>
  	<div class="row">
  	  <div class="input-field col s12">
  	    <input id="newemailconf" type="email" class="validate">
  	    <label class="active" for="email">Confirm New email</label>
  	    <span id="newemailconf_err" class="helper-text" data-error="wrong" data-success="right"></span>
  	  </div>
  	</div>
  	<div class="row">
  	  <span id="success_mail" class="helper-text" data-error="wrong" data-success="right"></span>
  	</div>
  	<div class="row">
  	  <a class="waves-effect waves-light btn" onclick="ChangeMail('<?=$_SESSION['user']?>', '<?=$_SESSION['id']?>')">Submit</a>
  	</div>
</form>

<?php 
$mail_form = ob_get_clean();
?>
