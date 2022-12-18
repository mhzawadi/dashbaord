      </div>
    </div>
    <script>
    function openModal(elementID) {
      const list = document.getElementById(elementID).classList;
      list.add("Modal_ModalOpen__xRwYI");
      list.remove("Modal_ModalClose__3Cav6");
      // var item = document.getElementById("root");
      // item.addEventListener("click", function() { CloseModal(elementID); }, false);
    }
    function CloseModal(elementID) {
      const list = document.getElementById(elementID).classList;
      list.add("Modal_ModalClose__3Cav6");
      list.remove("Modal_ModalOpen__xRwYI");
    }
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
    </script>
    <script src="//code.iconify.design/1/1.0.6/iconify.min.js"></script>
  </body>
</html>
<script>
