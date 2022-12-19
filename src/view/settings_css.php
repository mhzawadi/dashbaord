<?php
require_once('header.php');
?>
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>

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
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>/edit">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="customStyles">Custom CSS</label>
        <textarea id="customStyles" name="customStyles" spellcheck="false">
<?php
echo $this->settings->load_css();
?>
        </textarea>
      </div>
      <button class="Button_Button__1hnZa">Save CSS</button>
    </form>
  </section>
</div>
<?php
require_once('footer.php');
?>
