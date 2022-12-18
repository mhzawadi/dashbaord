<?php
require_once('header.php');
?>
<div class="Settings_Settings__2WEZf">
  <nav class="Settings_SettingsNav__14rA1">
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings">Theme</a>
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/general">General</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <form style="margin-bottom: 30px;">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">General</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="useOrdering">Sorting type</label>
        <select id="useOrdering" name="useOrdering">
          <option value="createdAt">By creation date</option>
          <option value="name">Alphabetical order</option>
          <option value="orderId">Custom order</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Apps</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="pinAppsByDefault">Pin new applications by default</label>
        <select id="pinAppsByDefault" name="pinAppsByDefault">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="appsSameTab">Open applications in the same tab</label>
        <select id="appsSameTab" name="appsSameTab">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Bookmarks</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="pinCategoriesByDefault">Pin new categories by default</label>
        <select id="pinCategoriesByDefault" name="pinCategoriesByDefault">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="bookmarksSameTab">Open bookmarks in the same tab</label>
        <select id="bookmarksSameTab" name="bookmarksSameTab">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Search</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="defaultSearchProvider">Primary search provider</label>
        <select id="defaultSearchProvider" name="defaultSearchProvider">
          <option value="dz"> Deezer</option>
          <option value="ds"> Disroot</option>
          <option value="d"> DuckDuckGo</option>
          <option value="g"> Google</option>
          <option value="im"> IMDb</option>
          <option value="l"> Local search</option>
          <option value="r"> Reddit</option>
          <option value="sp"> Spotify</option>
          <option value="mv"> The Movie Database</option>
          <option value="td"> Tidal</option>
          <option value="w"> Wikipedia</option>
          <option value="yt"> YouTube</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="searchSameTab">Open search results in the same tab</label>
        <select id="searchSameTab" name="searchSameTab">
          <option value="1">True</option>
          <option value="0">False</option>
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
