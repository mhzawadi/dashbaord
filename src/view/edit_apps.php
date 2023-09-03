<?php
require_once('header.php');
?>
<div id="application_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
  <div class="ModalForm_ModalForm__KUznX">
    <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('application_modal', 'frm_app', 'applicationID')">
      <span class="iconify" data-icon="mdi:close" data-width="30"></span>
    </div>
    <form id="frm_app_delete" method="post" action="/applications/delete">
      <input type="hidden" name="application_id" id="del_applicationID" value="none">
    </form>
    <form id="frm_app" method="post" action="/applications/edit">
      <input type="hidden" name="application_id" id="applicationID" value="none">
      <input type="hidden" name="orderId" id="applicationOrder" value="none">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="name">App name</label>
        <input type="text" name="name" id="app_name" placeholder="Bookstack" required="" value="">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="url">App URL</label>
        <input type="text" name="url" id="app_url" placeholder="bookstack.example.com" required="" value="">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="description">App description</label>
        <input type="text" name="description" id="app_description" placeholder="My self-hosted app" value="">
        <span>Optional - If description is not set, app URL will be displayed</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="icon">App icon</label>
        <input type="text" name="icon" id="app_icon" placeholder="book-open-outline" value="">
        <input type="file" name="icon_file" id="icon" value="arrow-decision" accept=".jpg,.jpeg,.png,.svg,.ico" style="display: none">
        <span>Use icon name from MDI or pass a valid URL.<a href="https://materialdesignicons.com/" target="blank"> Click here for reference</a>
        <span>Pre-pend `si:` to use simple icons.<a href="https://simpleicons.org/" target="blank"> Click here for reference</a>
        </span>
        <span class="AppForm_Switch__2fvrb" onclick="show_file_upload('frm_app', 'app_icon', 'icon')">Switch to custom icon upload</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="isPublic">App visibility</label>
        <select id="isPublic" name="isPublic">
          <option value="1">Visible (anyone can access it)</option>
          <option value="0">Hidden (authentication required)</option>
        </select>
      </div>
      <button id="btn_app" class="Button_Button__1hnZa">Add new application</button>
    </form>
  </div>
</div>
<h1 class="Headline_HeadlineTitle__3WjW5">All Applications</h1>
<p class="Headline_HeadlineSubtitle__Aon5D">
  <a href="/">Go home</a>
</p>
<div class="Apps_ActionsContainer__1Nn5v">
  <div class="ActionButton_ActionButton__3Ckgw" tabindex="0" onclick="openModal('application_modal')">
    <div class="ActionButton_ActionButtonIcon__oPDrT">
      <span class="iconify" data-icon="mdi:plus-box" data-width="18"></span>
    </div>
    <div class="ActionButton_ActionButtonName__32SDW">Add</div>
  </div>
</div>
<div>
  <?php echo $applications;?>
</div>
<?php
require_once('footer.php');
?>
