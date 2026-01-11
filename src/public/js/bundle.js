function edit_app(id, name, url, cat_public, icon, description, orderId, submit = false){
  document.getElementById("applicationID").value = id;
  document.getElementById("applicationOrder").value = orderId;
  document.getElementById("app_name").value = name;
  document.getElementById("app_url").value = url;
  document.getElementById("app_icon").value = icon;
  document.getElementById("app_description").value = description;
  const select = document.getElementById("isPublic");
  select.value = cat_public;
  document.getElementById("btn_app").textContent = "Update Application";
  if( submit === true ){
    document.getElementById("frm_app").submit();
  }else{
    openModal("application_modal");
  }

}

function app_order(new_order, id, name, url, cat_public, icon, description, old_order){
  edit_app(id, name, url, cat_public, icon, description, new_order, true);
}

function delete_application(id){
  document.getElementById("del_applicationID").value = id;
  document.getElementById("frm_app_delete").submit();
}

function app_sort(){
  window.location.assign("/applications/order");
}
function category_table(){
  window.location.assign("/categories");
}
function category_edit(cat_id, cat_name, cat_public, orderId, submit = false){
  document.getElementById("categoryID").value = cat_id;
  document.getElementById("cat_name").value = cat_name;
  document.getElementById("categoryOrder").value = orderId;
  const select = document.querySelector("#cat_isPublic");
  select.value = cat_public;
  document.getElementById("btn_cat").textContent = "Update Category";
  if( submit === true ){
    document.getElementById("frm_category").submit();
  }else{
    openModal("category_modal");
  }
}

function category_order(new_order, cat_id, cat_name, cat_public, orderId){
  category_edit(cat_id, cat_name, cat_public, new_order, true);
}

function category_delete(category){
  document.getElementById("del_categoryID").value = category;
  document.getElementById("frm_category_delete").submit();
}

function new_bookmark(option, elementID){
  let select = document.querySelector("#bk_categoryId");
  select.value = option;
  openModal(elementID);
}

// This is to edit bookmarks
function edit_bookmark(id, name, url, cat_option, cat_public, icon, orderId, submit = false){
  let select = document.getElementById("bk_categoryId");
  select.value = cat_option;
  document.getElementById("bookmarkID").value = id;
  document.getElementById("bk_name").value = name;
  document.getElementById("bk_url").value = url;
  document.getElementById("bk_icon").value = icon;
  document.getElementById("bookmarkOrder").value = orderId;
  let isPublic = document.getElementById("bk_isPublic");
  isPublic.value = cat_public;
  document.getElementById("btn_bk").textContent = "Update Application";
  if( submit === true ){
    document.getElementById("frm_bookmark").submit();
  }else{
    openModal("bookmark_modal");
  }
}

function bookmark_order(new_order, id, name, url, cat_option, cat_public, icon, orderId){
  edit_bookmark(id, name, url, cat_option, cat_public, icon, new_order, true);
}

function delete_bookmark(category, id){
  document.getElementById("del_bookmarkID").value = id;
  document.getElementById("del_bk_categoryId").value = category;
  document.getElementById("frm_bookmark_delete").submit();
}
window.onblur = function () { window.onfocus = function () { location.reload(true); }; };

function openModal(elementID, form_elementID = false, form_hidden = false) {
  window.onblur = "";
  const list = document.getElementById(elementID).classList;
  list.add("Modal_ModalOpen__xRwYI");
  list.remove("Modal_ModalClose__3Cav6");
  document.addEventListener("keyup", function(e) {
    if (e.key === "Escape") {
      CloseModal(elementID, form_elementID, form_hidden);
    }
  });
}
function CloseModal(elementID, form_elementID = false, form_hidden = false) {
  window.onblur = function () { window.onfocus = function () { location.reload(true); }; };
  const list = document.getElementById(elementID).classList;
  list.add("Modal_ModalClose__3Cav6");
  list.remove("Modal_ModalOpen__xRwYI");
  if (form_elementID !== false && form_hidden !== false) {
    document.getElementById(form_elementID).reset();
    document.getElementById(form_hidden).value = "none";
  }
}

function show_file_upload(form_elementID, icon_mdi, icon_file) {
  document.getElementById(icon_mdi).style = "display: none";
  document.getElementById(icon_file).style = "";
  document.getElementById(form_elementID).enctype = "multipart/form-data";
}

function sendData(data, url) {
  console.log("Sending data");

  const XHR = new XMLHttpRequest();

  const urlEncodedDataPairs = [];

  // Turn the data object into an array of URL-encoded key/value pairs.
  for (const [name, value] of Object.entries(data)) {
    urlEncodedDataPairs.push(`${encodeURIComponent(name)}=${encodeURIComponent(value)}`);
  }

  // Combine the pairs into a single string and replace all %-encoded spaces to
  // the "+" character; matches the behavior of browser form submissions.
  const urlEncodedData = urlEncodedDataPairs.join("&").replace(/%20/g, "+");

  // Define what happens in case of an error
  XHR.addEventListener("error", (event) => {
    alert("Oops! Something went wrong.");
  });

  // Set up our request
  XHR.open("POST", url);

  // Add the required HTTP header for form data POST requests
  XHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Finally, send our data.
  XHR.send(urlEncodedData);
}
function set_root(colour1, colour2, colour3){
  document.body.style.setProperty("--color-primary", colour2);
  document.body.style.setProperty("--color-accent", colour3);
  document.body.style.setProperty("--color-background", colour1);
  sendData({ defaultTheme: colour2 + ";" + colour3 + ";" + colour1}, "/settings/defaultTheme/edit");
}

function edit_theme(id, name, background, primary, accent){
  document.getElementById("name").value = name;
  document.getElementById("themeID").value = id;
  document.getElementById("background").value = background;
  document.getElementById("primary").value = primary;
  document.getElementById("accent").value = accent;
  document.getElementById("btn_theme").textContent = "Update Theme";
  openModal("ThemeModal");
}
