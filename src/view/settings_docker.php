<?php
require_once('header.php');
?>
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
    <form>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Docker</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerHost">Docker host</label>
        <input type="text" id="dockerHost" name="dockerHost" placeholder="dockerHost:port" value="localhost">
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerApps">Use Docker API</label>
        <select id="dockerApps" name="dockerApps">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="unpinStoppedApps">Unpin stopped containers / other apps</label>
        <select id="unpinStoppedApps" name="unpinStoppedApps">
          <option value="1">True</option>
          <option value="0">False</option>
        </select>
      </div>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Kubernetes</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="kubernetesApps">Use Kubernetes Ingress API</label>
        <select id="kubernetesApps" name="kubernetesApps">
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
