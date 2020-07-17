function click_validate()
{

	let login = document.getElementById('last_name').value;
	let mail = document.getElementById('email').value;
	let passwd = document.getElementById('password').value;

	document.getElementById('success').style.opacity = 0;
	document.getElementById('login_err').style.opacity = 0;
	document.getElementById('mail_err').style.opacity = 0;
	document.getElementById('passwd_err').style.opacity = 0;

	document.getElementById('login_err').innerHTML="";
	document.getElementById('mail_err').innerHTML="";
	document.getElementById('passwd_err').innerHTML="";
	
	const login_regex = /^[a-zA-Z]{2,20}$/;
	const mail_regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	const passwd_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;

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

	if (!mail || !mail.trim() || mail.length === 0)
	{
		document.getElementById('mail_err').style.opacity = 1;
		document.getElementById('mail_err').innerHTML = "Please enter your mail.";
	}
	else if (mail.length > 40)
	{
		document.getElementById('mail_err').style.opacity = 1;
		document.getElementById('mail_err').innerHTML = "Your mail cannot exceed 40 characters.";
	}
	else if (!mail_regex.test(mail))
	{
		document.getElementById('mail_err').style.opacity = 1;
		document.getElementById('mail_err').innerHTML = "Please enter a valid email";
	}

	if (!passwd || !passwd.trim() || passwd.length === 0)
	{
		document.getElementById('passwd_err').style.opacity = 1;
		document.getElementById('passwd_err').innerHTML = "Please enter your passwd.";
	}
	else if (passwd.length < 8)
	{
		document.getElementById('passwd_err').style.opacity = 1;
		document.getElementById('passwd_err').innerHTML = "Your passwd must be at least 8 characters.";
	}
	else if (!passwd_regex.test(passwd))
	{
		document.getElementById('passwd_err').style.opacity = 1;
		document.getElementById('passwd_err').innerHTML = "Your password must contain at least 1 lowercase alphabetical character, 1 uppercase alphabetical character, 1 numeric character and 1 special character.";
	}

	if (document.getElementById('login_err').style.opacity == 0 &&
		document.getElementById('mail_err').style.opacity == 0 &&
		document.getElementById('passwd_err').style.opacity == 0)
	{
		document.getElementById('login_err').innerHTML="";
		document.getElementById('mail_err').innerHTML="";
		document.getElementById('passwd_err').innerHTML="";
		
		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open('POST', "./controllers/register.php", true); 
		xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xmlHttp.send(`login=${login}&mail=${mail}&passwd=${passwd}`);
		xmlHttp.onreadystatechange = function()
		{
            document.getElementById('success').style.opacity = 1;
      //       console.log(`login=${login}&mail=${mail}&passwd=${passwd}
			// ${xmlHttp.responseText}${xmlHttp.readyState}${xmlHttp.status}`);
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
			{
				// console.log(`${xmlHttp.responseText}`);
				let el = document.getElementById('success');
				if (`${xmlHttp.responseText}` != true) {
					el.style.opacity = 1;
					el.innerHTML = `${xmlHttp.responseText}`;
				}	

				else
				{
					document.getElementsByClassName('progress')[0].style.opacity = 1;
					el.innerHTML = `Account creation succesful, a confirmation mail has been send to ${mail}.\nRedirecting...`;
					setTimeout(function()
					{
						window.location.href = 'http://localhost:8080/index.php';
					}, 3000);
				}
			}
		}
	}
}