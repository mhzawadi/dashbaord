<?php
require_once('header.php');
?>
<div class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
<div class="ModalForm_ModalForm__KUznX">
<div class="ModalForm_ModalFormIcon__3Og8r">
<svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
<path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" style="fill: var(--color-primary);">
</path>
</svg>
</div>
<form>
<div class="InputGroup_InputGroup__1Nm_2">
<label for="name">Category Name</label>
<input type="text" name="name" id="name" placeholder="Social Media" required="" value="">
</div>
<div class="InputGroup_InputGroup__1Nm_2">
<label for="isPublic">Category visibility</label>
<select id="isPublic" name="isPublic">
<option value="1">Visible (anyone can access it)</option>
<option value="0">Hidden (authentication required)</option>
</select>
</div>
<button class="Button_Button__1hnZa">Add new category</button>
</form>
</div>
</div>
        <div id="bookmark_modal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
        <div class="ModalForm_ModalForm__KUznX">
        <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('bookmark_modal')">
        <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z" style="fill: var(--color-primary);">
        </path>
        </svg>
        </div>
        <form>
        <div class="InputGroup_InputGroup__1Nm_2">
        <label for="name">Bookmark Name</label>
        <input type="text" name="name" id="name" placeholder="Reddit" required="" value="">
        </div>
        <div class="InputGroup_InputGroup__1Nm_2">
        <label for="url">Bookmark URL</label>
        <input type="text" name="url" id="url" placeholder="reddit.com" required="" value="">
        </div>
        <div class="InputGroup_InputGroup__1Nm_2">
        <label for="categoryId">Bookmark Category</label>
        <select name="categoryId" id="categoryId" required="">
        <option value="-1">Select category</option>
        </select>
        </div>
        <div class="InputGroup_InputGroup__1Nm_2">
        <label for="icon">Bookmark Icon (optional)</label>
        <input type="text" name="icon" id="icon" placeholder="book-open-outline" value="">
        <span>Use icon name from MDI or pass a valid URL.<a href="https://materialdesignicons.com/" target="blank"> Click here for reference</a>
        </span>
        <span class="Form_Switch__1wYhY">Switch to custom icon upload</span>
        </div>
        <div class="InputGroup_InputGroup__1Nm_2">
        <label for="isPublic">Bookmark visibility</label>
        <select id="isPublic" name="isPublic">
        <option value="1">Visible (anyone can access it)</option>
        <option value="0">Hidden (authentication required)</option>
        </select>
        </div>
        <button class="Button_Button__1hnZa">Add new bookmark</button>
        </form>
        </div>
        </div>
        <h1 class="Headline_HeadlineTitle__3WjW5">All Bookmarks</h1>
        <p class="Headline_HeadlineSubtitle__Aon5D">
          <a href="/">Go back</a>
        </p>
        <div class="Bookmarks_ActionsContainer__1XPAS">
          <div class="ActionButton_ActionButton__3Ckgw" tabindex="0">
            <div class="ActionButton_ActionButtonIcon__oPDrT">
              <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
                <path d="M17,13H13V17H11V13H7V11H11V7H13V11H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" style="fill: var(--color-primary);">
                </path>
              </svg>
            </div>
            <div class="ActionButton_ActionButtonName__32SDW">Add Category</div>
          </div>
          <?php if(isset($args['category']) && $args['category'] !== ''){?>
          <div class="ActionButton_ActionButton__3Ckgw" tabindex="0">
            <div class="ActionButton_ActionButtonIcon__oPDrT">
              <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
                <path d="M17,13H13V17H11V13H7V11H11V7H13V11H17M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" style="fill: var(--color-primary);">
                </path>
              </svg>
            </div>
            <div class="ActionButton_ActionButtonName__32SDW" onclick="openModal('bookmark_modal')">Add Bookmark</div>
          </div>
          <div class="ActionButton_ActionButton__3Ckgw" tabindex="0">
            <div class="ActionButton_ActionButtonIcon__oPDrT">
              <svg viewBox="0 0 24 24" role="presentation" class="Icon_Icon__1Fl5u">
                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" style="fill: var(--color-primary);">
                </path>
              </svg>
            </div>
            <div class="ActionButton_ActionButtonName__32SDW">
              <a href="/bookmarks">Finish Editing</a>
            </div>
          </div>
        <?php }?>
        </div>
        <?php echo $bookmarks;?>
        <a class="Home_SettingsButton__Qvn8C" href="/settings">
          svg icon here
        </a>
<?php
require_once('footer.php');
?>
