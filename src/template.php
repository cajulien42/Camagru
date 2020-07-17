<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Camagru</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="public/css/global.css">
  <link rel="stylesheet" type="text/css" href="public/css/sidemenu.css">
  
  <link rel="stylesheet" type="text/css" href="public/css/gallery.css">
  <link rel="stylesheet" type="text/css" href="public/css/camera.css">
  <link rel="stylesheet" type="text/css" href="public/css/comments.css">
  <link rel="stylesheet" type="text/css" href="public/css/account.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
<?php if (isset($script_src)) { ?><script src="<?=$script_src?>"></script> <?php } ?>
</head>

<body>
	<div id="header">
		<?= $header ?>
	</div>
	<div id="content">
		<?= $content ?>
	</div>
	<div id="footer">
		<?= $footer ?>
	</div>

</body>
</html>
