<?php
require_once('header.php');
?>
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
    <form>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Miscellaneous</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="customTitle">Custom page title</label>
        <input type="text" id="customTitle" name="customTitle" placeholder="Flame" value="Horwood Links">
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Search</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideSearch">Hide search bar</label>
        <select id="hideSearch" name="hideSearch">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="disableAutofocus">Disable search bar autofocus</label>
        <select id="disableAutofocus" name="disableAutofocus">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Header</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideHeader">Hide headline (greetings and weather)</label>
        <select id="hideHeader" name="hideHeader">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideDate">Hide date</label>
        <select id="hideDate" name="hideDate">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="showTime">Hide time</label>
        <select id="showTime" name="showTime">
          <option value="0">True</option>
          <option value="1">False</option>
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
        <input type="text" id="greetingsSchema" name="greetingsSchema" placeholder="Good day;Hi;Bye!" value="Good evening!;Good afternoon!;Good morning!;Good night!">
        <span>Greetings must be separated with semicolon. All 4 messages must be filled, even if they are the same</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="daySchema">Custom weekday names</label>
        <input type="text" id="daySchema" name="daySchema" placeholder="Sunday;Monday;Tuesday" value="Sunday;Monday;Tuesday;Wednesday;Thursday;Friday;Saturday">
        <span>Names must be separated with semicolon</span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="monthSchema">Custom month names</label>
        <input type="text" id="monthSchema" name="monthSchema" placeholder="January;February;March" value="January;February;March;April;May;June;July;August;September;October;November;December">
        <span>Names must be separated with semicolon</span>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Sections</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideApps">Hide applications</label>
        <select id="hideApps" name="hideApps">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="hideCategories">Hide categories</label>
        <select id="hideCategories" name="hideCategories">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  </section>
  </div>
  <?php
  require_once('footer.php');
  ?>
