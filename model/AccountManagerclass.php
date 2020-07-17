<?php
session_name("user");
session_start();
$current_file = __FILE__;
define('__ROOT__', dirname(dirname(__FILE__)));


class AccountManager
{
	public function change_password($pdo, $uid, $login, $old_pwd, $new_pwd)
	{
		if (!($stmt = $pdo->prepare("UPDATE `users` SET `password` = :new_pwd WHERE `user_id` = :uid AND `password` = :old_pwd AND `login` = :login;")))
			return (false);
		$stmt->execute(array(':uid'=> $uid,
							':new_pwd' => hash("whirlpool", $new_pwd),
							':old_pwd' => hash("whirlpool", $old_pwd),
							'login' => $login));
		if ($stmt->rowCount() === 0)
		{
			$stmt->closeCursor();
			$_SESSION['message'] = "NOK";
			return (false);
		}
		$stmt->closeCursor();
		return (true);
    }
    
    public function change_mail($pdo, $uid, $login, $mail)
	{
		if (!($stmt = $pdo->prepare("UPDATE `users` SET `email` = :mail  WHERE `user_id` = :uid AND `login` = :login;")))
			return (false);
		$stmt->execute(array(':uid'=> $uid,
							':mail' => $mail,
							'login' => $login));
		if ($stmt->rowCount() === 0)
		{
			$stmt->closeCursor();
			$_SESSION['message'] = "NOK";
			return (false);
		}
		$stmt->closeCursor();
		return (true);
    }
    
    public function change_login($pdo, $uid, $login, $new_login)
	{
		if (!($stmt = $pdo->prepare("UPDATE `users` SET `login` = :new_login  WHERE `user_id` = :uid AND `login` = :login;")))
			return (false);
		$stmt->execute(array(':uid'=> $uid,
							':new_login' => $new_login,
							'login' => $login));
		if ($stmt->rowCount() === 0)
		{
			$stmt->closeCursor();
			$_SESSION['message'] = "NOK";
			return (false);
		}
		$stmt->closeCursor();
		return (true);
	}
	
