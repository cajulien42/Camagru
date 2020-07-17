<?php
session_name('user');
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
require_once(__ROOT__.'/controllers/sidemenu.php');
require_once(__ROOT__.'/controllers/gallery.php');
require_once(__ROOT__.'/src/sidemenu.php');
require_once(__ROOT__.'/config/access.php');
ob_start();

?>

<div id="sidemenu">
	<?= $sidemenu ?>
</div>
<div id="imgmenu">
	<?= $imgmenu ?>
</div>

<div id="main_section">
	<div class="contain">
		<div class="camera">
			<div id="webcam">
				<div id="main_container">
					<div id="mydiv">
						<div id="mydivheader"></div>
						</div>
						<div id="base"><video id="video"></video></div>
					</div>
				</div>
				<div id="upform">
					<form method="post" enctype="multipart/form-data">
    				<input type="file" name="fileToUpload" id="fileToUpload">
    				<input type="submit" value="Upload Image" name="submit">
					</form>
				</div>
			</div>
			<div id="err"></div>
			<div id="controls">	
				<div id="resize_filter">
					<a class="btn-floating btn-large waves-effect waves-light" onclick="upsize()">+</a>
					<div class="take_photo">
						<button id="startbutton" class="btn-floating btn-large waves-effect waves-light small"><i class="material-icons">camera_alt</i></button>
					</div>
					<a class="btn-floating btn-large waves-effect waves-light" onclick="downsize()">-</a>
				</div>
			</div>
			<div id="success"></div>
		</div>
		<canvas id="canvas"></canvas>
		<canvas id="canvas2"></canvas>
	</div>
	<div id="mygal2">
		<ul id="gallery">
	    <?php  $i = 0; foreach ($pics as $num => $pic) { ; if ($i < 7 && $pics[$num]['login'] == $_SESSION['user']) {?>
	      <li>
	        <div class="card">
	          <div class="card-image waves-effect waves-block waves-light">
	            <img class="activator pic" src="<?=$pics[$num]['img_url']?>" alt="<?=$num?>">
	          </div>
	        </div>
	      </li>
	    <?php $i++;}  } ?>
	  </ul>
	</div>
</div>

<script src="public/js/upload.js"></script>
<script src="public/js/drag.js"></script>
<script src="public/js/gallerycam.js"></script>

<?php 
$content = ob_get_clean();
?>
