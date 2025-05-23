<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>
<div class="Settings_Settings__2WEZf">
  <?php require_once('settings_menu.php');?>
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
    <button class="Button_Button__1hnZa" name="local_login">Login</button>
    <?php if($this->setting_obj['oauth_login'] == 1){?>
    <button class="Button_Button__1hnZa" name="oauth_login">oAuth</button>
    <?php }?>
    </form>
<?php } ?>
<hr class="AppDetails_separator__3gemR">
<div>
  <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">App version</h2>
  <p class="AppDetails_text__1zVc7">
    <a href="https://github.com/mhzawadi/dashbaord" target="_blank" rel="noreferrer">Dashboard</a> version v<?php echo $this->version; ?></p>
    <p class="AppDetails_text__1zVc7">See changelog <a href="https://github.com/mhzawadi/dashbaord/blob/master/CHANGELOG.md" target="_blank" rel="noreferrer">here</a>
    </p>
  </div>
</section>
</div>
<?php
require_once('footer.php');
?>
