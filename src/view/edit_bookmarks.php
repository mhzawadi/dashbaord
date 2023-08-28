<?php
require_once('header.php');
?>
<div id="category_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
  <div class="ModalForm_ModalForm__KUznX">
    <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('category_modal', 'frm_category', 'categoryID')">
      <span class="iconify" data-icon="mdi:close" data-width="30"></span>
    </div>
    <form id="frm_category_delete" name="category" method="post" action="/categories/delete">
      <input type="hidden" name="categoryID" id="del_categoryID" value="none">
    </form>
    <form id="frm_category" name="category" method="post" action="/categories/edit">
      <input type="hidden" name="categoryID" id="categoryID" value="none">
      <input type="hidden" name="orderId" id="categoryOrder" value="none">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="name">Category Name</label>
        <input type="text" name="name" id="cat_name" placeholder="Social Media" required="" value="">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="isPublic">Category visibility</label>
        <select id="cat_isPublic" name="isPublic">
          <option value="1">Visible (anyone can access it)</option>
          <option value="0">Hidden (authentication required)</option>
        </select>
      </div>
      <button id="btn_cat" class="Button_Button__1hnZa">Add new category</button>
    </form>
  </div>
</div>
<div id="bookmark_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
  <div class="ModalForm_ModalForm__KUznX">
    <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('bookmark_modal', 'frm_bookmark', 'bookmarkID')">
      <span class="iconify" data-icon="mdi:close" data-width="30"></span>
    </div>
    <form id="frm_bookmark_delete" method="post" action="/bookmarks/<?php echo $urls['id'];?>/delete">
      <input type="hidden" name="bookmarkID" id="del_bookmarkID" value="none">
      <input type="hidden" name="categoryId" id="del_bk_categoryId" value="none">
    </form>
    <form id="frm_bookmark" method="post" action="/bookmarks/<?php echo $urls['id'];?>/edit">
      <input type="hidden" name="bookmarkID" id="bookmarkID" value="none">
      <input type="hidden" name="orderId" id="bookmarkOrder" value="none">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="name">Bookmark Name</label>
        <input type="text" name="name" id="bk_name" placeholder="Reddit" required="" value="">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="url">Bookmark URL</label>
        <input type="text" name="url" id="bk_url" placeholder="reddit.com" required="" value="">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="categoryId">Bookmark Category</label>
        <select name="categoryId" id="bk_categoryId" required="">
          <option value="-1">Select category</option>
          <?php echo $category_options;?>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="icon">Bookmark Icon (optional)</label>
        <input type="text" name="icon" id="bk_icon" placeholder="book-open-outline" value="">
        <input type="file" name="icon_file" id="icon" value="arrow-decision" accept=".jpg,.jpeg,.png,.svg,.ico" style="display: none">
        <span>Use icon name from MDI or pass a valid URL.<a href="https://materialdesignicons.com/" target="blank"> Click here for reference</a>
        <span>Pre-pend `si:` to use simple icons.<a href="https://simpleicons.org/" target="blank"> Click here for reference</a>
        </span>
        <span class="Form_Switch__1wYhY" onclick="show_file_upload('frm_bookmark', 'bk_icon', 'icon')">Switch to custom icon upload</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="isPublic">Bookmark visibility</label>
        <select id="bk_isPublic" name="isPublic">
          <option value="1">Visible (anyone can access it)</option>
          <option value="0">Hidden (authentication required)</option>
        </select>
      </div>
      <button id="btn_bk" class="Button_Button__1hnZa">Add new bookmark</button>
    </form>
  </div>
</div>
<h1 class="Headline_HeadlineTitle__3WjW5">All Bookmarks</h1>
<p class="Headline_HeadlineSubtitle__Aon5D">
<?php if($finish_edits === false){?>
  <a href="/">Go home</a>
<?php }else{?>
  <a href="/bookmarks">Back to bookmarks</a>
<?php }?>
</p>
<div class="Bookmarks_ActionsContainer__1XPAS">
  <div class="ActionButton_ActionButton__3Ckgw" tabindex="0" onclick="openModal('category_modal')">
    <div class="ActionButton_ActionButtonIcon__oPDrT">
      <span class="iconify" data-icon="mdi:plus-box" data-width="18"></span>
    </div>
    <div class="ActionButton_ActionButtonName__32SDW">Add Category</div>
  </div>
  <div class="ActionButton_ActionButton__3Ckgw" tabindex="0" onclick="category_table()">
    <div class="ActionButton_ActionButtonIcon__oPDrT">
      <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>
    </div>
    <div class="ActionButton_ActionButtonName__32SDW">Edit Categories</div>
  </div>
  <?php if($urls['id'] >= 0){?>
    <div class="ActionButton_ActionButton__3Ckgw" tabindex="0" onclick="new_bookmark(<?php echo $urls['id'] ?>, 'bookmark_modal')">
      <div class="ActionButton_ActionButtonIcon__oPDrT">
        <span class="iconify" data-icon="mdi:pencil" data-width="18"></span>
      </div>
      <div class="ActionButton_ActionButtonName__32SDW">Add Bookmark</div>
    </div>
  <?php } if($finish_edits === true){?>
    <div class="ActionButton_ActionButton__3Ckgw" tabindex="0">
      <div class="ActionButton_ActionButtonIcon__oPDrT">
        <span class="iconify" data-icon="mdi:stop-circle-outline" data-width="18"></span>
      </div>
      <div class="ActionButton_ActionButtonName__32SDW">
        <a href="/bookmarks">Finish Editing</a>
      </div>
    </div>
  <?php }?>
</div>
<?php echo $bookmarks;?>
<?php
require_once('footer.php');
?>
