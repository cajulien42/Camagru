function select_filter(filter_id) {
//   let overlay = document.getElementById('overlay');
  let overlay = document.getElementById('mydivheader');
  let filter_link = document.getElementById(filter_id);
  // //console.log(`id=${filter_id}`);
  // let filter_alt = filter_link.firstChild.getAttribute('alt');
  let filter_url = filter_link.firstChild.getAttribute('src');
  // //console.log(`name=${filter_name} id=${filter_id} url=${filter_url}`);
  overlay.innerHTML= `<img id="overlayed" class="selected_filter" src=${filter_url} alt=${filter_id}>`;
}
