<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


class LikeManager
{
    public function get_likes($pdo)
    {
      $req = $pdo->query("SELECT `like_id`, `user_id`, `img_id`, `like_date` FROM `likes`;");
      $req = $req->fetchAll();
      return($req);
    }

    public function get_likes_user($pdo, $user_id)
    {
      $req = $pdo->query("SELECT `like_id`, `user_id`, `img_id`, `like_date` FROM `likes` WHERE `user_id`='$user_id';");
      $req = $req->fetchAll();
      return($req);
    }

    public function get_like($pdo, $user_id, $img_id)
    {
      $req = $pdo->query("SELECT `like_id`, `user_id`, `img_id`, `like_date` FROM `likes` WHERE `user_id`='$user_id' AND `img_id`='$img_id';");
      $req = $req->fetchAll();
      return($req);
    }

    public function like($pdo, $user_id, $img_id, $date)
    {
      $like = $this->get_like($pdo, $user_id, $img_id);
      if (sizeof($like) === 0)
      {
        if (!($stmt = $pdo->prepare("INSERT INTO `likes` (`user_id`, `img_id` ,`like_date`) VALUES
        ( :user_id, :img_id, :date);")))
			    return "An error occured.";
			
        $stmt->execute(array(':user_id' => $user_id,
                            ':img_id'=> $img_id,
                            ':date' => $date));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $_SESSION['message'] = "OK";
        return (true);
      }
      else {
        if (!($stmt = $pdo->prepare("DELETE FROM `likes` WHERE `user_id` = :uid AND `img_id` = :img_id;")))
            return "An error occured.";
        $stmt->execute(array(':uid'=> $user_id,
                              ':img_id'=>$img_id));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        return (false);
      }
    }
}