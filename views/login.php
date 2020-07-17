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
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input id="last_name" type="text" class="validate">
          <label class="active" for="last_name">Login</label>
          <span id="login_err" class="helper-text" data-error="wrong" data-success="right"></span>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
            <input id="password" type="password" class="validate">
            <label class="active" for="password">Password</label>
            <span id="passwd_err" class="helper-text" data-error="wrong" data-success="right"></span>
            <a href="index.php?action=forgot"> Forgot Your password ?</a>
        </div>
      </div>
      <div class="row">
        <span id="success" class="helper-text" data-error="wrong" data-success="right"></span>
      </div>
      <div class="row">
        <a class="waves-effect waves-light btn" onclick="click_login_validate()">go !</a>
      </div>
    </form>
    <div class="progress" style="opacity : 0">
      <div class="indeterminate"></div>
  </div>
</div>
<script src="public/js/login.js"></script>

<?php 
    $content = ob_get_clean();
    require_once("src/template.php");
?>
