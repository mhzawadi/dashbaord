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
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <form method="post" action="/settings/weather/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">API</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="WEATHER_API_KEY">API key</label>
        <input type="text" id="WEATHER_API_KEY" name="WEATHER_API_KEY" placeholder="secret" value="<?php echo $this->setting_obj['WEATHER_API_KEY'];?>">
        <span>Using<a href="https://www.weatherapi.com/pricing.aspx" target="blank"> Weather API</a>. Key is required for weather module to work.</span>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Location</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="lat">Latitude</label>
        <input type="number" id="lat" name="lat" placeholder="52.22" step="any" lang="en-150" value="<?php echo $this->setting_obj['lat'];?>">
        <span>
          <a href="#">Click to get current location</a>
        </span>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="long">Longitude</label>
        <input type="number" id="long" name="long" placeholder="21.01" step="any" lang="en-150" value="<?php echo $this->setting_obj['long'];?>">
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Other</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="isCelsius">Temperature unit</label>
        <select id="isCelsius" name="isCelsius">
          <option value="1"<?php if($this->setting_obj['isCelsius'] == 1){?> selected=""<?php }?>>Celsius</option>
          <option value="0"<?php if($this->setting_obj['isCelsius'] == 0){?> selected=""<?php }?>>Fahrenheit</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="weatherData">Additional weather data</label>
        <select id="weatherData" name="weatherData">
          <option value="cloud"<?php if($this->setting_obj['weatherData'] == 1){?> selected=""<?php }?>>Cloud coverage</option>
          <option value="humidity"<?php if($this->setting_obj['weatherData'] == 0){?> selected=""<?php }?>>Humidity</option>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  </section>
  </div>
  <?php
  require_once('footer.php');
  ?>
