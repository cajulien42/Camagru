  function notify(uid) {
    //console.log(uid);
    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/notify.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`action=toggle&id=${uid}`);
    req.onreadystatechange = function() {
      if (req.readyState == 4 && req.status == 200) {
        let box = document.getElementById('check');
        //console.log(`${box.checked}`);
        if (box.checked == false) {
          box.setAttribute('checked' , true);
        }
        else {
          box.setAttribute('checked' , false);
        }   
      }
      
    }
  }

  function displayLoginForm() {
    currentform = document.getElementById("showorhide0");
    form1 = document.getElementById("showorhide1");
    form2 = document.getElementById("showorhide2");
    if (getComputedStyle(currentform).getPropertyValue('display')== 'block') {
      currentform.style.display = 'none';
    }
    else if (getComputedStyle(currentform).getPropertyValue('display')== 'none') {
      currentform.style.display = 'block';
      form1.style.display = 'none';
      form2.style.display = 'none';
    }
  }
  
  function displayPwdForm() {
    currentform = document.getElementById("showorhide1");
    form1 = document.getElementById("showorhide0");
    form2 = document.getElementById("showorhide2");
    if (getComputedStyle(currentform).getPropertyValue('display')== 'block') {
      currentform.style.display = 'none';
    }
    else if (getComputedStyle(currentform).getPropertyValue('display')== 'none') {
      currentform.style.display = 'block';
      form1.style.display = 'none';
      form2.style.display = 'none';
    }
  }

  function displayMailForm() {
    currentform = document.getElementById("showorhide2");
    form1 = document.getElementById("showorhide0");
    form2 = document.getElementById("showorhide1");
    if (getComputedStyle(currentform).getPropertyValue('display')== 'block') {
      currentform.style.display = 'none';
    }
    else if (getComputedStyle(currentform).getPropertyValue('display')== 'none') {
      currentform.style.display = 'block';
      form1.style.display = 'none';
      form2.style.display = 'none';
    }
  }

  function ChangePwd(login, user_id) {

    let old_pwd = document.getElementById('oldpassword').value;
    let new_pwd = document.getElementById('newpassword').value;
    let conf_pwd = document.getElementById('newpasswordconf').value;
    let old_err = document.getElementById('oldpasswd_err');
    let new_err = document.getElementById('newpasswd_err');
    let conf_err = document.getElementById('newpasswdconf_err');
    let success = document.getElementById('success');

    success.style.opacity = 0;
    old_err.style.opacity = 0;
    new_err.style.opacity = 0;
    conf_err.style.opacity = 0;

    old_err.innerHTML = "";
    new_err.innerHTML = "";
    conf_err.innerHTML = "";

    const pwd_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;

    if (!old_pwd || !old_pwd.trim() || old_pwd.length === 0) {
	  	old_err.style.opacity = 1;
	  	old_err.innerHTML = "Please enter your old password.";
    }
    
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

    if (old_err.style.opacity == 0 && new_err.style.opacity == 0 && conf_err.style.opacity == 0) {
      old_err.innerHTML ="";
      new_err.innerHTML ="";
      conf_err.innerHTML ="";

      let req = new XMLHttpRequest();
      req.open('POST', "./controllers/changeinfo.php", true); 
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`action=cpwd&login=${login}&id=${user_id}&old_pwd=${old_pwd}&new_pwd=${new_pwd}`);
      req.onreadystatechange = function() {
        success.style.opacity = 1;
        //console.log(`${req.responseText}`);
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

  function ChangeMail(login, user_id) {

    
    let new_mail = document.getElementById('newemail').value;
    let conf_mail = document.getElementById('newemailconf').value;
    let new_err = document.getElementById('newemail_err');
    let conf_err = document.getElementById('newemailconf_err');
    let success = document.getElementById('success_mail');

    success.style.opacity = 0;
    new_err.style.opacity = 0;
    conf_err.style.opacity = 0;

    new_err.innerHTML = "";
    conf_err.innerHTML = "";

    const mail_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    
    if (!new_mail || !new_mail.trim() || new_mail.length === 0) {
	  	new_err.style.opacity = 1;
	  	new_err.innerHTML = "Please enter your new email.";
	  }

	  else if (!mail_regex.test(new_mail)) {
	  	new_err.style.opacity = 1;
	  	new_err.innerHTML = "please enter a valid mail";
    }
    
    if (!conf_mail || !conf_mail.trim() || conf_mail.length === 0) {
	  	conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "Please confirm your new email.";
    }
    
	  else if (!mail_regex.test(conf_mail)) {
	  	conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "please enter a valid mail";
    }
    
    if (conf_mail !== new_mail) {
      conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "emails don't match";
    }

    if (new_err.style.opacity == 0 && conf_err.style.opacity == 0) {
      new_err.innerHTML ="";
      conf_err.innerHTML ="";

      let req = new XMLHttpRequest();
      req.open('POST', "./controllers/changeinfo.php", true); 
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`action=cmail&login=${login}&id=${user_id}&mail=${new_mail}`);
      req.onreadystatechange = function() {
        success.style.opacity = 1;
        //console.log(`${req.responseText}`);
        if (req.readyState == 4 && req.status == 200) {
          if (`${req.responseText}` != true)
            success.innerHTML = `${req.responseText}`;
          else {
            success.innerHTML = `email has been changed`;
          }
        }
      }
    }
  }

  function Changelogin(login, user_id) {

    
    let new_login = document.getElementById('newlogin').value;
    let conf_login = document.getElementById('newloginconf').value;
    let new_err = document.getElementById('newlogin_err');
    let conf_err = document.getElementById('newloginconf_err');
    let success = document.getElementById('success_login');

    success.style.opacity = 0;
    new_err.style.opacity = 0;
    conf_err.style.opacity = 0;

    new_err.innerHTML = "";
    conf_err.innerHTML = "";

    const login_regex = /^[a-zA-Z]{2,20}$/;
    
    if (!new_login || !new_login.trim() || new_login.length === 0) {
	  	new_err.style.opacity = 1;
	  	new_err.innerHTML = "Please enter your new login.";
    }
    
    else if (new_login.length > 20)
    {
      new_err.style.opacity = 1;
	  	new_err.innerHTML = "Your login cannot exceed 20 characters.";
    }

	  else if (!login_regex.test(new_login)) {
	  	new_err.style.opacity = 1;
	  	new_err.innerHTML = "please enter a valid login";
    }
    
    if (!conf_login || !conf_login.trim() || conf_login.length === 0) {
	  	conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "Please confirm your new login.";
    }
    
	  else if (!login_regex.test(conf_login)) {
	  	conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "please enter a valid login";
    }
    
    if (conf_login !== new_login) {
      conf_err.style.opacity = 1;
	  	conf_err.innerHTML = "logins don't match";
    }

    if (new_err.style.opacity == 0 && conf_err.style.opacity == 0) {
      new_err.innerHTML ="";
      conf_err.innerHTML ="";

      let req = new XMLHttpRequest();
      req.open('POST', "./controllers/changeinfo.php", true); 
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`action=clogin&login=${login}&id=${user_id}&new_login=${new_login}`);
      req.onreadystatechange = function() {
        success.style.opacity = 1;
        //console.log(`${req.responseText}`);
        if (req.readyState == 4 && req.status == 200) {
          if (`${req.responseText}` != true)
            success.innerHTML = `${req.responseText}`;
          else {
            success.innerHTML = `login has been changed`;
          }
        }
      }
    }
  }
