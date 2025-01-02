function category_table(){
  window.location.assign("/categories");
}
function category_edit(cat_id, cat_name, cat_public, orderId, submit = false){
  document.getElementById("categoryID").value = cat_id;
  document.getElementById("cat_name").value = cat_name;
  document.getElementById("categoryOrder").value = orderId;
  const $select = document.querySelector("#cat_isPublic");
  $select.value = cat_public;
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
  $select = document.querySelector("#bk_categoryId");
  $select.value = option;
  openModal(elementID);
}

// This is to edit bookmarks
function edit_bookmark(id, name, url, cat_option, cat_public, icon, orderId, submit = false){
  $select = document.getElementById("bk_categoryId");
  $select.value = cat_option;
  document.getElementById("bookmarkID").value = id;
  document.getElementById("bk_name").value = name;
  document.getElementById("bk_url").value = url;
  document.getElementById("bk_icon").value = icon;
  document.getElementById("bookmarkOrder").value = orderId;
  const $select = document.getElementById("bk_isPublic");
  $select.value = cat_public;
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
