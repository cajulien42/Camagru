<?php 
ob_start();
?>

<div class="row">
  <form id="resetpwd" class="col s12">
    <div class="row">
      <div class="input-field col s12">
        <input id="login" type="text" class="validate">
        <label class="active" for="login">login</label>
        <span id="login_err" class="helper-text" data-error="wrong" data-success="right"></span>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="email" type="email" class="validate">
        <label class="active" for="email">email</label>
        <span id="email_err" class="helper-text" data-error="wrong" data-success="right"></span>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input id="emailconf" type="email" class="validate">
        <label class="active" for="email">Confirm email</label>
        <span id="emailconf_err" class="helper-text" data-error="wrong" data-success="right"></span>
      </div>
    </div>
    <div class="row">
      <span id="success_mail" class="helper-text" data-error="wrong" data-success="right"></span>
    </div>
    <div class="row">
      <a class="waves-effect waves-light btn" onclick="forgotpwd()">Submit</a>
    </div>
  </form>
</div>
<script src="public/js/forgotpwd.js"></script>

<?php 
$content = ob_get_clean();
?>