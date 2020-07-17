  let streaming = false;
  let video = null;
  let canvas = null;
  let canvas2 = null;
  let photo = null;
  let startbutton = null;

  function startup() {
    //console.log("hey");
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    canvas2 = document.getElementById('canvas2');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');
    webcam = document.getElementById("webcam");

    width = document.getElementById("webcam").offsetWidth;
    // //console.log(`${width}`);
    webcam = document.getElementById("webcam");
    photo = document.getElementById("photo");
    overlay = document.getElementById("mydivheader");

    mydiv = document.getElementById("mydiv");
    width2 = width - 4;

    // webcam.style.width = width;
    webcam.style.height = width;
    // //console.log(`${webcam.style.height}`);
    video.style.width  = width;
    video.style.height = width;

    overlay.style.width = width;
    overlay.style.height = width;

    height = width;
    // //console.log(`${overlay.style.width}${overlay.style.height}`);
    let constraints = { audio: false, video: { width: width, height: width } }; 
    navigator.mediaDevices.getUserMedia(constraints)
    .then(function(stream) {
      video.srcObject = stream;
      video.play();
    })
    .catch(function(err) {
      //console.log(`An error occurred:${err}`);
    });

    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        streaming = true;
      }
    }, false);

    startbutton.addEventListener('click', function(ev){
      takepicture();
      ev.preventDefault();
    }, false);

    clearphoto();
  }

  function clearphoto() {
    let context = canvas.getContext('2d');
    context.fillStyle = "#FFF";
    context.fillRect(0, 0, canvas.width, canvas.height);

    let data = canvas.toDataURL('image/png');
  }
  
  function loadImage() {
    return new Promise((resolve, reject) => {
      //console.log('hey');
      err = document.getElementById('err');
      if (!document.getElementById("overlayed")) {
        err = document.getElementById('err');
        err.innerHTML = "Please select a filter";
        reject('err');
      }
      else if (width && height) {
        
        err.innerHTML = "";
        over = document.getElementById("overlayed");
        canvas2.width = over.offsetWidth;
        canvas2.height = over.offsetWidth;
        let ctx = canvas2.getContext('2d');
        let img = new Image();
        img.onload = function() {
          ctx.drawImage(img, 0, 0, canvas2.width, canvas2.width);
          //console.log('heyo');
          resolve();
        };
        // img.src = document.getElementsByClassName('selected_filter')[0].getAttribute('src');
        img.src = document.getElementById("overlayed").src;
        //console.log(`drawing${img.src}`);
		    // //console.log(`${img.src}`);
		    // //console.log(`${mydiv.offsetTop}`);
      }
      else
        reject('err');
    });
  }

  function loadBase() {
    return new Promise((resolve, reject) => {
      //console.log('hey1');
      if (width) {
        //console.log('hey2');
        canvas.width = width;
        canvas.height = width;
        //console.log(canvas.height);
        let ctx2 = canvas.getContext('2d');
        let img2 = new Image();
        img2.onload = function() {
          ctx2.drawImage(img2, 0, 0, canvas.width, canvas.width);
          //console.log(canvas.toDataURL('image/png'));
          data = canvas.toDataURL('image/png');
          resolve();
        };
        img2.src = document.getElementById("video").src;
        //console.log(`drawing${img2.src}`);
      }
      else
        reject('err');
    });
  }

  function sendPicture() {
    return new Promise((resolve, reject) => {
      // canvas = document.getElementById('canvas');
      canvas.width = width;
      canvas.height = width;
      if (!document.getElementsByClassName("uploaded")[0]){
        canvas.getContext('2d').drawImage(video, 0, 0, width, width);
        data = canvas.toDataURL('image/png');
      }

      
      let data2 = canvas2.toDataURL('image/png');
      // //console.log(`img=${data}`);
      // //console.log(`img2=${data2}`);
      let alt = document.getElementsByClassName('selected_filter')[0].getAttribute('alt');
      let xmlHttp = new XMLHttpRequest();
      xmlHttp.open('POST', "./controllers/save.php", true);
      xmlHttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xmlHttp.send(`img=${data}&img2=${data2}&alt=${alt}&left=${mydiv.offsetLeft + 10}&top=${mydiv.offsetTop + 10}&size=${canvas2.width}`);
      xmlHttp.onreadystatechange = function()
      {
        // console.log(`${xmlHttp.responseText}`);
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
          if (xmlHttp.responseText != false) {
          
          gal = document.getElementById('gallery');
          gal.innerHTML = `<li>
	                          <div class="card">
	                            <div class="card-image waves-effect waves-block waves-light">
	                              <img class="activator pic" src="${xmlHttp.responseText}" alt="last">
	                            </div>
	                          </div>
                          </li>
                          ${gal.innerHTML}`;
          // console.log(overlay);
          overlay.innerHTML = "";
          }
          else {
            success = document.getElementById('success');
            success.innerHTML = "An error occured, maybe you took too many pics, please delete some and try again !";
          }
        }
        resolve()
      }
      xmlHttp.onerror = (err) => {
        reject(err);
      }
    })
  }


  function takepicture() {
    if (!document.getElementsByClassName("uploaded")[0]){
      loadImage().then(sendPicture)
      .catch((err) => {
        //console.log(err)
        clearphoto();
      });
    }
    else {
      //console.log("oh!");
      loadImage().then(loadBase).then(sendPicture)
      .catch((err) => {
        //console.log(err)
        clearphoto();
      });
    }
  }


  function resize() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    canvas2 = document.getElementById('canvas2');
    startbutton = document.getElementById('startbutton');
    webcam = document.getElementById("webcam");

    width = webcam.offsetWidth;
    // //console.log(`${width}`);
    webcam = document.getElementById("webcam");
	  overlay = document.getElementById("mydivheader");
    mydiv = document.getElementById("mydiv");
    width2 = width - 4;

    // webcam.style.width = width;
    webcam.style.height = width;
    // //console.log(`${webcam.style.height}`);
    video.style.width  = width;
    video.style.height = width;
    overlay.style.width = width;
    overlay.style.height = width;
  }
  window.addEventListener('load', startup, false);
  window.addEventListener('resize', resize, false);

  function upsize() {
    limit = document.getElementById("video").offsetWidth * 1.5;
    if (img = document.getElementById("overlayed")) {
      if (img.offsetWidth < limit) {
      img.style.width = (img.offsetWidth * 1.1);
      img.style.height = (img.offsetHeight * 1.1);
      }
      loadImage();
    }
    else {
      //console.log("no image to upsize");
    }
  }
  
  function downsize() {
    limit = document.getElementById("video").offsetWidth / 3;
    if (img = document.getElementById("overlayed")) {
      if (img.offsetWidth > limit) {
      img.style.width = (img.offsetWidth / 1.1);
      img.style.height = (img.offsetHeight / 1.1);
      }
      loadImage();
    }
    else {
      //console.log("no image to downsize");
    }
  }


