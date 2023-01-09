<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>
<div class="Settings_Settings__2WEZf">
  <nav class="Settings_SettingsNav__14rA1">
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings">Theme</a>
    <?php if($this->logged_in === true) {?>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/general">General</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
  <?php } ?>
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
  <?php if($this->logged_in === true) {?>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Authentication</h2>
    <div>
      <p class="AppDetails_text__1zVc7">You are logged in. Your session will expire <span><?php echo $this->session->get_logout();?></span>
      </p>
      <form method="post" action="/settings/logout">
        <button class="Button_Button__1hnZa">Logout</button>
      </form>
    </div>
<?php }else{ ?>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Authentication</h2>
    <?php echo $txt;?>
    <form method="post" action="/settings/login">
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="••••••" autocomplete="current-password" value="">
        <!-- <span>See<a href="https://github.com/pawelmalak/flame/wiki/Authentication" target="blank"> project wiki </a>to read more about authentication</span> -->
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="duration">Session duration</label>
          <select id="duration" name="duration">
          <option value="PT1H">1 hour</option>
          <option value="P1D">1 day</option>
          <option value="P14D" selected>2 weeks</option>
          <option value="P30D">1 month</option>
          <option value="P1Y">1 year</option>
        </select>
      </div>
    <button class="Button_Button__1hnZa">Login</button>
    </form>
<?php } ?>
<hr class="AppDetails_separator__3gemR">
<div>
  <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">App version</h2>
  <p class="AppDetails_text__1zVc7">
    <a href="https://github.com/mhzawadi/dashbaord" target="_blank" rel="noreferrer">Dashboard</a> version 0.0.1</p>
    <p class="AppDetails_text__1zVc7">See changelog <a href="https://github.com/mhzawadi/dashbaord/blob/master/CHANGELOG.md" target="_blank" rel="noreferrer">here</a>
    </p>
  </div>
</section>
</div>
<?php
require_once('footer.php');
?>
