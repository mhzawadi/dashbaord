      </div>
    </div>
    <script>
    function openModal(elementID) {
      const list = document.getElementById(elementID).classList;
      list.add("Modal_ModalOpen__xRwYI");
      list.remove("Modal_ModalClose__3Cav6");
    }
    function CloseModal(elementID) {
      const list = document.getElementById(elementID).classList;
      list.add("Modal_ModalClose__3Cav6");
      list.remove("Modal_ModalOpen__xRwYI");
    }
    function category_table(){
      window.location.assign("/categories")
    }
    function category_edit(cat_name, cat_public){
      document.getElementById("cat_name").value = cat_name;
      document.getElementById("name").value = cat_name;
      const $select = document.querySelector('#isPublic');
      $select.value = cat_public;
      document.getElementById('btn_cat').textContent = 'Update Category';
      openModal('category_modal')
    }
    </script>
  </body>
</html>
<script>
