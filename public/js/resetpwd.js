function resetPwd(key) {

  let new_pwd = document.getElementById('newpassword').value;
  let conf_pwd = document.getElementById('newpasswordconf').value;
  let new_err = document.getElementById('newpasswd_err');
  let conf_err = document.getElementById('newpasswdconf_err');
  let success = document.getElementById('success');

  success.style.opacity = 0;
  new_err.style.opacity = 0;
  conf_err.style.opacity = 0;

  new_err.innerHTML = "";
  conf_err.innerHTML = "";
  // console.log(`action=cpwd&new_pwd=${new_pwd}&rkey=${key}`);
  const pwd_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
  
  if (!new_pwd || !new_pwd.trim() || new_pwd.length === 0) {
    new_err.style.opacity = 1;
    new_err.innerHTML = "Please enter your new password.";
  }
  else if (new_pwd.length < 8) {
    new_err.style.opacity = 1;
    new_err.innerHTML = "Your new password must be at least 8 characters.";
  }
  else if (!pwd_regex.test(new_pwd)) {
    new_err.style.opacity = 1;
    new_err.innerHTML = "Your password must contain at least 1 lowercase alphabetical character, 1 uppercase alphabetical character, 1 numeric character and 1 special character.";
  }
  
  if (!conf_pwd || !conf_pwd.trim() || conf_pwd.length === 0) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "Please confirm your new password.";
  }
  else if (conf_pwd.length < 8) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "Your new password must be at least 8 characters.";
  }
  else if (!pwd_regex.test(conf_pwd)) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "Your password must contain at least 1 lowercase alphabetical character, 1 uppercase alphabetical character, 1 numeric character and 1 special character.";
  }
  
  if (conf_pwd !== new_pwd) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "Passwords don't match";
  }

  if (new_err.style.opacity == 0 && conf_err.style.opacity == 0) {
    new_err.innerHTML ="";
    conf_err.innerHTML ="";

    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/changeinfo.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    // console.log(`action=cpwd&new_pwd=${new_pwd}&rkey=${key}`);
    req.send(`action=cpwd&new_pwd=${new_pwd}&rkey=${key}`);
    req.onreadystatechange = function() {
      success.style.opacity = 1;
      // console.log(`${req.responseText}`);
      if (req.readyState == 4 && req.status == 200) {
        if (`${req.responseText}` != true)
          success.innerHTML = `${req.responseText}`;
        else {
          success.innerHTML = `Password has been changed`;
        }
      }
    }
  }
}