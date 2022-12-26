function edit_app(id, name, url, cat_public, icon, description){
  document.getElementById("applicationID").value = id;
  document.getElementById("app_name").value = name;
  document.getElementById("app_url").value = url;
  document.getElementById("app_icon").value = icon;
  document.getElementById("app_description").value = description;
  $select = document.getElementById('isPublic');
  $select.value = cat_public;
  document.getElementById('btn_app').textContent = 'Update Bookmark';
  openModal('application_modal')
}
