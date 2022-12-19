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
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Docker</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerHost">Docker host</label>
        <input type="text" id="dockerHost" name="dockerHost" placeholder="dockerHost:port" value="<?php echo $this->setting_obj['long'];?>">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerApps">Use Docker API</label>
        <select id="dockerApps" name="dockerApps">
          <option value="1"<?php if($this->setting_obj['dockerApps'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['dockerApps'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="unpinStoppedApps">Unpin stopped containers / other apps</label>
        <select id="unpinStoppedApps" name="unpinStoppedApps">
          <option value="1"<?php if($this->setting_obj['unpinStoppedApps'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['unpinStoppedApps'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Kubernetes</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="kubernetesApps">Use Kubernetes Ingress API</label>
        <select id="kubernetesApps" name="kubernetesApps">
          <option value="1"<?php if($this->setting_obj['kubernetesApps'] == 1){?> selected=""<?php }?>>True</option>
          <option value="0"<?php if($this->setting_obj['kubernetesApps'] == 0){?> selected=""<?php }?>>False</option>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  </section>
</div>
<?php
require_once('footer.php');
?>
