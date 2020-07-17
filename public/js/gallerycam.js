
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
    // //console.log(`currentpos= ${scroll_pos}`);
    let limit = (gallery.scrollHeight - gallery.clientHeight) / 1.3;
    // //console.log(`limit =${limit}`);
    if (scroll_pos > limit) {
    let last = document.getElementsByClassName("pic")[document.getElementsByClassName("pic").length - 1]
    // //console.log(last);
    last = last.getAttribute("alt");
    // //console.log(last);
    obj = window.value;
    // //console.log(obj);
    index = parseInt(last) + 1;
    // //console.log(index);
    if (obj[index]) {
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
          // //console.log(likes);
          let imgs = document.getElementsByClassName('likeicon');
          // //console.log(imgs);
          imgs = Array.from(imgs);
          imgs.forEach(img => {
            img.src = "http://pngimg.com/uploads/heart/heart_PNG51335.png";
            img.setAttribute('alt' ,"like");
            // //console.log(img.alt);
            likes.forEach(like => {
              if (parseInt(like[2]) == parseInt(img.getAttribute("id"))) {
                // //console.log(`${img.getAttribute("id")}is liked`);
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
  }
  window.addEventListener('load', refresh_likes, false);
