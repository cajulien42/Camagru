function forgotpwd() {

  let login = document.getElementById('login').value;
  let mail = document.getElementById('email').value;
  let conf_mail = document.getElementById('emailconf').value;
  let err = document.getElementById('email_err');
  let conf_err = document.getElementById('emailconf_err');
  let success = document.getElementById('success_mail');

  success.style.opacity = 0;
  err.style.opacity = 0;
  conf_err.style.opacity = 0;

  err.innerHTML = "";
  conf_err.innerHTML = "";

  const login_regex = /^[a-zA-Z]{2,20}$/;
  const mail_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
  if (!login || !login.trim() || login.length === 0)
	{
		document.getElementById('login_err').style.opacity = 1;
		document.getElementById('login_err').innerHTML = "Please enter your login.";
	}
	else if (login.length > 20)
	{
		document.getElementById('login_err').style.opacity = 1;
		document.getElementById('login_err').innerHTML = "Your login cannot exceed 20 characters.";
	}
	else if (!login_regex.test(login))
	{
		document.getElementById('login_err').style.opacity = 1;
		document.getElementById('login_err').innerHTML = "Your login must contain between 2 and 20 letters.";
	}

  if (!mail || !mail.trim() || mail.length === 0) {
    err.style.opacity = 1;
    err.innerHTML = "Please enter your email.";
  }

  else if (!mail_regex.test(mail)) {
    err.style.opacity = 1;
    err.innerHTML = "please enter a valid mail";
  }
  
  if (!conf_mail || !conf_mail.trim() || conf_mail.length === 0) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "Please confirm your  email.";
  }
  
  else if (!mail_regex.test(conf_mail)) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "please enter a valid mail";
  }
  
  if (conf_mail !== mail) {
    conf_err.style.opacity = 1;
    conf_err.innerHTML = "emails don't match";
  }

  if (err.style.opacity == 0 && conf_err.style.opacity == 0) {
    err.innerHTML ="";
    conf_err.innerHTML ="";

    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/forgotpwd.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`action=rpwd&login=${login}&mail=${mail}`);
    req.onreadystatechange = function() {
      success.style.opacity = 1;
      //console.log(`${req.responseText}`);
      if (req.readyState == 4 && req.status == 200) {
        if (`${req.responseText}` != true)
          success.innerHTML = `${req.responseText}`;
        else {
          success.innerHTML = `A mail has been sent to ${mail}. To reset your password, click on the link in said mail.`;
        }
      }
    }
  }
}