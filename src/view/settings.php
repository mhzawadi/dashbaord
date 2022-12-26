<?php
require_once('header.php');
?>
<img src="/icons/logo-76.png" alt="Logo small">
<h1 class="Headline_HeadlineTitle__3WjW5">Settings</h1>
<p class="Headline_HeadlineSubtitle__Aon5D"><a href="/">Go back</a></p>
<div class="Settings_Settings__2WEZf">
  <nav class="Settings_SettingsNav__14rA1">
    <a class="Settings_SettingsNavLink__1Eo-j Settings_SettingsNavLinkActive__BWxtM" href="/settings">Theme</a>
    <?php if($this->session->isUserAuthenticated()) {?>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/general">General</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/interface">Interface</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/weather">Weather</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/docker">Docker</a>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/css">CSS</a>
  <?php } ?>
    <a class="Settings_SettingsNavLink__1Eo-j" href="/settings/app" aria-current="page">App</a>
  </nav>
  <section>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">App themes</h2>
    <div class="ThemeGrid_ThemerGrid__lljvq">
      <?php foreach($themes['themes'] as $key => $theme){
        if($theme['isCustom'] === false){
          $custom_key = $key?>
      <div class="ThemePreview_ThemePreview__2akEy" onclick="set_root(<?php echo '\''.$theme['colors']['background'].'\',\''.$theme['colors']['primary'].'\',\''.$theme['colors']['accent'].'\'';?>)">
        <div class="ThemePreview_ColorsPreview__1zsZS">
          <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['background'];?>;">
          </div>
          <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['primary'];?>;">
          </div>
          <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['accent'];?>;">
          </div>
        </div>
        <p><?php echo $theme['name'];?></p>
      </div>
    <?php }}?>
    </div>
    <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">User themes</h2>
    <div class="ThemeBuilder_ThemeBuilder__2H2mb">
      <div id="ThemeModal" class="Modal_Modal__1-5dN Modal_ModalClose__3Cav6">
        <div class="ModalForm_ModalForm__KUznX">
          <div class="ModalForm_ModalFormIcon__3Og8r" onclick="CloseModal('ThemeModal', 'frm_theme', 'themeID')">
            <span class="iconify" data-icon="mdi:close" data-width="30"></span>
          </div>
          <form id="frm_theme" action="/settings/theme" method="post">
            <div class="InputGroup_InputGroup__1Nm_2">
              <label for="name">Theme name</label>
              <input type="text" name="name" id="name" placeholder="my_theme" required="" value="">
              <input type="hidden" name="itemID" id="themeID" value="">
            </div>
            <div class="ThemeCreator_ColorsContainer__3NLOS">
              <div class="InputGroup_InputGroup__1Nm_2">
                <label for="primary">Primary color</label>
                <input type="color" name="primary" id="primary" required="" value="#dfd9d6">
              </div>
              <div class="InputGroup_InputGroup__1Nm_2">
                <label for="accent">Accent color</label>
                <input type="color" name="accent" id="accent" required="" value="#98c379">
              </div>
              <div class="InputGroup_InputGroup__1Nm_2">
                <label for="background">Background color</label>
                <input type="color" name="background" id="background" required="" value="#004c2c">
              </div>
            </div>
            <button id="btn_theme" class="Button_Button__1hnZa">Add theme</button>
          </form>
        </div>
      </div>
      <div class="ThemeGrid_ThemerGrid__lljvq">
        <?php foreach($themes['themes'] as $key => $theme){
          if($theme['isCustom'] === true){?>
        <div class="ThemePreview_ThemePreview__2akEy">
          <div class="ThemePreview_ColorsPreview__1zsZS" onclick="set_root(<?php echo '\''.$theme['colors']['background'].'\',\''.$theme['colors']['primary'].'\',\''.$theme['colors']['accent'].'\'';?>)">
            <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['background'];?>;">
            </div>
            <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['primary'];?>;">
            </div>
            <div class="ThemePreview_ColorPreview__34jck" style="background-color: <?php echo $theme['colors']['accent'];?>;">
            </div>
          </div>
          <?php if($this->session->isUserAuthenticated()) {?>
          <p onclick="edit_theme(<?php echo '\''.$key-$custom_key.'\',\''.$theme['name'].'\',\''.$theme['colors']['background'].'\',\''.$theme['colors']['primary'].'\',\''.$theme['colors']['accent'].'\'';?>)">
            <?php echo $theme['name'];?> <span class="iconify" data-icon="mdi:pencil" data-width="18" onclick="edit_theme('ThemeModal')">Edit</span>
          <?php }else{ ?>
            <p><?php echo $theme['name'];?> </p>
          <?php } ?>
          </p>
        </div>
      <?php }}?>
      </div>
      <?php if($this->session->isUserAuthenticated()) {?>
      <div class="ThemeBuilder_Buttons__1xGHJ">
        <button class="Button_Button__1hnZa" onclick="openModal('ThemeModal')">Create new theme</button>
      </div>
    <?php } ?>
    </div>
    <?php if($this->session->isUserAuthenticated()) {?>
    <form>
      <h2 class="SettingsHeadline_SettingsHeadline__1VqV-">Other settings</h2>
      <div class="InputGroup_InputGroup__1Nm_2">
        <label for="defaultTheme">Default theme for new users</label>
        <select id="defaultTheme" name="defaultTheme">
          <?php foreach($themes['themes'] as $key => $theme){
            $theme_colours = $theme['colors']['primary'].';'.$theme['colors']['accent'].';'.$theme['colors']['background'];
            $cur_theme = $this->setting_obj['defaultTheme'];
            if($this->setting_obj['defaultTheme'] == $theme_colours){
              $selected = 'selected=""';
            }else{
              $selected = '';
            }?>
            <option value="<?php echo $theme_colours;?>" <?php echo $selected;?>> <?php if($theme['isCustom'] === true){echo '+ ';} echo $theme['name'];?></option>
          <?php }?>
        </select>
      </div>
      <button class="Button_Button__1hnZa">Save changes</button>
    </form>
  <?php } ?>
  </section>
  </div>
  <?php
  require_once('footer.php');
  ?>
