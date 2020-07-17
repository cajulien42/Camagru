  function delete_img(img_id, num) {
  	deleteFromDataBase(img_id, num).then(deleteFromPage)
  	.catch((err) => {
  	  //console.log(err)
  	});
  }

  function deleteFromDataBase(img_id, num) {
    return new Promise((resolve, reject) => {
      loadoneMore();
      let req = new XMLHttpRequest();
      req.open('POST', "./controllers/delete_img.php");
      req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req.send(`delete=${img_id}`);
      req.onreadystatechange = function() {
        if (req.readyState == 4 && req.status == 200)	{
        // console.log(`${req.responseText}`);
        }
      resolve(num);
      }
      req.onerror = (err) => {
        reject(err);
      }
    });
  }

  function deleteFromPage(num) {
      
      list = document.getElementById("gallery");
      elem = list.children[num];
      //console.log(elem);
      elem.style.display = 'none';
  }

  function loadoneMore() {
    // //console.log(`currentpos= ${scroll_pos}`);
    let last = document.getElementsByClassName("pic")[document.getElementsByClassName("pic").length - 1]
    // //console.log(last);
    last = last.getAttribute("alt");
    // //console.log(last);
    obj = window.value;
    // console.log(obj);
    index = parseInt(last) + 1;
    // //console.log(index);
    if (obj[index] && obj[index]['login'] == obj[0]['login']) {
      src = obj[index][1];
      img_id = obj[index][0];
      // //console.log(`${src}${index}`);
      let req2 = new XMLHttpRequest();
      req2.open('POST', "./controllers/logged.php", true);
      req2.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      req2.send(`jsquery=1`);
      req2.onreadystatechange = function() {
			  if (req2.readyState == 4 && req2.status == 200)	{
          window.logged = req2.responseText;
          //console.log(window.logged);
          let add = `<li>
                    <div class="card">
                      <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator pic" src="${src}" alt="${index}">
                      </div>
                      <div class="card-content">
                        <div class="line">
                          <span class="card-title activator grey-text text-darken-4">${obj[index]['login']}</span>
                          <span class="card-title activator grey-text text-darken-4"><small>likes:${obj[index]['likes']}</small></span>
                        </div>
                        <div class="line">
                          <img class="material-icon commenticon" src="https://png.pngtree.com/svg/20170121/201c2dc59c.png" onclick="delete_img(${img_id}, ${index})">
                          <i class="material-icons"><img id="${img_id}" class ="likeicon" src="http://pngimg.com/uploads/heart/heart_PNG51335.png" onclick="like(${img_id})" alt="like"></i>
                        </div>
                      </div>
                    </div>
                    </li>`;
          gallery.innerHTML = `${gallery.innerHTML}${add}`;
          refresh_likes();
          }
        }
      }
    }




