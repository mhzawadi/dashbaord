<?php
require_once('header.php');
?>
<div class="Settings_Settings__2WEZf">
  <nav class="Settings_SettingsNav__14rA1">
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings">Theme</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/general">General</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <form>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="customStyles">Custom CSS</label>
        <textarea id="customStyles" name="customStyles" spellcheck="false">.BookmarkCard_Bookmarks__YhsfD {
          font-size: large;
        }

        @media (min-width: 1201px) {
          .Layout_Container__2Hv3J {
            padding: 0px 0px;
          }
        }</textarea>
      </div>
      <button class="Button_Button__1hnZa">Save CSS</button>
    </form>
  </section>
</div>
<?php
require_once('footer.php');
?>
