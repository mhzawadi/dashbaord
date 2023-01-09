function openModal(elementID) {
  const list = document.getElementById(elementID).classList;
  list.add("Modal_ModalOpen__xRwYI");
  list.remove("Modal_ModalClose__3Cav6");
  // var item = document.getElementById("root");
  // item.addEventListener("click", function() { CloseModal(elementID); }, false);
}
function CloseModal(elementID, form_elementID = false, form_hidden = false) {
  const list = document.getElementById(elementID).classList;
  list.add("Modal_ModalClose__3Cav6");
  list.remove("Modal_ModalOpen__xRwYI");
  if(form_elementID !== false && form_hidden !== false){
    document.getElementById( form_elementID ).reset();
    document.getElementById( form_hidden ).value = "none";
  }
}

function show_file_upload(form_elementID, icon_mdi, icon_file){
  document.getElementById(icon_mdi).style = 'display: none';
  document.getElementById(icon_file).style = '';
  document.getElementById( form_elementID ).enctype = 'multipart/form-data';
}

function sendData(data, url) {
  console.log('Sending data');

  const XHR = new XMLHttpRequest();

  const urlEncodedDataPairs = [];

  // Turn the data object into an array of URL-encoded key/value pairs.
  for (const [name, value] of Object.entries(data)) {
    urlEncodedDataPairs.push(`${encodeURIComponent(name)}=${encodeURIComponent(value)}`);
  }

  // Combine the pairs into a single string and replace all %-encoded spaces to
  // the '+' character; matches the behavior of browser form submissions.
  const urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');

  // Define what happens in case of an error
  XHR.addEventListener('error', (event) => {
    alert('Oops! Something went wrong.');
  });

  // Set up our request
  XHR.open('POST', '/settings/defaultTheme/edit');

  // Add the required HTTP header for form data POST requests
  XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // XHR.onload = () => {
  //   if (XHR.readyState === XHR.DONE && XHR.status === 200) {
  //     console.log(XHR.response, XHR.responseXML);
  //   }
  // };

  // Finally, send our data.
  XHR.send(urlEncodedData);
}
