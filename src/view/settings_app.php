<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>
<div class="Settings_Settings__2WEZf">
  <nav class="Settings_SettingsNav__14rA1">
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings">Theme</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/general">General</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section style="display: none;">
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Authentication</h2>
    <form data-bitwarden-watching="1">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••" autocomplete="current-password" value="">
        <span>See<a href="https://github.com/pawelmalak/flame/wiki/Authentication" target="blank"> project wiki </a>to read more about authentication</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="duration">Session duration</label>
          <select id="duration" name="duration">
          <option value="1h">1 hour</option>
          <option value="1d">1 day</option>
          <option value="14d">2 weeks</option>
          <option value="30d">1 month</option>
          <option value="1y">1 year</option>
        </select>
      </div>
    <button class="Button_Button__1hnZa">Login</button>
    </form>
  </section>
  <section>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Authentication</h2>
    <div>
      <p class="AppDetails_text__1zVc7">You are logged in. Your session will expire <span>25/12/2022 21:04:50</span>
      </p>
      <button class="Button_Button__1hnZa">Logout</button>
    </div>
    <hr class="AppDetails_separator__3gemR">
    <div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">App version</h2>
      <p class="AppDetails_text__1zVc7">
        <a href="https://github.com/pawelmalak/flame" target="_blank" rel="noreferrer">Flame</a> version 2.3.0</p>
        <p class="AppDetails_text__1zVc7">See changelog <a href="https://github.com/pawelmalak/flame/blob/master/CHANGELOG.md" target="_blank" rel="noreferrer">here</a>
        </p>
        <button class="Button_Button__1hnZa">Check for updates</button>
      </div>
  </section>
</div>
<?php
require_once('footer.php');
?>
