<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


class CommentManager
{
  public function add_comment($pdo, $login, $date, $img_id, $text)
  {
    if (!($stmt = $pdo->prepare("INSERT INTO `comments` (`com_login`, `com_date` ,`img_id`, `text`) VALUES
        ( :login, :date, :img, :text);")))
			    return "An error occured.";
			
            $stmt->execute(array(':login' => $login,
                            ':date'=> $date,
                            ':img' => $img_id,
							              ':text'=> $text
						                ));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $_SESSION['message'] = "OK";
  }

  public function get_comments($pdo)
  {
    $req = $pdo->query("SELECT `com_id`, `com_login`, `com_date` ,`img_id`, `text` FROM `comments` ORDER BY `creation_date` DESC;");
    $req = $req->fetchAll();
    return($req);
  }

  public function get_comments_img($pdo, $img_id)
  {
    $req = $pdo->query("SELECT `com_id`, `com_login`, `com_date` ,`img_id`, `text` FROM `comments` WHERE `img_id`='$img_id' ORDER BY `com_date` DESC;");
    $req = $req->fetchAll();
    return($req);
  }

  public function update_login($pdo, $login, $new_login)
  {
      if (!($stmt = $pdo->prepare("UPDATE `comments` SET `com_login` = :new_login WHERE `com_login` = :login;")))
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
