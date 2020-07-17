<?PHP 
  function reg_mail($mail)
  {
    return (filter_var(trim($mail), FILTER_VALIDATE_EMAIL));
  }

  function  reg_passwd($passwd)
  {
    return (preg_match("/^[a-zA-Z0-9=*\-+_!]{8,40}$/", trim($passwd)));
  }

  function  reg_num($num)
  {
      return (preg_match("/^[0-9]{1,15}$/", $num));
  }

  function  reg_url($url)
  {
      return (preg_match("/^(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]$/im", $url));
  }

  function  reg_login($login)
  {
    return (preg_match("/^[a-zA-Z ]{2,20}$/", trim($login)));
  }

  function  reg_hash($hash)
  {
    return (preg_match("/^[a-fA-F0-9]+$/", $hash));
  }

  function reg_name($name)
  {
    return(preg_match("/^[a-zA-Z0-9_.]+$/", $name));
  }

  function reg_error($err)
  {
    return (preg_match("/^[a-zA-Z0-9]+$/", $err));
  }

  function reg_text($text)
  {
    return(preg_match("/^[a-zA-Z0-9 .=\/*\-+()[\]{}!@#\$%\^&\*\"'\/?,:;_]+$/m", $text));
  }