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
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <form method="post" action="/settings/interface/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Miscellaneous</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="customTitle">Custom page title</label>
        <input type="text" id="customTitle" name="customTitle" placeholder="Flame" value="<?php echo $this->setting_obj['customTitle'];?>">
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Search</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideSearch">Hide search bar</label>
        <select id="hideSearch" name="hideSearch">
          <option value="1"<?php if($this->setting_obj['hideSearch'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['hideSearch'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="disableAutofocus">Disable search bar autofocus</label>
        <select id="disableAutofocus" name="disableAutofocus">
          <option value="1"<?php if($this->setting_obj['disableAutofocus'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['disableAutofocus'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Header</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideHeader">Hide headline (greetings and weather)</label>
        <select id="hideHeader" name="hideHeader">
          <option value="1"<?php if($this->setting_obj['hideHeader'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['hideHeader'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideDate">Hide date</label>
        <select id="hideDate" name="hideDate">
          <option value="1"<?php if($this->setting_obj['hideDate'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['hideDate'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="showTime">Hide time</label>
        <select id="showTime" name="showTime">
          <option value="1"<?php if($this->setting_obj['showTime'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['showTime'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="useAmericanDate">Date formatting</label>
        <select id="useAmericanDate" name="useAmericanDate">
          <option value="1">Friday, October 22 2021</option>
          <option value="0">Friday, 22 October 2021</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="greetingsSchema">Custom greetings</label>
        <input type="text" id="greetingsSchema" name="greetingsSchema" placeholder="Good day;Hi;Bye!" value="<?php echo $this->setting_obj['greetingsSchema'];?>">
        <span>Greetings must be separated with semicolon. All 4 messages must be filled, even if they are the same</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="daySchema">Custom weekday names</label>
        <input type="text" id="daySchema" name="daySchema" placeholder="Sunday;Monday;Tuesday" value="<?php echo $this->setting_obj['daySchema'];?>">
        <span>Names must be separated with semicolon</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="monthSchema">Custom month names</label>
        <input type="text" id="monthSchema" name="monthSchema" placeholder="January;February;March" value="<?php echo $this->setting_obj['monthSchema'];?>">
        <span>Names must be separated with semicolon</span>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Sections</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideApps">Hide applications</label>
        <select id="hideApps" name="hideApps">
          <option value="1"<?php if($this->setting_obj['hideApps'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['hideApps'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideCategories">Hide categories</label>
        <select id="hideCategories" name="hideCategories">
          <option value="1"<?php if($this->setting_obj['hideCategories'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['hideCategories'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  </section>
  </div>
  <?php
  require_once('footer.php');
  ?>
