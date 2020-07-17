<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


class GalleryManager
{
    private function _get_last_photo($pdo)
    {
        $req = $pdo->query("SELECT `img_id` FROM `gallery` ORDER BY `img_id` DESC LIMIT 1;");
        $req = $req->fetchAll();
        return($req);
    }
    
    public function insert_into_gallery($pdo, $login, $file_name , $date, $filter_id) 
    {
        $req = $pdo->query("SELECT * FROM `gallery` WHERE `login` = '$login';");
        $req = $req->fetchAll();
        if (sizeof($req) > 15) {
            return false;
        }
        if (!($stmt = $pdo->prepare("INSERT INTO `gallery` (`img_url`, `login` ,`img_name`, `filter_id`, `creation_date`) VALUES
        ( :img_url, :login, :img_name, :filter_id, :creation_date);")))
			    return false;
			
            $stmt->execute(array(':img_url' => 'gallery/'.$file_name,
                            ':login'=> $login,
                            ':img_name' => $file_name,
							':filter_id'=> $filter_id,
							':creation_date'=> $date));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return false;
        }
        $stmt->closeCursor();
        $_SESSION['message'] = "OK";
        return true;
    }

    public function get_photos($pdo)
    {
        $req = $pdo->query("SELECT * FROM `gallery` ORDER BY `creation_date` DESC;");
        $req = $req->fetchAll();
        return($req);
    }

    private function get_photo($pdo, $img_id)
    {
        $req = $pdo->query("SELECT * FROM `gallery` WHERE `img_id`='$img_id';");
        $req = $req->fetchAll();
        return($req);
    }

    public function like($pdo, $img_id)
    {
        if (!($stmt = $pdo->prepare("UPDATE `gallery` SET `likes` = `likes`+1 WHERE `img_id` = :img_id;")))
            return (false);
        $stmt->execute(array(':img_id'=> $img_id));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $_SESSION['message'] = "OK";
    }

    public function unlike($pdo, $img_id)
    {
        if (!($stmt = $pdo->prepare("UPDATE `gallery` SET `likes` = `likes`-1 WHERE `img_id` = :img_id;")))
            return (false);
        $stmt->execute(array(':img_id'=> $img_id));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $_SESSION['message'] = "OK";
	}
	
	public function delete_img($pdo, $img_id, $login)
	{
        $req = $pdo->query("SELECT * FROM `gallery` WHERE `login` = '$login' AND `img_id` = '$img_id';");
        $req = $req->fetchAll();
        if (sizeof($req) != 1)
            return "An error occured.";
		if (!($stmt = $pdo->prepare("DELETE FROM `gallery` WHERE `login` = :uid AND `img_id` = :img_id;")))
            return "An error occured.";
        $stmt->execute(array(':uid'=> $login,
                              ':img_id'=>$img_id));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        unlink('../gallery/'.$req[0]['img_name']);
		return true;
    }
    
    public function update_login($pdo, $login, $new_login)
    {
        if (!($stmt = $pdo->prepare("UPDATE `gallery` SET `login` = :new_login WHERE `login` = :login;")))
            return (false);
        $stmt->execute(array(':login'=> $login,
                            ':new_login' => $new_login));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return false;
        }
        $stmt->closeCursor();
        return (true);
    } 
}
