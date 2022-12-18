<?php
require_once('header.php');
?>
<div id="application_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
  <div class="ModalForm_ModalForm__KUznX">
    <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('application_modal')">
      <span class="iconify" data-icon="mdi:close" data-width="30"></span>
    </div>
    <form method="post" action="/application_edit">
      <input type="hidden" name="application_id" id="applicationID" value="0">
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
        <input type="text" name="icon" id="app_icon" placeholder="book-open-outline" required="" value="">
        <span>Use icon name from MDI or pass a valid URL.<a href="https://materialdesignicons.com/" target="blank"> Click here for reference</a>
        </span>
        <span class="AppForm_Switch__2fvrb">Switch to custom icon upload</span>
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
  <a href="/">Go back</a>
</p>
<div class="Apps_ActionsContainer__1Nn5v">
  <div class="ActionButton_ActionButton__3Ckgw" tabindex="0" onclick="openModal('application_modal')">
    <div class="ActionButton_ActionButtonIcon__oPDrT">
      <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
        <path d="M17,13H13V17H11V13H7V11H11V7H13V11H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" style="fill: var(--color-primary);">
        </path>
      </svg>
    </div>
    <div class="ActionButton_ActionButtonName__32SDW">Add</div>
  </div>
</div>
<div>
  <?php echo $applications;?>
</div>
<a class="Home_SettingsButton__Qvn8C" href="/settings">
  <span class="iconify" data-icon="mdi:cog-box" data-width="30"></span>
</a>
<?php
require_once('footer.php');
?>
