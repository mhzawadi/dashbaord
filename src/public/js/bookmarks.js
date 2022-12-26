function category_table(){
  window.location.assign("/categories")
}
function category_edit(cat_id, cat_name, cat_public){
  document.getElementById("categoryID").value = cat_id;
  document.getElementById("cat_name").value = cat_name;
  const $select = document.querySelector('#cat_isPublic');
  $select.value = cat_public;
  document.getElementById('btn_cat').textContent = 'Update Category';
  openModal('category_modal')
}

function new_bookmark(option, elementID){
  $select = document.querySelector('#bk_categoryId');
  $select.value = option
  openModal(elementID)
}

// This is to edit bookmarks
function edit_bookmark(id, name, url, cat_option, cat_public, icon){
  $select = document.getElementById('bk_categoryId');
  $select.value = cat_option
  document.getElementById("bookmarkID").value = id;
  document.getElementById("bk_name").value = name;
  document.getElementById("bk_url").value = url;
  document.getElementById("icon").value = icon;
  $select = document.getElementById('bk_isPublic');
  $select.value = cat_public;
  document.getElementById('btn_bk').textContent = 'Update Application';
  openModal('bookmark_modal')
}
