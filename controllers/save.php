<?php
session_name("user");
session_start();
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/config/requires.php');
if (isset($_POST["img"]) && isset($_POST["img2"]) && isset($_POST["alt"]) && isset($_POST["size"]) && isset($_POST["left"]) && isset($_POST["top"]))
{
    if (!file_exists('../gallery'))
        mkdir('../gallery');

    $left = $_POST["left"];
    $top = $_POST["top"];
	$size = $_POST["size"];
    $filter_id = $_POST["alt"];
    $base = $_POST["img"];
    $base2 = $_POST["img2"];
    $login = $_SESSION["user"];
    $user_id = $_SESSION["id"];
    // echo "LOGIN : ".$login;
    $time = time();
    $date = date("D M Y h:i:s", $time);
    $file_name = $login."_".$time.".png";

    // Getting imgs data
    $base_to_php = str_replace('data:image/png;base64,', '', $base);
    $base_to_php = str_replace(' ', '+', $base_to_php);

    $base2_to_php = str_replace('data:image/png;base64,', '', $base2);
    $base2_to_php = str_replace(' ', '+', $base2_to_php);
    $data = base64_decode($base_to_php);
    $data2 = base64_decode($base2_to_php);

    // Creating temp files
    $base_path = '../gallery/base.png';
    $filter_path = '../gallery/filter.png';
    file_put_contents($base_path, $data);
    file_put_contents($filter_path, $data2);
    $base = imagecreatefrompng($base_path);
    $filter = imagecreatefrompng($filter_path);

    // Merging images
    $ret = imagecopy($base, $filter, $left, $top, 0, 0, $size, $size);
    if ($ret)
    {
        // Saving result
        header('Content-Type: image/png');
        imagepng($base, '../gallery/'.$file_name);
        $result = file_get_contents('../gallery/'.$file_name);
        $result = 'data:image/png;base64,' . base64_encode($result);
        
        // Free memory and delete temp files
        imagedestroy($base);
        imagedestroy($filter);
        unlink($base_path);
        unlink($filter_path);
        $gal_mngr = new GalleryManager();
        if ($gal_mngr->insert_into_gallery($pdo, $login, $file_name , $time, $filter_id)){
            echo $result;
        }
        else
            echo false;
        
    }
    else
        echo "An error occured";
}
