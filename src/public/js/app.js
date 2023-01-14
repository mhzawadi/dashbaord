function edit_app(id, name, url, cat_public, icon, description, orderId, submit = false){
  document.getElementById("applicationID").value = id;
  document.getElementById("applicationOrder").value = orderId;
  document.getElementById("app_name").value = name;
  document.getElementById("app_url").value = url;
  document.getElementById("app_icon").value = icon;
  document.getElementById("app_description").value = description;
  $select = document.getElementById('isPublic');
  $select.value = cat_public;
  document.getElementById('btn_app').textContent = 'Update Application';
  if( submit === true ){
    document.getElementById("frm_app").submit();
  }else{
    openModal('application_modal');
  }

}

function app_order(new_order, id, name, url, cat_public, icon, description, old_order){
  edit_app(id, name, url, cat_public, icon, description, new_order, true);
}

function delete_application(id){
  document.getElementById("del_applicationID").value = id;
  document.getElementById("frm_app_delete").submit();
}
