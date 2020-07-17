<?phpsession_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/config/access.php');
require_once(__ROOT__.'/controllers/sidemenu.php');
ob_start();
?>

<div class="pure">
		<ul class="mcd-menu">
			<?php foreach ($categories as $cat_name => $filters) { ?>
				<li>
					<a href="">
						<i class="fa fa-comments-o"></i>
						<strong><?=$cat_name?></strong>
						
					</a>
					<ul>
						<div class="flex_img">
							<?php foreach ($filters as $filter) { ?>
								<li><a id="<?=$filter['filter_id']?>"><img class="menu_filter" src="<?=$filter['filter_url']?>" alt="<?=$filter['filter_name']?>;<?=$filter['filter_cat']?>" onclick="select_filter(<?=$filter['filter_id']?>)"/></a></li>
							<?php } ?>
						</div>
					</ul>
				</li> 
			<?php } ?>
		</ul>
</div>
<script src="public/js/filter.js"></script>

<?php 
$sidemenu = ob_get_clean();
?>
