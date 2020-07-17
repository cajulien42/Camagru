function click_login_validate()
{
	let login = document.getElementById('last_name').value;
	let passwd = document.getElementById('password').value;


	document.getElementById('login_err').style.opacity = 0;
  document.getElementById('passwd_err').style.opacity = 0;
	document.getElementById('success').style.opacity = 0;
	
	document.getElementById('login_err').innerHTML="";
	document.getElementById('passwd_err').innerHTML="";
	
	const login_regex = /^[a-zA-Z]{2,20}$/;
	const passwd_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,255})/;

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
		document.getElementById('passwd_err').style.opacity == 0)
	{
		document.getElementById('login_err').innerHTML="";
		document.getElementById('passwd_err').innerHTML="";

		let xmlHttp = new XMLHttpRequest();
		xmlHttp.open('POST', "./controllers/login.php", true); 
		xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xmlHttp.send(`login=${login}&passwd=${passwd}`);
		xmlHttp.onreadystatechange = function()
		{

            // //console.log(`login=${login}&passwd=${passwd}
            // ${xmlHttp.responseText}${xmlHttp.readyState}${xmlHttp.status}`);
			if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
			{
				let el = document.getElementById('success');
				//console.log(`${xmlHttp.responseText}`);
				if (`${xmlHttp.responseText}` !== "OK") {
					el.style.opacity = 1;
					el.innerHTML = `${xmlHttp.responseText}`;
				}
				else
				{
					document.getElementsByClassName('progress')[0].style.opacity = 1;
					el.innerHTML = `Login successful.\nRedirecting...`;
					setTimeout(function()
					{
						window.location.href = 'http://localhost:8080/index.php';
					}, 3000);
				}
			}
		}
	}
}