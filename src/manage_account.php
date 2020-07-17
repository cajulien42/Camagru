<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/controllers/gallery.php');
require_once(__ROOT__.'/controllers/notify.php');
require_once(__ROOT__.'/src/pwdform.php');
require_once(__ROOT__.'/src/mailform.php');
require_once(__ROOT__.'/src/loginform.php');

if (isset($_SESSION['id']) && !empty($_SESSION['id']))
{
	ob_start();
}
else
	header('Location: ' . "index.php?action=register");
?>

<div id="mygal">
<ul id="gallery">
    <?php $i = 0; foreach ($pics as $num => $pic) { if ($i < 5 && $pics[$num]['login'] == $_SESSION['user']) {?>
      <li>
        <div class="card">
          <div class="card-image waves-effect waves-block waves-light">
            <img class="activator pic" src="<?=$pics[$num]['img_url']?>" alt="<?=$num?>">
          </div>
          <div class="card-content">
            <div class="line">
              <span class="card-title activator grey-text text-darken-4"><?=$pics[$num]['login']?></span>
              <span id="like" class="card-title activator grey-text text-darken-4"><small>likes:<?=$pics[$num]['likes']?></small></span>
            </div>
            <div class="line">
              <img class="material-icon commenticon" src="https://png.pngtree.com/svg/20170121/201c2dc59c.png" onclick="delete_img(<?=$pics[$num]['img_id']?>, <?=$num?>)">
              <i class="material-icons"><img id="<?=$pics[$num]['img_id']?>" class ="likeicon" src="http://pngimg.com/uploads/heart/heart_PNG51335.png" onclick="like(<?=$pics[$num]['img_id']?>)" alt="like"></i>
            </div>
          </div>
        </div>
      </li>
    <?php $i++; }  } ?>
  </ul>
</div>
<div id="user_info">
	<div id ="login">
		<?=$_SESSION['user']?>
    <p><a href="#" onclick="displayLoginForm()">Change my login</a></p>
	</div>
	<div id ="email">
		<p><?=$_SESSION['email']?></p>
		<p><a href="#" onclick="displayMailForm()">Change my e-mail</a></p>
	</div>
	<div id ="password">
		<p><a href="#" onclick="displayPwdForm()">Change my password</a></p>
  </div>
  <form action="#">
    <p>
      <label>
    <input id="check" type="checkbox" <?php if ($notify === true) { ?> checked="checked" <?php } ?> onclick="notify('<?=$_SESSION['id']?>')"/>
        <span id="notify" class="light-blue-text lighten-3-text">Notify me when my awesome pics get awesomely commented</span>
      </label>
    </p>
  </form>
  <div id="forms">
    <div id="showorhide0" class="row">
        <?=$login_form?>
    </div>
    <div id="showorhide1" class="row">
        <?=$pwd_form?>
    </div>
    <div id="showorhide2" class="row">
        <?=$mail_form?>
    </div>
  </div>
</div>
<script src="public/js/userinfo.js"></script>
<script src="public/js/usergallery.js"></script>
<script src="public/js/delete.js"></script>
<script src="public/js/comments.js"></script>

<?php
$content = ob_get_clean();
?>
