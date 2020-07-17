<?php
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/controllers/gallery.php');
if (isset($_SESSION['id']) && !empty($_SESSION['id']))
{
  $logged = "Your awesome comment";
}
else
$logged = "You need to be logged in to sent comments";
ob_start();
?>

<div id="mygal">
  <ul id="gallery">
    <?php foreach ($pics as $num => $pic) { if ($num < 7) {?>
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
              <img class="material-icon  commenticon" src="https://img.icons8.com/windows/32/000000/topic.png" onclick="display_comment(<?=$pics[$num]['img_id']?>, <?=$num?>)">
              <i class="material-icons"><img id="<?=$pics[$num]['img_id']?>" class ="likeicon" src="http://pngimg.com/uploads/heart/heart_PNG51335.png" onclick="like(<?=$pics[$num]['img_id']?>)" alt="like"></i>
            </div>
          </div>
        </div>
        <div class="comment input-field">
          <div class="row ">
            <form class="col s12 ">
              <i class="material-icons right sendicon" onclick="img_comment(<?=$pics[$num]['img_id']?>, <?=$num?>)">send</i>
              <textarea  id="icon_prefix2" class="materialize-textarea light-blue-text lighten-3-text"></textarea>
              <label for="icon_prefix2"><?=$logged?></label>
            </form>
          </div>
        <div>
      </li>
    <?php }} ?>
  </ul>
</div>
<div id="pic_comments">
</div>
<script src="public/js/gallery.js"></script>
<script src="public/js/comments.js"></script>

<?php
$content = ob_get_clean();
?>
