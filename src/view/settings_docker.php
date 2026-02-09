<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>

<div class="Settings_Settings__2WEZf">
  <?php require_once('settings_menu.php');?>
  <section>
    <form method="post" action="/settings/docker/edit">
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Docker</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerHost">Docker host</label>
        <input type="text" id="dockerHost" name="dockerHost" placeholder="dockerHost:port" value="<?php echo $this->setting_obj['dockerHost'];?>">
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
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Docker agent</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="dockerAgent">Agent Key</label>
        <input type="text" id="dockerAgentKey" name="dockerAgentKey" placeholder="926af0017fc26c061ceef92c5237f0b8" value="<?php echo $this->setting_obj['dockerAgentKey'];?>">
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  </section>
</div>
<?php
require_once('footer.php');
?>