    public function confirm_account($pdo, $uid)
    {
        if (!($stmt = $pdo->prepare("DELETE FROM `registration_keys` WHERE `uid` = :uid ;")))
            return (false);
        $stmt->execute(array(':uid'=> $uid));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return (false);
        }
        $stmt->closeCursor();
        if (!($stmt = $pdo->prepare("UPDATE `users` SET `confirmation` = '1' WHERE `user_id` = :uid;")))
            return (false);
        $stmt->execute(array(':uid'=> $uid));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return (false);
        }
        $stmt->closeCursor();
        return (true);
    }

    public function check_idkey($pdo, $id, $key)
    {
        $req = $pdo->query("SELECT `uid`, `id`, `key` FROM `registration_keys` WHERE `id` = '$id' AND `key` = '$key';");
        $req = $req->fetchAll();
        return($req);
    }

    private function get_last_ID($pdo)
    {
        $req = $pdo->query("SELECT `user_id` FROM `users` ORDER BY `user_id` DESC LIMIT 1;");
        $req = $req->fetchAll();
        return($req);
    }

    private function get_logins($pdo)
    {
        $req = $pdo->query("SELECT `login` FROM `users`;");
        $req = $req->fetchAll();
        return($req);
    }

    private function get_mails($pdo)
    {
        $req = $pdo->query("SELECT `email` FROM `users`;");
        $req = $req->fetchAll();
        return($req);
    }

    public function get_account($pdo, $login)
    {
        $req = $pdo->query("SELECT `user_id`,`login` ,`email`, `password`, `confirmation`, `lvl` FROM `users` WHERE `login` = '$login';");
        $req = $req->fetchAll();
        return ($req);
    }

    public function get_login($pdo, $user_id)
    {
        $req = $pdo->query("SELECT `login` ,`email` FROM `users` WHERE `user_id` = '$user_id';");
        $req = $req->fetchAll();
        return ($req);
    }

    public function login_exists($pdo, $login)
    {
        $logins = $this->get_logins($pdo);
        foreach($logins as $exists)
        {
            if (strtolower($login) == strtolower($exists['login']))
                return (true);
        }
        return (false);
    }

    public function mail_exists($pdo, $mail)
    {
        $mails = $this->get_mails($pdo);
        foreach($mails as $exists)
        {
            if (strtolower($mail) == strtolower($exists['email']))
                return (true);
        }
        return (false);
    }

    public function register($pdo, $login, $mail, $passwd)
    {
        if (!($stmt = $pdo->prepare("INSERT INTO `users` (`login`, `email`, `password`,`lvl`) VALUES
        ( :login, :email, :password, :lvl);")))
			return "An error occured.";
			
		$stmt->execute(array(':login'=> $login,
							':email'=> $mail,
							':password'=> $passwd,
                            ':lvl'=> '0'));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();

        // Setting reg_key and sending mail
        $uid = $this->get_last_ID($pdo)[0]['user_id'];
        $id = md5($uid);
        $key = md5(rand(0,800));
        if (!($stmt = $pdo->prepare("INSERT INTO `registration_keys` (`uid`, `id`, `key`) VALUES
        (:uid, :id, :key);"))){
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->execute(array(
            ':uid'=>$uid,
            ':id'=> $id,
            ':key'=> $key));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $message = "
        <html>
        <head>
        </head>
        <body>
            <p>Hi $login,</p>
            <p>To complete your registration please click <a href='http://localhost:8080/index.php?action=confirm&id=$id&key=$key'> Here </a></p>
        <body>
        </html>";
        send_email($mail, '[camagru]', $message);
    }

    function check_resetkey($pdo, $key)
    {
        $req = $pdo->query("SELECT * FROM `resetpwd` WHERE `key` = '$key';");
        $req = $req->fetchAll();
        return($req);
    }

    function send_reset_link($pdo, $login, $mail)
    {
        $key = md5(rand(0,800));
        while ($this->check_resetkey($pdo, $key) == 1)
        {
            $key = md5(rand(0,800));
        }
        if (!($stmt = $pdo->prepare("INSERT INTO `resetpwd` (`login`, `mail`, `key`) VALUES
        (:login, :mail, :key);"))){
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->execute(array(
            ':login' => $login,
            ':mail'=> $mail,
            ':key'=> $key));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return "An error occured.";
        }
        $stmt->closeCursor();
        $message = "
        <html>
        <head>
        </head>
        <body>
            <p>Hi $login,</p>
            <p>To reset your password please click <a href='http://localhost:8080/index.php?action=reset&key=$key'> Here </a></p>
        <body>
        </html>";
        send_email($mail, '[camagru]', $message);
    }


    public function change_password2($pdo, $uid, $login, $old_pwd, $new_pwd)
	{
		if (!($stmt = $pdo->prepare("UPDATE `users` SET `password` = :new_pwd WHERE `user_id` = :uid AND `password` = :old_pwd AND `login` = :login;")))
			return (false);
		$stmt->execute(array(':uid'=> $uid,
							':new_pwd' => hash("whirlpool", $new_pwd),
							':old_pwd' => $old_pwd,
							'login' => $login));
		if ($stmt->rowCount() === 0)
		{
			$stmt->closeCursor();
			$_SESSION['message'] = "NOK";
			return (false);
		}
		$stmt->closeCursor();
		return (true);
    }

    function delete_rkey($pdo, $key)
    {
        if (!($stmt = $pdo->prepare("DELETE FROM `resetpwd` WHERE `key` = :key ;")))
            return (false);
        $stmt->execute(array(':key'=> $key));
        if ($stmt->rowCount() === 0)
        {
            $stmt->closeCursor();
            $_SESSION['message'] = "NOK";
            return (false);
        }
        $stmt->closeCursor();
    }

    function reset_pwd($pdo, $key, $pwd)
    {
        $req = $this->check_resetkey($pdo, $key);
        $acc = $this->get_account($pdo, $req[0]['login']);
        if($this->change_password2($pdo, $acc[0]['user_id'], $acc[0]['login'], $acc[0]['password'], $pwd))
        {
            $this->delete_rkey($pdo, $key);
            echo true;
        }
        else
            die(false);
    }

    function notify($pdo, $uid)
    {
        $req = $pdo->query("SELECT `notify` FROM `users` WHERE `user_id` = '$uid';");
        $req = $req->fetchAll();
        if (sizeof($req) == 0)
        {
            return(false);
        }
        return ($req[0]['notify'] == 1);
            
    }

    function togglenotify($pdo, $uid)
    {
    //    echo ($this->notify($pdo, $uid) == 0);
        if ($this->notify($pdo, $uid))
        {
            if (!($stmt = $pdo->prepare("UPDATE `users` SET `notify` = :notify WHERE `user_id` = :uid;")))
			    return (false);
		    $stmt->execute(array(':uid'=> $uid,
		    					'notify' => 0));
		    if ($stmt->rowCount() === 0)
		    {
		    	$stmt->closeCursor();
		    	$_SESSION['message'] = "NOK";
		    	return (false);
		    }
            $stmt->closeCursor();
        }
        else 
        {
            if (!($stmt = $pdo->prepare("UPDATE `users` SET `notify` = :notify WHERE `user_id` = :uid;")))
			    return (false);
		    $stmt->execute(array(':uid'=> $uid,
		    					'notify' => 1));
		    if ($stmt->rowCount() === 0)
		    {
		    	$stmt->closeCursor();
		    	$_SESSION['message'] = "NOK";
		    	return (false);
		    }
            $stmt->closeCursor();
        }
        return (true);
    }
}
