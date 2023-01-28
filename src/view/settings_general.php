<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D">
  <a href="/">Go back</a>
</p>

<div class="Settings_Settings__2WEZf">
  <?php require_once('settings_menu.php');?>
  <section>
    <form style="margin-bottom: 30px;" method="post" action="/settings/general/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">General</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="useOrdering">Sorting type</label>
        <select id="useOrdering" name="useOrdering">
          <option value="createdAt"<?php if($this->setting_obj['useOrdering'] == 'createdAt'){?> selected=""<?php }?>>By creation date</option>
          <option value="name"<?php if($this->setting_obj['useOrdering'] == 'name'){?> selected=""<?php }?>>Alphabetical order</option>
          <option value="orderId"<?php if($this->setting_obj['useOrdering'] == 'orderId'){?> selected=""<?php }?>>Custom order</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Apps</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="pinAppsByDefault">Pin new applications by default</label>
        <select id="pinAppsByDefault" name="pinAppsByDefault">
          <option value="1"<?php if($this->setting_obj['pinAppsByDefault'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['pinAppsByDefault'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="appsSameTab">Open applications in the same tab</label>
        <select id="appsSameTab" name="appsSameTab">
          <option value="1"<?php if($this->setting_obj['appsSameTab'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['appsSameTab'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Bookmarks</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="pinCategoriesByDefault">Pin new categories by default</label>
        <select id="pinCategoriesByDefault" name="pinCategoriesByDefault">
          <option value="1"<?php if($this->setting_obj['pinCategoriesByDefault'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['pinCategoriesByDefault'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="bookmarksSameTab">Open bookmarks in the same tab</label>
        <select id="bookmarksSameTab" name="bookmarksSameTab">
          <option value="1"<?php if($this->setting_obj['bookmarksSameTab'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['bookmarksSameTab'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Search</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="defaultSearchProvider">Primary search provider</label>
        <select id="defaultSearchProvider" name="defaultSearchProvider">
          <option value="dz"<?php if($this->setting_obj['defaultSearchProvider'] == 'dz'){?> selected=""<?php }?>> Deezer</option>
          <option value="ds"<?php if($this->setting_obj['defaultSearchProvider'] == 'ds'){?> selected=""<?php }?>> Disroot</option>
          <option value="d"<?php if($this->setting_obj['defaultSearchProvider'] == 'd'){?> selected=""<?php }?>> DuckDuckGo</option>
          <option value="g"<?php if($this->setting_obj['defaultSearchProvider'] == 'g'){?> selected=""<?php }?>> Google</option>
          <option value="im"<?php if($this->setting_obj['defaultSearchProvider'] == 'im'){?> selected=""<?php }?>> IMDb</option>
          <option value="l"<?php if($this->setting_obj['defaultSearchProvider'] == 'l'){?> selected=""<?php }?>> Local search</option>
          <option value="r"<?php if($this->setting_obj['defaultSearchProvider'] == 'r'){?> selected=""<?php }?>> Reddit</option>
          <option value="sp"<?php if($this->setting_obj['defaultSearchProvider'] == 'sp'){?> selected=""<?php }?>> Spotify</option>
          <option value="mv"<?php if($this->setting_obj['defaultSearchProvider'] == 'mv'){?> selected=""<?php }?>> The Movie Database</option>
          <option value="td"<?php if($this->setting_obj['defaultSearchProvider'] == 'td'){?> selected=""<?php }?>> Tidal</option>
          <option value="w"<?php if($this->setting_obj['defaultSearchProvider'] == 'w'){?> selected=""<?php }?>> Wikipedia</option>
          <option value="yt"<?php if($this->setting_obj['defaultSearchProvider'] == 'yt'){?> selected=""<?php }?>> YouTube</option>
        </select>
      </div>
      <?php if($this->setting_obj['defaultSearchProvider'] == 'l'){?>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="secondarySearchProvider">Secondary search provider</label>
        <select id="secondarySearchProvider" name="secondarySearchProvider">
          <option value="dz"<?php if($this->setting_obj['secondarySearchProvider'] == 'dz'){?> selected=""<?php }?>> Deezer</option>
          <option value="ds"<?php if($this->setting_obj['secondarySearchProvider'] == 'ds'){?> selected=""<?php }?>> Disroot</option>
          <option value="d"<?php if($this->setting_obj['secondarySearchProvider'] == 'd'){?> selected=""<?php }?>> DuckDuckGo</option>
          <option value="g"<?php if($this->setting_obj['secondarySearchProvider'] == 'g'){?> selected=""<?php }?>> Google</option>
          <option value="im"<?php if($this->setting_obj['secondarySearchProvider'] == 'im'){?> selected=""<?php }?>> IMDb</option>
          <option value="r"<?php if($this->setting_obj['secondarySearchProvider'] == 'r'){?> selected=""<?php }?>> Reddit</option>
          <option value="sp"<?php if($this->setting_obj['secondarySearchProvider'] == 'sp'){?> selected=""<?php }?>> Spotify</option>
          <option value="mv"<?php if($this->setting_obj['secondarySearchProvider'] == 'mv'){?> selected=""<?php }?>> The Movie Database</option>
          <option value="td"<?php if($this->setting_obj['secondarySearchProvider'] == 'td'){?> selected=""<?php }?>> Tidal</option>
          <option value="w"<?php if($this->setting_obj['secondarySearchProvider'] == 'w'){?> selected=""<?php }?>> Wikipedia</option>
          <option value="yt"<?php if($this->setting_obj['secondarySearchProvider'] == 'yt'){?> selected=""<?php }?>> YouTube</option>
        </select>
        <span>Will be used when "Local search" is primary search provider and there are not any local results</span>
      </div>
    <?php }?>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="searchSameTab">Open search results in the same tab</label>
        <select id="searchSameTab" name="searchSameTab">
          <option value="1"<?php if($this->setting_obj['searchSameTab'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['searchSameTab'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Custom search providers</h2>
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
            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Google" required="" value="">
          </div>
          <div class="InputGroup_InputGroup__1Nm_2">
            <label for="name">Prefix</label>
            <input type="text" name="prefix" id="prefix" placeholder="g" required="" value="">
          </div>
          <div class="InputGroup_InputGroup__1Nm_2">
            <label for="name">Query Template</label>
            <input type="text" name="template" id="template" placeholder="https://www.google.com/search?q=" required="" value="">
          </div>
          <button class="Button_Button__1hnZa">Add provider</button>
        </form>
      </div>
    </div>
    <section>
      <button class="Button_Button__1hnZa">Add new search provider</button>
    </section>
  </section>

  </div>
  <?php
  require_once('footer.php');
  ?>
