const url = './controllers/upload.php';
const form = document.querySelector('form');

form.addEventListener('submit', e => {
  e.preventDefault()

	const file = document.querySelector('[type=file]').files[0]
  const formData = new FormData()
  //console.log(`file=${file}`)
  formData.append('file', file)
  let req = new XMLHttpRequest();
  req.open("POST", url);
  req.send(formData);
  req.onreadystatechange = function() {
    if (req.readyState == 4 && req.status == 200)	{
      //console.log(req.responseText);
      let success = document.getElementById('success');
      if (req.responseText == false) {
        success.style.opacity = 1;
        success.innerHTML = "File must have a valid name, be smaller than 500kB and be a png file. and also be awesome.";
      }
      else {
        let width = document.getElementById('video').offsetWidth;
        let base = document.getElementById("base");
        success.innerHTML = "success";
        success.style.opacity = 1;
        base.innerHTML = `<img id="video" class="uploaded" src="${req.responseText}" alt="uploaded"/>`;
        let img = document.getElementById('video');
        img.style.width = width;
        img.style.height = width;
        let all = document.querySelectorAll('#video');
        //console.log(all); 
      }
    }
  }

  // fetch(url, {
  //   method: 'POST',
  //   body: formData,
  // }).then(response => {
  //   //console.log(`GNE:${response}`)
  // })
})
