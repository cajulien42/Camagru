function img_comment(img_id, num) {
  addComments(img_id, num).then(loadComments)
  .catch((err) => {
    //console.log(err)
  });
}
  
  function loadComments(img_id) {
    return new Promise((resolve, reject) => {
      let req = new XMLHttpRequest();
      req.open('POST',"./controllers/loadcomments.php", true);
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`img_id=${img_id}`);
      req.onreadystatechange = function() {
      if (req.readyState == 4 && req.status == 200) {
        // //console.log(`${req.responseText}`);
        let tab =JSON.parse(req.response);
		    //   //console.log(tab);
		    tab = Array.from(tab);
        let commlist = document.getElementById("pic_comments");
		    commlist.innerHTML = "";
		    tab.forEach(comment => {
			    let date = new Date(comment['com_date'] * 1000);
			    date = `${date.getUTCDate()}/${date.getMonth()}/${date.getFullYear()} at ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`;
			    // //console.log(comment['text']);
			    commlist.innerHTML = 
			      `${commlist.innerHTML}
			      <div class="dialogbox">
			      <span>${comment['com_login']} ${date}</span>
			      	<div class="body">
			    		<span class="tip tip-left"></span>
			    		<div class="message">
			    	  		<span>${comment['text']}</span>
			    		</div>
			      	</div>
			    </div>`
		      });
        resolve();
        }
      }
      req.onerror = (err) => {
        reject(err);
      }
    });
  }

  function addComments(img_id, num) {
    return new Promise((resolve, reject) => {
      const text_regex = /^[a-zA-Z0-9 .=\/*\-+()[\]{}!@#\$%\^&\*\"'\/?,:;_]+$/m;
      let text = document.getElementsByTagName('textarea');
      temp = Array.from(text);
      text = temp[num].value;
    //   //console.log(`id:${img_id}text:${text}`);
      let req = new XMLHttpRequest();
      req.open('POST', "./controllers/addcomment.php", true); 
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`img_id=${img_id}&text=${text}`);
      req.onreadystatechange = function() {
  	  	if (req.readyState == 4 && req.status == 200)	{
          // //console.log(req.responseText);
          if (req.response != false && text_regex.test(text)) {
            let tab =JSON.parse(req.response)
            let msg = `<html>
            <head>
            </head>
            <body>
                <p>Hi ${tab['login']},</p>
                <p>Someone just commented one of your awesome pics !!!</p>
                <p> Here it is :"${tab['msg']}"</p>
            <body>
            </html>`;
            let req1 = new XMLHttpRequest();
            req1.open('POST', "./controllers/notify.php", true); 
            req1.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            req1.send(`action=notify&mail=${tab['mail']}`);
            req1.onreadystatechange = function() {
              if (req1.readyState == 4 && req1.status == 200)	{
				        // console.log(`${req1.responseText}`);
                if (`${req1.responseText}` == true) {
                  let req2 = new XMLHttpRequest();
                  req2.open('POST', "./controllers/email.php", true); 
                  req2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                  req2.send(`email=${tab['mail']}&message=${msg}&subject=[Camagru]`);
                  req2.onreadystatechange = function() {
                    if (req2.readyState == 4 && req2.status == 200)	{
				              // console.log(`${req2.responseText}`);
				              temp[num].value = '';
			              }
                  }
			          }
              }  
			      resolve(img_id);
            }
          }
        }
      }
      req.onerror = (err) => {
        reject(err);
      }
    });
  }

  function display_comment(img_id, num) {
    let area = document.getElementsByClassName("comment");
  area = Array.from(area);
  // console.log(area);
	window.count = 0;
	area.forEach(zone => { 
		if (window.count != num && getComputedStyle(zone).getPropertyValue('display') == 'block') {
			zone.style.display = 'none';
		}
		window.count++;
	});
    // console.log(getComputedStyle(area[num]).getPropertyValue('display'));
    if (getComputedStyle(area[num]).getPropertyValue('display') == 'none') {
	  area[num].style.display = 'block';
	  loadComments(img_id, num);
    }
    else if (getComputedStyle(area[num]).getPropertyValue('display')== 'block') {
		let commlist = document.getElementById("pic_comments");
		commlist.innerHTML = "";
		area[num].style.display = 'none';
	}
  }
