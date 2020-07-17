
gallery = document.getElementById("gallery");

let req = new XMLHttpRequest();
    req.open('POST', "./controllers/gallery.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`jsquery=1`);
    req.onreadystatechange = function() {
			if (req.readyState == 4 && req.status == 200)	{
         window.value = JSON.parse(req.response);
        // //console.log(window.value);
      }
    }
let last_known_scroll_position = 0;
let ticking = false;

  function loadMore(scroll_pos) {
    // console.log(`currentpos= ${scroll_pos}`);
    let limit = (gallery.scrollHeight - gallery.clientHeight) / 1.3;
    // //console.log(`limit =${limit}`);
    if (scroll_pos > limit) {
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
                          <span id="like" class="card-title activator grey-text text-darken-4"><small>likes:${obj[index]['likes']}</small></span>
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
  }

  gallery.addEventListener('scroll', function(e) {
    last_known_scroll_position = gallery.scrollTop;

    if (!ticking) {
      window.requestAnimationFrame(function() {
        loadMore(last_known_scroll_position);
        setTimeout(function() {
          ticking = false;
         } ,300);
      });
      ticking = true;
    }
  });

  function like(img_id) {
    // //console.log(img_id);

    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/like.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`like=${img_id}`);
    req.onreadystatechange = function() {
			if (req.readyState == 4 && req.status == 200)	{
        //console.log(req.responseText);
        refresh_likes();
      }
    }
  }

  function refresh_likes() {
    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/user_likes.php", true);
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`jsquery=1`);
    req.onreadystatechange = function() {
			if (req.readyState == 4 && req.status == 200)	{
        // //console.log(req.response);
        if (req.response != false) {
          let likes = JSON.parse(req.response);
          // console.log(likes);
          let imgs = document.getElementsByClassName('likeicon');
          // //console.log(imgs);
          imgs = Array.from(imgs);
          imgs.forEach(img => {
            img.src = "http://pngimg.com/uploads/heart/heart_PNG51335.png";
            img.setAttribute('alt' ,"like");
            // //console.log(img.alt);
            likes.forEach(like => {
              if (parseInt(like[2]) == parseInt(img.getAttribute("id"))) {
                img.src = "http://pngriver.com/wp-content/uploads/2018/04/Download-Broken-Heart-PNG-File.png";
                img.setAttribute('alt' ,"unlike");
                // //console.log(img.alt);
                // //console.log(`${img.id}${img.src}`);
              }
            });
          });
        }
      }
    }
    refresh_like_count();
  }

  function refresh_like_count() {
    let req = new XMLHttpRequest();
    req.open('POST', "./controllers/gallery.php", true); 
    req.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    req.send(`jsquery=1`);
    req.onreadystatechange = function() {
			if (req.readyState == 4 && req.status == 200)	{
        gall = JSON.parse(req.response);
        gall = Array.from(gall);
        // console.log(gall);
        let imgs = Array.from(document.getElementsByClassName('likeicon'));
        // console.log(imgs);
        gall.forEach(el => {
          imgs.forEach(img => {
            if (img.id == el.img_id){
            // console.log(`el=${el.img_id}img=${img.id}likes=${el.likes}`)
            count = document.getElementById(`${img.id}`).closest('.card-content').children[0].children[1];
            // console.log(count);
            count.innerHTML = `<small>likes:${el.likes}</small>`;
            }
          });
        });
      }
    }
  }
  window.addEventListener('load', refresh_likes, false);
